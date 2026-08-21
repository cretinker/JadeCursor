const fs = require('fs');
const path = require('path');

const baseDir = 'c:\\Users\\DELL\\Documents\\Elijah Workspace\\spa\\JadeCursor';

const pages = [
  {
    htmlFile: 'index.html',
    phpFile: 'index.php',
    currentPage: 'home',
    title: 'Jade Cursor | High-Converting Web Design for Luxury Spas & Salons',
    description: 'Jade Cursor is the dedicated web design agency for luxury day spas, medical esthetics clinics, and upscale salons. Double your direct bookings with effortless mobile reservation flows.'
  },
  {
    htmlFile: 'about.html',
    phpFile: 'about.php',
    currentPage: 'about',
    title: 'About Us | Jade Cursor Spa Web Design Agency',
    description: 'Learn about Jade Cursor: The dedicated web design agency helping luxury spas, salons, and wellness clinics elevate their online presence and increase direct bookings.'
  },
  {
    htmlFile: 'services.html',
    phpFile: 'services.php',
    currentPage: 'services',
    title: 'Services & Transparent Pricing | Jade Cursor',
    description: 'Explore our transparent monthly subscription plans ($195/mo to $790/mo) and turnkey website builds tailored for luxury spas, salons, and medical clinics.'
  },
  {
    htmlFile: 'portfolio.html',
    phpFile: 'portfolio.php',
    currentPage: 'results',
    title: 'Client Results & Case Studies | Jade Cursor',
    description: 'Explore our portfolio of high-converting luxury spa and salon websites. See verified client results, mobile UX breakdowns, and booking increases.'
  },
  {
    htmlFile: 'process.html',
    phpFile: 'process.php',
    currentPage: 'process',
    title: 'How We Work & Turnkey Delivery | Jade Cursor',
    description: 'Discover our zero-stress web design process built exclusively for busy spa owners. 100% done-for-you copywriting, luxury layout design, and booking software integration.'
  },
  {
    htmlFile: 'audit.html',
    phpFile: 'audit.php',
    currentPage: 'audit',
    title: 'Free 5-Minute Spa Website Audit | Jade Cursor',
    description: 'Request a free, candid 5-minute video review of your current spa website. Discover mobile speed leaks, booking friction points, and conversion opportunities within 24 hours.'
  },
  {
    htmlFile: 'contact.html',
    phpFile: 'contact.php',
    currentPage: 'contact',
    title: 'Contact Us | Jade Cursor Spa Web Design Studio',
    description: 'Get in touch with Jade Cursor to discuss your spa website project. Schedule a 30-minute discovery call or send us an inquiry.'
  },
  {
    htmlFile: 'book-a-call.html',
    phpFile: 'book-a-call.php',
    currentPage: 'book-a-call',
    title: 'Book a 30-Min Discovery Strategy Call | Jade Cursor',
    description: 'Schedule a free 30-minute 1-on-1 strategy session with Principal Design Director Elijah Vance. Live mobile audit and transparent project roadmap.',
    extraScripts: ['js/booking.js']
  }
];

pages.forEach(p => {
  const htmlPath = path.join(baseDir, p.htmlFile);
  const phpPath = path.join(baseDir, p.phpFile);

  if (!fs.existsSync(htmlPath)) return;

  const content = fs.readFileSync(htmlPath, 'utf8');

  // Extract <main>...</main> content
  const mainMatch = content.match(/<main[\s\S]*?<\/main>/);
  if (!mainMatch) {
    console.error(`Could not extract main from ${p.htmlFile}`);
    return;
  }

  let mainHtml = mainMatch[0];

  // Convert internal links to .php (or clean URLs)
  mainHtml = mainHtml.replace(/href="index\.html"/g, 'href="index.php"');
  mainHtml = mainHtml.replace(/href="about\.html"/g, 'href="about.php"');
  mainHtml = mainHtml.replace(/href="services\.html"/g, 'href="services.php"');
  mainHtml = mainHtml.replace(/href="portfolio\.html"/g, 'href="portfolio.php"');
  mainHtml = mainHtml.replace(/href="process\.html"/g, 'href="process.php"');
  mainHtml = mainHtml.replace(/href="audit\.html"/g, 'href="audit.php"');
  mainHtml = mainHtml.replace(/href="contact\.html"/g, 'href="contact.php"');
  mainHtml = mainHtml.replace(/href="book-a-call\.html"/g, 'href="book-a-call.php"');

  // If page is contact.php, audit.php, or book-a-call.php, ensure CSRF token is included in form
  if (p.phpFile === 'contact.php') {
    mainHtml = mainHtml.replace(/<form action="contact\.html" method="GET">/g, '<form action="api/contact.php" method="POST">\n            <?= CSRF::getInputField() ?>');
    mainHtml = mainHtml.replace(/<form action="contact\.php" method="POST">/g, '<form action="api/contact.php" method="POST">\n            <?= CSRF::getInputField() ?>');
  } else if (p.phpFile === 'audit.php') {
    mainHtml = mainHtml.replace(/<form action="contact\.html" method="GET">/g, '<form action="api/audit.php" method="POST">\n            <?= CSRF::getInputField() ?>');
    mainHtml = mainHtml.replace(/<form action="audit\.php" method="POST">/g, '<form action="api/audit.php" method="POST">\n            <?= CSRF::getInputField() ?>');
  } else if (p.phpFile === 'book-a-call.php') {
    mainHtml = mainHtml.replace(/<form action="contact\.html" method="GET">/g, '<form action="api/booking.php" method="POST">\n              <?= CSRF::getInputField() ?>');
    mainHtml = mainHtml.replace(/<form action="book-a-call\.php" method="POST">/g, '<form action="api/booking.php" method="POST">\n              <?= CSRF::getInputField() ?>');
  }

  // Extract mobile sticky CTA if outside <main>
  let mobileCtaMatch = content.match(/<!-- =+ STICKY MOBILE CTA BAR[\s\S]*?<\/div>/);
  let mobileCtaHtml = mobileCtaMatch ? `\n  ${mobileCtaMatch[0].replace(/href="contact\.html"/g, 'href="book-a-call.php"').replace(/href="book-a-call\.html"/g, 'href="book-a-call.php"')}` : '';

  const extraScriptsDeclaration = p.extraScripts && p.extraScripts.length 
    ? `\n$extraScripts = ${JSON.stringify(p.extraScripts)};` 
    : '';

  const phpOutput = `<?php
$pageTitle = ${JSON.stringify(p.title)};
$pageDescription = ${JSON.stringify(p.description)};
$currentPage = ${JSON.stringify(p.currentPage)};${extraScriptsDeclaration}

require_once __DIR__ . '/includes/header.php';
?>

${mainHtml}
${mobileCtaHtml}
<?php require_once __DIR__ . '/includes/footer.php'; ?>
`;

  fs.writeFileSync(phpPath, phpOutput, 'utf8');
  console.log(`Generated ${p.phpFile}`);
});
