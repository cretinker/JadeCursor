<?php
/**
 * Shared Header Template for Jade Cursor PHP Pages
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
  <meta name="theme-color" content="#080C14">
  <meta property="og:title" content="<?= htmlspecialchars($pageTitle) ?>">
  <meta property="og:description" content="<?= htmlspecialchars($pageDescription) ?>">
  <meta property="og:type" content="website">
  <meta property="og:url" content="<?= SITE_URL . $_SERVER['REQUEST_URI'] ?>">
  
  <!-- Google Fonts & Stylesheet -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
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
        <!-- High-End Geometric Vector Logo -->
        <a href="index.php" class="brand-logo" aria-label="Jade Cursor Home">
          <svg class="brand-logo-svg" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <defs>
              <linearGradient id="jadeGradPrimary" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="#00F5A0" />
                <stop offset="100%" stop-color="#059669" />
              </linearGradient>
              <linearGradient id="jadeFacet1" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="#10B981" stop-opacity="0.8" />
                <stop offset="100%" stop-color="#047857" stop-opacity="0.9" />
              </linearGradient>
              <linearGradient id="jadeFacet2" x1="100%" y1="0%" x2="0%" y2="100%">
                <stop offset="0%" stop-color="#34D399" stop-opacity="0.4" />
                <stop offset="100%" stop-color="#064E3B" stop-opacity="0.8" />
              </linearGradient>
              <filter id="jadeGlow" x="-20%" y="-20%" width="140%" height="140%">
                <feGaussianBlur stdDeviation="3" result="blur" />
                <feComposite in="SourceGraphic" in2="blur" operator="over" />
              </filter>
            </defs>
            <polygon points="24,2 43,13 43,35 24,46 5,35 5,13" fill="#080C14" stroke="url(#jadeGradPrimary)" stroke-width="1.8" />
            <polygon points="24,2 24,24 43,13" fill="url(#jadeFacet1)" />
            <polygon points="43,13 24,24 43,35" fill="#064E3B" fill-opacity="0.6" />
            <polygon points="43,35 24,24 24,46" fill="url(#jadeFacet2)" />
            <polygon points="24,46 24,24 5,35" fill="url(#jadeFacet1)" />
            <polygon points="5,35 24,24 5,13" fill="#064E3B" fill-opacity="0.6" />
            <polygon points="5,13 24,24 24,2" fill="url(#jadeFacet2)" />
            <path d="M21 14L31 24L24 25.5L28 34L24 35.5L20 27L15 31V14H21Z" fill="#00F5A0" filter="url(#jadeGlow)" />
            <path d="M21 14L31 24L24 25.5L28 34L24 35.5L20 27L15 31V14H21Z" fill="#FFFFFF" fill-opacity="0.85" />
          </svg>
          <div class="brand-text-block">
            <span class="brand-title">Jade Cursor</span>
            <span class="brand-badge">Spa Web Studio</span>
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
            <p><strong>hello@jadecursor.com</strong></p>
            <p style="font-size: 0.85rem; margin-top: 0.25rem;">Dedicated Web Design Agency for Luxury Spas &amp; Salons</p>
            <div style="margin-top: 1.25rem;">
              <a href="book-a-call.php" class="btn btn-primary" style="width: 100%;">Book a Discovery Call</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
