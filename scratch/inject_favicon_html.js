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
  'book-a-call.html',
  '404.html'
];

const faviconTag = `  <!-- Favicon / Brand Icon -->
  <link rel="icon" type="image/svg+xml" href="favicon.svg">
  <link rel="alternate icon" href="favicon.svg">
  <link rel="apple-touch-icon" href="favicon.svg">`;

htmlFiles.forEach(filename => {
  const filePath = path.join(baseDir, filename);
  if (!fs.existsSync(filePath)) return;

  let content = fs.readFileSync(filePath, 'utf8');

  // Check if favicon already linked
  if (content.includes('rel="icon"')) return;

  // Insert before </head> or before <link rel="stylesheet"
  if (content.includes('<link rel="stylesheet"')) {
    content = content.replace('<link rel="stylesheet"', `${faviconTag}\n  <link rel="stylesheet"`);
  } else {
    content = content.replace('</head>', `${faviconTag}\n</head>`);
  }

  fs.writeFileSync(filePath, content, 'utf8');
  console.log(`Linked favicon in ${filename}`);
});
