<?php
/**
 * Shared Footer Template for Spa Design Hub PHP Pages
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
              <defs>
                <linearGradient id="hubGoldFoot" x1="0%" y1="0%" x2="100%" y2="100%">
                  <stop offset="0%" stop-color="#F5E7D0" />
                  <stop offset="40%" stop-color="#C5A880" />
                  <stop offset="100%" stop-color="#8E7350" />
                </linearGradient>
                <linearGradient id="hubGoldFootCore" x1="0%" y1="0%" x2="100%" y2="100%">
                  <stop offset="0%" stop-color="#FFFFFF" />
                  <stop offset="50%" stop-color="#D4B996" />
                  <stop offset="100%" stop-color="#A8824C" />
                </linearGradient>
              </defs>
              <rect x="2" y="2" width="44" height="44" rx="12" fill="#14100D" stroke="url(#hubGoldFoot)" stroke-width="1.2" />
              <rect x="5.5" y="5.5" width="37" height="37" rx="9" fill="none" stroke="rgba(197, 168, 128, 0.35)" stroke-width="0.8" />
              <g transform="translate(24, 24)">
                <polygon points="0,-14.5 14.5,0 0,14.5 -14.5,0" fill="none" stroke="url(#hubGoldFoot)" stroke-width="1.3" />
                <path d="M-8.5,8.5 C-8.5,-1 0,-3.5 0,-11 C0,-3.5 8.5,-1 8.5,8.5" fill="none" stroke="#FAF8F5" stroke-width="1.5" stroke-linecap="round" />
                <path d="M-5,8.5 C-5,1.5 0,0 0,-7 C0,0 5,1.5 5,8.5" fill="none" stroke="url(#hubGoldFootCore)" stroke-width="1.2" stroke-linecap="round" />
                <line x1="-10.5" y1="8.5" x2="10.5" y2="8.5" stroke="url(#hubGoldFoot)" stroke-width="1.2" stroke-linecap="round" />
                <polygon points="0,-14.5 2.5,-11 0,-7.5 -2.5,-11" fill="url(#hubGoldFoot)" />
                <circle cx="0" cy="1" r="1.6" fill="#FAF8F5" />
                <circle cx="0" cy="1" r="0.9" fill="url(#hubGoldFootCore)" />
              </g>
            </svg>
            <div class="brand-text-block">
              <span class="brand-title">Spa Design Hub</span>
              <span class="brand-badge">spadesignhub.xyz</span>
            </div>
          </a>
          <p>
            The dedicated digital design atelier engineering custom, high-converting websites and booking engines for luxury spas, aesthetic clinics, and medi-spas worldwide.
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
            <a href="portfolio.php">Upscale Aesthetic Salons</a>
          </div>
        </div>

        <div class="footer-col">
          <h4>Contact Us</h4>
          <div class="footer-contact-info">
            <p><strong>Email:</strong> hello@spadesignhub.xyz</p>
            <p><strong>Hours:</strong> Monday — Friday: 9:00 AM — 6:00 PM EST</p>
            <p><strong>Global:</strong> Partnering with luxury spas across the US, UK, Canada, Switzerland &amp; Europe</p>
          </div>
        </div>
      </div>

      <div class="footer-bottom">
        <div>
          &copy; <?= date('Y') ?> Spa Design Hub Studio. All rights reserved. Custom Luxury Web Design.
        </div>
        <div>
          <span>Bespoke Web Design</span> &bull; <span>Direct Booking Lift</span> &bull; <span>Turnkey Delivery</span>
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
