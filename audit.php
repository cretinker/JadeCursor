<?php
$pageTitle = "Free 5-Minute Spa Website Audit | Spa Design Hub";
$pageDescription = "Request a free, candid 5-minute video review of your current spa website. Discover mobile speed leaks, booking friction points, and conversion opportunities within 24 hours.";
$currentPage = "audit";

require_once __DIR__ . '/includes/header.php';
?>

<main>
    <!-- ==========================================================================
         PAGE HEADER
         ========================================================================== -->
    <section class="page-header-luxury">
      <div class="site-container">
        <div class="eyebrow-pill">
          <span class="pill-dot"></span>
          Free Website Review
        </div>
        <h1>
          Free 24-Hour <span class="text-jade-accent">Website &amp; Booking Audit</span>.
        </h1>
        <p class="lead">
          Find out why website visitors aren't booking appointments. We'll record a personalized 5-minute video teardown showing you how to improve your mobile booking experience.
        </p>
      </div>
    </section>

    <!-- ==========================================================================
         CALCULATOR SECTION
         ========================================================================== -->
    <section class="section-spacing">
      <div class="site-container">
        <div class="calculator-card">
          <div class="calc-layout">
            
            <div>
              <div class="eyebrow-pill">
                <span class="pill-dot"></span>
                The Impact of Booking Drop-Off
              </div>
              <h2 style="font-size: 2.15rem; margin-bottom: 1rem;">
                How much revenue is a clunky website costing your spa?
              </h2>
              <p>
                When a busy client visits your website on their phone, any friction in finding treatments or loading your booking page causes them to leave without making an appointment.
              </p>

              <div style="display: flex; flex-direction: column; gap: 1rem; margin-top: 1.5rem;">
                <div style="display: flex; align-items: center; justify-content: space-between; padding: 1rem 1.25rem; background: var(--color-surface-raised); border-radius: var(--radius-md); border: 1px solid var(--color-border);">
                  <span style="font-size: 0.95rem; font-weight: 600; color: var(--color-text-main);">Typical Monthly Visitors:</span>
                  <strong style="color: var(--color-jade-neon); font-family: var(--font-mono);">3,000 Visitors</strong>
                </div>

                <div style="display: flex; align-items: center; justify-content: space-between; padding: 1rem 1.25rem; background: var(--color-surface-raised); border-radius: var(--radius-md); border: 1px solid var(--color-border);">
                  <span style="font-size: 0.95rem; font-weight: 600; color: var(--color-text-main);">Mobile Drop-Off on Slow Sites:</span>
                  <strong style="color: var(--color-status-red); font-family: var(--font-mono);">62% Give Up</strong>
                </div>

                <div style="display: flex; align-items: center; justify-content: space-between; padding: 1rem 1.25rem; background: var(--color-surface-raised); border-radius: var(--radius-md); border: 1px solid var(--color-border);">
                  <span style="font-size: 0.95rem; font-weight: 600; color: var(--color-text-main);">Average Guest Treatment Spend:</span>
                  <strong style="color: var(--color-jade-neon); font-family: var(--font-mono);">$350 / Appointment</strong>
                </div>
              </div>
            </div>

            <!-- Result Box -->
            <div class="calc-result-box">
              <span style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.15em; color: var(--color-jade-neon); font-weight: 700;">
                Estimated Annual Lost Bookings
              </span>
              <div class="calc-metric-number">$245,000+</div>
              <p style="color: var(--color-text-muted); font-size: 0.95rem; margin-bottom: 1.5rem;">
                Fixing your mobile booking experience and speeding up your website helps you recover these guests and directly boosts your bottom line.
              </p>
              <a href="#audit-form-section" class="btn btn-primary" style="width: 100%;">
                Get Your Free Video Audit
              </a>
            </div>

          </div>
        </div>
      </div>
    </section>

    <!-- ==========================================================================
         AUDIT FORM SECTION
         ========================================================================== -->
    <section id="audit-form-section" class="section-spacing" style="background-color: var(--color-bg-alt);">
      <div class="site-container-narrow">
        <div class="section-header text-center">
          <div class="eyebrow-pill">
            <span class="pill-dot"></span>
            100% Free &amp; No Obligation
          </div>
          <h2>
            Request your custom <span class="text-jade-accent">5-minute video review</span>.
          </h2>
          <p>
            Delivered straight to your email within 24 business hours by our design team. No sales pressure, just helpful feedback.
          </p>
        </div>

        <div class="contact-form-container">
          <form action="api/audit.php" method="POST">
            <?= CSRF::getInputField() ?>
            <div class="form-row-2col">
              <div class="form-group">
                <label for="audit-name" class="form-label">Your Name *</label>
                <input type="text" id="audit-name" name="name" class="form-input" placeholder="e.g. Dr. Christine Howard" required>
              </div>
              <div class="form-group">
                <label for="audit-email" class="form-label">Work Email *</label>
                <input type="email" id="audit-email" name="email" class="form-input" placeholder="e.g. christine@howardspa.com" required>
              </div>
            </div>

            <div class="form-row-2col">
              <div class="form-group">
                <label for="audit-website" class="form-label">Current Website URL *</label>
                <input type="url" id="audit-website" name="website" class="form-input" placeholder="https://yourspa.com" required>
              </div>
              <div class="form-group">
                <label for="audit-software" class="form-label">Booking Software You Use</label>
                <select id="audit-software" name="software" class="form-select">
                  <option value="Boulevard">Boulevard</option>
                  <option value="Mindbody">Mindbody</option>
                  <option value="Fresha">Fresha</option>
                  <option value="Jane App">Jane App</option>
                  <option value="Vagaro">Vagaro</option>
                  <option value="Phorest">Phorest</option>
                  <option value="Other">Other / Not Sure</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label for="audit-notes" class="form-label">What is your biggest frustration with your current website?</label>
              <textarea id="audit-notes" name="notes" class="form-textarea" placeholder="e.g. It doesn't look as upscale as our spa, clients find it hard to book on mobile, it takes too long to load..."></textarea>
            </div>

            <div style="margin-top: 1.5rem;">
              <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1.15rem 2rem;">
                Send Me My Free Video Audit
                <span class="btn-icon-wrapper">
                  <svg viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </section>

    <!-- ==========================================================================
         WHAT WE REVIEW
         ========================================================================== -->
    <section class="section-spacing">
      <div class="site-container">
        <div class="section-header text-center">
          <div class="eyebrow-pill">
            <span class="pill-dot"></span>
            What We Check
          </div>
          <h2>
            What we cover in your <span class="text-jade-accent">5-minute audit</span>.
          </h2>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.75rem;">
          <div class="double-bezel-card">
            <div class="double-bezel-inner">
              <div class="proof-number" style="font-size: 1.85rem; margin-bottom: 0.5rem;">01</div>
              <h3>Mobile Booking Flow</h3>
              <p style="font-size: 0.95rem; margin-top: 0.5rem;">
                We test booking a treatment on a mobile phone to see if links are broken or if the process is confusing for guests.
              </p>
            </div>
          </div>

          <div class="double-bezel-card">
            <div class="double-bezel-inner">
              <div class="proof-number" style="font-size: 1.85rem; margin-bottom: 0.5rem;">02</div>
              <h3>Visual Luxury Presentation</h3>
              <p style="font-size: 0.95rem; margin-top: 0.5rem;">
                We check whether your site's photography, colors, and layout reflect your true high-end standard.
              </p>
            </div>
          </div>

          <div class="double-bezel-card">
            <div class="double-bezel-inner">
              <div class="proof-number" style="font-size: 1.85rem; margin-bottom: 0.5rem;">03</div>
              <h3>Menu &amp; Package Clarity</h3>
              <p style="font-size: 0.95rem; margin-top: 0.5rem;">
                We review how easy it is for visitors to understand your treatment offerings, packages, and gift cards.
              </p>
            </div>
          </div>

          <div class="double-bezel-card">
            <div class="double-bezel-inner">
              <div class="proof-number" style="font-size: 1.85rem; margin-bottom: 0.5rem;">04</div>
              <h3>3 Clear Improvements</h3>
              <p style="font-size: 0.95rem; margin-top: 0.5rem;">
                We give you 3 practical, actionable recommendations you can implement to start getting more bookings immediately.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
