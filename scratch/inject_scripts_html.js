const fs = require('fs');
const path = require('path');

const baseDir = 'c:\\Users\\DELL\\Documents\\Elijah Workspace\\spa\\JadeCursor';

const htmlFiles = [
  'index.html',
  'about.html',
  'services.html',
  'portfolio.html',
  'process.html',
  'audit.html',
  'contact.html',
  'book-a-call.html'
];

htmlFiles.forEach(filename => {
  const filePath = path.join(baseDir, filename);
  if (!fs.existsSync(filePath)) return;

  let content = fs.readFileSync(filePath, 'utf8');

  // Remove any old script tags for app.js or booking.js first to avoid duplicates
  content = content.replace(/<script src="js\/app\.js"[\s\S]*?<\/script>\s*/g, '');
  content = content.replace(/<script src="js\/booking\.js"[\s\S]*?<\/script>\s*/g, '');

  let scriptsToInject = '<script src="js/app.js" defer></script>\n';
  if (filename === 'book-a-call.html') {
    scriptsToInject += '  <script src="js/booking.js" defer></script>\n';
  }

  content = content.replace('</body>', `  ${scriptsToInject}</body>`);

  fs.writeFileSync(filePath, content, 'utf8');
  console.log(`Injected scripts into ${filename}`);
});
