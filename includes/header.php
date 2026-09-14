<?php
/**
 * Shared Header Template for Spa Design Hub PHP Pages
 * Supports dynamic page title, meta description, and active navigation highlighting
 */

if (!defined('JADE_APP')) {
    require_once __DIR__ . '/../config.php';
}

$pageTitle = $pageTitle ?? 'Jade Cursor | Luxury Spa Web Design Agency';
$pageDescription = $pageDescription ?? 'Custom high-converting web design, mobile booking systems, and growth funnels built exclusively for luxury spas, salons, and wellness clinics.';
$currentPage = $currentPage ?? 'home';

// CSRF Token
require_once __DIR__ . '/csrf.php';
$csrfToken = CSRF::generateToken();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($pageTitle) ?></title>
  <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
  
  <!-- Favicon / Brand Icon -->
  <link rel="icon" type="image/svg+xml" href="favicon.svg">
  <link rel="alternate icon" href="favicon.svg">
  <link rel="apple-touch-icon" href="favicon.svg">
  <meta name="theme-color" content="#FAF8F5">
  <meta property="og:title" content="<?= htmlspecialchars($pageTitle) ?>">
  <meta property="og:description" content="<?= htmlspecialchars($pageDescription) ?>">
  <meta property="og:type" content="website">
  <meta property="og:url" content="<?= SITE_URL . $_SERVER['REQUEST_URI'] ?>">
  
  <!-- Google Fonts & Stylesheet -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/styles.css">
  
  <meta name="csrf-token" content="<?= htmlspecialchars($csrfToken) ?>">
</head>
<body>

  <!-- ==========================================================================
       FLOATING GLASSMORPHISM HEADER & NAVIGATION
       ========================================================================== -->
  <header class="site-header">
    <div class="nav-container">
      <div class="nav-bar">
        <!-- High-End Architectural Vector Logo -->
        <a href="index.php" class="brand-logo" aria-label="Spa Design Hub Home">
          <svg class="brand-logo-svg" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <defs>
              <linearGradient id="hubGold" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="#D4B996" />
                <stop offset="100%" stop-color="#B38E5D" />
              </linearGradient>
            </defs>
            <rect x="2" y="2" width="44" height="44" rx="12" fill="#FAF8F5" stroke="#E5DDD0" stroke-width="1.2" />
            <g transform="translate(24, 24)">
              <polygon points="0,-16 16,0 0,16 -16,0" fill="none" stroke="url(#hubGold)" stroke-width="1.6" />
              <path d="M-9,9 C-9,-3 9,-3 9,9" fill="none" stroke="#191512" stroke-width="1.5" stroke-linecap="round" />
              <line x1="0" y1="-10" x2="0" y2="9" stroke="url(#hubGold)" stroke-width="1.5" stroke-linecap="round" />
              <circle cx="0" cy="-4" r="2.2" fill="#191512" />
              <circle cx="0" cy="-4" r="1.2" fill="url(#hubGold)" />
            </g>
          </svg>
          <div class="brand-text-block">
            <span class="brand-title">Spa Design Hub</span>
            <span class="brand-badge">Boutique Spa Studio</span>
          </div>
        </a>

        <!-- Desktop Navigation Links (About after Home) -->
        <nav class="desktop-nav" aria-label="Main Navigation">
          <a href="index.php" class="nav-link <?= $currentPage === 'home' ? 'active' : '' ?>">Home</a>
          <a href="about.php" class="nav-link <?= $currentPage === 'about' ? 'active' : '' ?>">About</a>
          <a href="services.php" class="nav-link <?= $currentPage === 'services' ? 'active' : '' ?>">Services</a>
          <a href="portfolio.php" class="nav-link <?= $currentPage === 'results' ? 'active' : '' ?>">Results</a>
          <a href="process.php" class="nav-link <?= $currentPage === 'process' ? 'active' : '' ?>">Process</a>
          <a href="audit.php" class="nav-link <?= $currentPage === 'audit' ? 'active' : '' ?>">Free Audit</a>
          <a href="contact.php" class="nav-link <?= $currentPage === 'contact' ? 'active' : '' ?>">Contact</a>
        </nav>

        <div class="nav-actions">
          <a href="book-a-call.php" class="btn btn-primary btn-header-cta">
            Book a Call
            <span class="btn-icon-wrapper">
              <svg viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </span>
          </a>
        </div>

        <!-- Pure CSS Mobile Hamburger Toggle -->
        <input type="checkbox" id="nav-toggle" class="nav-toggle-input" aria-label="Toggle mobile menu">
        <label for="nav-toggle" class="nav-toggle-label">
          <span></span>
          <span></span>
          <span></span>
        </label>

        <!-- Fullscreen Glass Mobile Drawer (About after Home) -->
        <div class="mobile-nav-drawer">
          <ul class="mobile-nav-list">
            <li><a href="index.php" class="mobile-nav-link <?= $currentPage === 'home' ? 'active' : '' ?>"><span>Home</span> <span class="nav-num">01</span></a></li>
            <li><a href="about.php" class="mobile-nav-link <?= $currentPage === 'about' ? 'active' : '' ?>"><span>About Us</span> <span class="nav-num">02</span></a></li>
            <li><a href="services.php" class="mobile-nav-link <?= $currentPage === 'services' ? 'active' : '' ?>"><span>Services &amp; Pricing</span> <span class="nav-num">03</span></a></li>
            <li><a href="portfolio.php" class="mobile-nav-link <?= $currentPage === 'results' ? 'active' : '' ?>"><span>Client Results</span> <span class="nav-num">04</span></a></li>
            <li><a href="process.php" class="mobile-nav-link <?= $currentPage === 'process' ? 'active' : '' ?>"><span>How We Work</span> <span class="nav-num">05</span></a></li>
            <li><a href="audit.php" class="mobile-nav-link <?= $currentPage === 'audit' ? 'active' : '' ?>"><span>Free Website Audit</span> <span class="nav-num">06</span></a></li>
            <li><a href="contact.php" class="mobile-nav-link <?= $currentPage === 'contact' ? 'active' : '' ?>"><span>Contact Us</span> <span class="nav-num">07</span></a></li>
          </ul>
          <div class="mobile-nav-footer">
            <p><strong>hello@spadesignhub.com</strong></p>
            <p style="font-size: 0.85rem; margin-top: 0.25rem;">Boutique Web Design Studio &amp; Conversion Engine for Luxury Spas</p>
            <a href="book-a-call.php" class="btn btn-primary" style="margin-top: 1.25rem; width: 100%; text-align: center;">Book 30-Min Strategy Call</a>
          </div>
        </div>
      </div>
    </div>
  </header>
