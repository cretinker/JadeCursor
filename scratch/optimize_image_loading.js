const fs = require('fs');
const path = require('path');

const baseDir = 'c:\\Users\\DELL\\Documents\\Elijah Workspace\\spa\\JadeCursor';

const files = [
  'index.html', 'about.html', 'services.html', 'portfolio.html', 'process.html', 'audit.html', 'contact.html', 'book-a-call.html', '404.html',
  'index.php', 'about.php', 'services.php', 'portfolio.php', 'process.php', 'audit.php', 'contact.php', 'book-a-call.php', '404.php'
];

files.forEach(filename => {
  const filePath = path.join(baseDir, filename);
  if (!fs.existsSync(filePath)) return;

  let content = fs.readFileSync(filePath, 'utf8');

  // Replace <img src="..." with <img loading="lazy" decoding="async" src="..." if not already present
  content = content.replace(/<img\s+(?![^>]*loading=)([^>]+)>/gi, (match, p1) => {
    return `<img loading="lazy" decoding="async" ${p1}>`;
  });

  fs.writeFileSync(filePath, content, 'utf8');
  console.log(`Optimized image loading in ${filename}`);
});
