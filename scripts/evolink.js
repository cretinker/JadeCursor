#!/usr/bin/env node
/**
 * EvoLink AI Universal Asset Generator CLI
 * Supports: gpt-image-2, flux, kling-v3, seedance, etc.
 * Uses: process.env.EVOLINK_API_KEY
 */

const https = require('https');
const fs = require('fs');
const path = require('path');

const API_KEY = process.env.EVOLINK_API_KEY;

if (!API_KEY) {
  console.error('Error: EVOLINK_API_KEY environment variable is not set.');
  process.exit(1);
}

function request(options, postData = null) {
  return new Promise((resolve, reject) => {
    const req = https.request(options, (res) => {
      let data = '';
      res.on('data', chunk => data += chunk);
      res.on('end', () => {
        try {
          const json = JSON.parse(data);
          resolve({ status: res.statusCode, data: json });
        } catch (e) {
          resolve({ status: res.statusCode, raw: data });
        }
      });
    });
    req.on('error', reject);
    if (postData) req.write(postData);
    req.end();
  });
}

function sleep(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
}

async function pollTask(taskId, maxAttempts = 120, intervalMs = 3000) {
  console.log(`Polling task: ${taskId} ...`);
  for (let attempt = 1; attempt <= maxAttempts; attempt++) {
    const res = await request({
      hostname: 'api.evolink.ai',
      path: `/v1/tasks/${taskId}`,
      method: 'GET',
      headers: { 'Authorization': `Bearer ${API_KEY}` }
    });

    if (res.status !== 200) {
      console.warn(`[Poll ${attempt}] Warning: Status ${res.status}`);
    } else {
      const task = res.data;
      const progress = task.progress !== undefined ? `${task.progress}%` : '';
      console.log(`[Attempt ${attempt}] Status: ${task.status} ${progress}`);

      if (task.status === 'completed') {
        const results = task.results || (task.result_data && task.result_data.map(r => r.url)) || [];
        return { success: true, urls: results, task };
      } else if (task.status === 'failed' || task.status === 'error') {
        return { success: false, error: task.error || 'Task failed' };
      }
    }
    await sleep(intervalMs);
  }
  throw new Error('Polling timed out.');
}

function downloadFile(url, destPath) {
  return new Promise((resolve, reject) => {
    const dir = path.dirname(destPath);
    if (!fs.existsSync(dir)) {
      fs.mkdirSync(dir, { recursive: true });
    }
    const file = fs.createWriteStream(destPath);
    https.get(url, (res) => {
      res.pipe(file);
      file.on('finish', () => {
        file.close(() => resolve(destPath));
      });
    }).on('error', (err) => {
      fs.unlink(destPath, () => {});
      reject(err);
    });
  });
}

async function generateImage({ prompt, model = 'gpt-image-2', size = '1024x1024', output = null }) {
  console.log(`\n🎨 Generating Image with model: [${model}]`);
  console.log(`Prompt: "${prompt}"`);

  const payload = JSON.stringify({
    model,
    prompt,
    size
  });

  const res = await request({
    hostname: 'api.evolink.ai',
    path: '/v1/images/generations',
    method: 'POST',
    headers: {
      'Authorization': `Bearer ${API_KEY}`,
      'Content-Type': 'application/json',
      'Content-Length': Buffer.byteLength(payload)
    }
  }, payload);

  if (res.status !== 200 || !res.data.id) {
    throw new Error(`Failed to create task: ${JSON.stringify(res.data || res.raw)}`);
  }

  const taskId = res.data.id;
  console.log(`Task created successfully! Task ID: ${taskId}`);

  const pollResult = await pollTask(taskId);
  if (!pollResult.success || !pollResult.urls.length) {
    throw new Error(`Generation failed: ${JSON.stringify(pollResult)}`);
  }

  const imageUrl = pollResult.urls[0];
  console.log(`\n Image Ready: ${imageUrl}`);

  if (output) {
    const savedPath = await downloadFile(imageUrl, output);
    console.log(` Saved locally to: ${savedPath}`);
    return { url: imageUrl, file: savedPath };
  }

  return { url: imageUrl };
}

async function generateVideo({ prompt, model = 'kling-v3-image-to-video', imageUrl = null, duration = 5, output = null }) {
  console.log(`\n Generating Video with model: [${model}]`);
  console.log(`Prompt: "${prompt}"`);

  const body = {
    model,
    prompt,
    duration
  };
  if (imageUrl) {
    body.image_url = imageUrl;
  }

  const payload = JSON.stringify(body);

  const res = await request({
    hostname: 'api.evolink.ai',
    path: '/v1/videos/generations',
    method: 'POST',
    headers: {
      'Authorization': `Bearer ${API_KEY}`,
      'Content-Type': 'application/json',
      'Content-Length': Buffer.byteLength(payload)
    }
  }, payload);

  if (res.status !== 200 || !res.data.id) {
    throw new Error(`Failed to create video task: ${JSON.stringify(res.data || res.raw)}`);
  }

  const taskId = res.data.id;
  console.log(`Video task created! Task ID: ${taskId}`);

  const pollResult = await pollTask(taskId, 180, 5000);
  if (!pollResult.success || !pollResult.urls.length) {
    throw new Error(`Video generation failed: ${JSON.stringify(pollResult)}`);
  }

  const videoUrl = pollResult.urls[0];
  console.log(`\n Video Ready: ${videoUrl}`);

  if (output) {
    const savedPath = await downloadFile(videoUrl, output);
    console.log(` Saved video locally to: ${savedPath}`);
    return { url: videoUrl, file: savedPath };
  }

  return { url: videoUrl };
}

// CLI Argument Parsing
async function main() {
  const args = process.argv.slice(2);
  const command = args[0] || 'help';

  if (command === 'help' || args.length === 0) {
    console.log(`
EvoLink AI Universal Generator CLI
Usage:
  node evolink.js image --prompt "..." [--model gpt-image-2] [--output ./assets/hero.png]
  node evolink.js video --prompt "..." [--model kling-v3-image-to-video] [--image-url URL] [--output ./assets/hero.mp4]
  node evolink.js models
    `);
    return;
  }

  if (command === 'models') {
    const res = await request({
      hostname: 'direct.evolink.ai',
      path: '/v1/models',
      method: 'GET',
      headers: { 'Authorization': `Bearer ${API_KEY}` }
    });
    console.log('Active Models:', res.data.data.map(m => m.id).join(', '));
    return;
  }

  let prompt = '';
  let model = command === 'video' ? 'kling-v3-image-to-video' : 'gpt-image-2';
  let output = null;
  let imageUrl = null;

  for (let i = 1; i < args.length; i++) {
    if (args[i] === '--prompt' && args[i + 1]) prompt = args[++i];
    else if (args[i] === '--model' && args[i + 1]) model = args[++i];
    else if (args[i] === '--output' && args[i + 1]) output = args[++i];
    else if (args[i] === '--image-url' && args[i + 1]) imageUrl = args[++i];
  }

  if (!prompt) {
    console.error('Error: --prompt is required.');
    process.exit(1);
  }

  try {
    if (command === 'image') {
      await generateImage({ prompt, model, output });
    } else if (command === 'video') {
      await generateVideo({ prompt, model, imageUrl, output });
    } else {
      console.error(`Unknown command: ${command}`);
    }
  } catch (err) {
    console.error('Execution error:', err.message);
    process.exit(1);
  }
}

if (require.main === module) {
  main();
}

module.exports = { generateImage, generateVideo };
