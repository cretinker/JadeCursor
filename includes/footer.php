<?php
/**
 * Shared Footer Template for Jade Cursor PHP Pages
 */
?>
  <!-- ==========================================================================
       MOBILE STICKY CTA BAR
       ========================================================================== -->
  <div class="mobile-sticky-cta" aria-label="Mobile Quick Booking CTA">
    <div class="mobile-cta-text">
      <strong>Ready to Upgrade?</strong>
      <span>Turn your spa traffic into paying clients</span>
    </div>
    <a href="book-a-call.php" class="btn btn-primary">
      <span>Book Strategy Call</span>
      <div class="btn-icon-wrapper">
        <svg viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
      </div>
    </a>
  </div>

  <!-- ==========================================================================
       GLOBAL FOOTER
       ========================================================================== -->
  <footer class="site-footer">
    <div class="site-container">
      <div class="footer-grid">
        <div class="footer-brand">
          <a href="index.php" class="brand-logo">
            <svg class="brand-logo-svg" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
              <polygon points="24,2 43,13 43,35 24,46 5,35 5,13" fill="#080C14" stroke="#00F5A0" stroke-width="1.8" />
              <polygon points="24,2 24,24 43,13" fill="#10B981" fill-opacity="0.8" />
              <polygon points="43,13 24,24 43,35" fill="#064E3B" fill-opacity="0.6" />
              <polygon points="43,35 24,24 24,46" fill="#34D399" fill-opacity="0.4" />
              <polygon points="24,46 24,24 5,35" fill="#10B981" fill-opacity="0.8" />
              <polygon points="5,35 24,24 5,13" fill="#064E3B" fill-opacity="0.6" />
              <polygon points="5,13 24,24 24,2" fill="#34D399" fill-opacity="0.4" />
              <path d="M21 14L31 24L24 25.5L28 34L24 35.5L20 27L15 31V14H21Z" fill="#00F5A0" />
            </svg>
            <div class="brand-text-block">
              <span class="brand-title">Jade Cursor</span>
              <span class="brand-badge">Spa Web Studio</span>
            </div>
          </a>
          <p>
            The dedicated web design agency crafting custom, high-converting websites for luxury spas, salons, and medi-spas worldwide.
          </p>
        </div>

        <div class="footer-col">
          <h4>Navigation</h4>
          <div class="footer-links">
            <a href="index.php">Home</a>
            <a href="about.php">About Us</a>
            <a href="services.php">Services &amp; Pricing</a>
            <a href="portfolio.php">Client Results</a>
            <a href="process.php">How We Work</a>
            <a href="audit.php">Free Website Audit</a>
            <a href="book-a-call.php">Book a Discovery Call</a>
          </div>
        </div>

        <div class="footer-col">
          <h4>Who We Serve</h4>
          <div class="footer-links">
            <a href="portfolio.php">Luxury Day Spas</a>
            <a href="portfolio.php">Medical Esthetics &amp; MedSpas</a>
            <a href="portfolio.php">Bathhouses &amp; Retreats</a>
            <a href="portfolio.php">Mobile Stylist Collectives</a>
            <a href="portfolio.php">Upscale Salons</a>
          </div>
        </div>

        <div class="footer-col">
          <h4>Contact Us</h4>
          <div class="footer-contact-info">
            <p><strong>Email:</strong> hello@jadecursor.com</p>
            <p><strong>Hours:</strong> Monday — Friday: 9:00 AM — 6:00 PM EST</p>
            <p><strong>Global:</strong> Working with luxury spas across the US, UK, Canada &amp; Europe</p>
          </div>
        </div>
      </div>

      <div class="footer-bottom">
        <div>
          &copy; <?= date('Y') ?> Jade Cursor Agency. All rights reserved. Custom Luxury Web Design.
        </div>
        <div>
          <span>More Bookings</span> &bull; <span>Effortless Mobile Experience</span> &bull; <span>Turnkey Delivery</span>
        </div>
      </div>
    </div>
  </footer>

  <!-- Core Scripts -->
  <script src="js/app.js" defer></script>
  <?php if (!empty($extraScripts)): ?>
    <?php foreach ($extraScripts as $script): ?>
      <script src="<?= htmlspecialchars($script) ?>" defer></script>
    <?php endforeach; ?>
  <?php endif; ?>
</body>
</html>
