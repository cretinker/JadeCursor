<?php
$pageTitle = "Contact Us | Spa Design Hub Spa Web Design Studio";
$pageDescription = "Get in touch with Spa Design Hub to discuss your spa website project. Schedule a 30-minute discovery call or send us an inquiry.";
$currentPage = "contact";

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
          Let's Talk
        </div>
        <h1>
          Schedule your free <span class="text-jade-accent">Discovery Call</span>.
        </h1>
        <p class="lead">
          Let's discuss your spa's goals, review your current booking process, and show you how a custom luxury website will help you attract and convert more high-paying clients.
        </p>
      </div>
    </section>

    <!-- ==========================================================================
         CONTACT FORM & DETAILS
         ========================================================================== -->
    <section class="section-spacing">
      <div class="site-container">
        <div class="contact-layout-grid">
          
          <!-- Direct Details Column -->
          <div class="contact-info-panel">
            <div>
              <div class="eyebrow-pill">
                <span class="pill-dot"></span>
                Get In Touch
              </div>
              <h2>
                How we can help <span class="text-jade-accent">your business</span>.
              </h2>
              <p>
                During our 30-minute discovery session, we'll answer all your questions, share recommendations for your spa's website, and provide a clear, all-inclusive proposal.
              </p>
            </div>

            <div class="contact-detail-item">
              <div class="contact-detail-icon">
                <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
              </div>
              <div>
                <strong style="display: block; font-size: 1.05rem; color: var(--color-espresso);">Email Us Directly</strong>
                <a href="mailto:hello@spadesignhub.com" style="color: var(--color-jade-neon); font-weight: 600;">hello@spadesignhub.com</a>
                <p style="font-size: 0.85rem; margin-top: 0.25rem;">We respond within 24 business hours.</p>
              </div>
            </div>

            <div class="contact-detail-item">
              <div class="contact-detail-icon">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
              </div>
              <div>
                <strong style="display: block; font-size: 1.05rem; color: var(--color-espresso);">Working Globally</strong>
                <p style="font-size: 0.95rem; color: var(--color-text-muted);">Serving luxury spas and salons across the US, UK, Canada &amp; Europe</p>
                <p style="font-size: 0.85rem; margin-top: 0.25rem;">Flexible call times across all major time zones.</p>
              </div>
            </div>

            <div class="contact-detail-item">
              <div class="contact-detail-icon">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
              </div>
              <div>
                <strong style="display: block; font-size: 1.05rem; color: var(--color-espresso);">Office Hours</strong>
                <p style="font-size: 0.95rem; color: var(--color-text-muted);">Monday — Friday: 9:00 AM — 6:00 PM EST</p>
                <p style="font-size: 0.85rem; margin-top: 0.25rem;">Closed on weekends.</p>
              </div>
            </div>

            <div class="double-bezel-card" style="margin-top: 1rem;">
              <div class="double-bezel-inner" style="padding: 1.5rem;">
                <div style="display: flex; align-items: center; gap: 0.75rem; color: var(--color-jade-neon); font-weight: 700; font-size: 0.9rem;">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                  Zero-Pressure Promise
                </div>
                <p style="font-size: 0.85rem; margin-top: 0.5rem; color: var(--color-text-muted);">
                  Our discovery call is an informal, helpful conversation. If we're not the right fit for your spa, we will point you in the right direction with zero pressure.
                </p>
              </div>
            </div>
          </div>

          <!-- Project Form -->
          <div class="contact-form-container">
            <h3 style="font-size: 1.75rem; margin-bottom: 0.5rem;">Tell Us About Your Spa</h3>
            <p style="font-size: 0.95rem; margin-bottom: 2rem; color: var(--color-text-muted);">
              Fill out a few quick details below so we can review your website before our call.
            </p>

            <form action="api/contact.php" method="POST">
            <?= CSRF::getInputField() ?>
              <div class="form-row-2col">
                <div class="form-group">
                  <label for="full-name" class="form-label">Your Name *</label>
                  <input type="text" id="full-name" name="name" class="form-input" placeholder="e.g. Eleanor Vance" required>
                </div>
                <div class="form-group">
                  <label for="email" class="form-label">Work Email Address *</label>
                  <input type="email" id="email" name="email" class="form-input" placeholder="e.g. eleanor@sanctuaryspa.com" required>
                </div>
              </div>

              <div class="form-row-2col">
                <div class="form-group">
                  <label for="spa-name" class="form-label">Spa or Business Name *</label>
                  <input type="text" id="spa-name" name="spa_name" class="form-input" placeholder="e.g. Serenity Day Retreat" required>
                </div>
                <div class="form-group">
                  <label for="current-website" class="form-label">Current Website (If applicable)</label>
                  <input type="url" id="current-website" name="website" class="form-input" placeholder="https://yoursite.com">
                </div>
              </div>

              <div class="form-group">
                <label class="form-label">Type of Spa / Business</label>
                <div class="chip-grid">
                  <div>
                    <input type="radio" name="modality" id="mod-dayspa" class="chip-input" value="Day Spa & Massage" checked>
                    <label for="mod-dayspa" class="chip-label">Day Spa &amp; Massage</label>
                  </div>
                  <div>
                    <input type="radio" name="modality" id="mod-medspa" class="chip-input" value="Medical Esthetics">
                    <label for="mod-medspa" class="chip-label">Medical Esthetics</label>
                  </div>
                  <div>
                    <input type="radio" name="modality" id="mod-hydro" class="chip-input" value="Hydrothermal & Bath">
                    <label for="mod-hydro" class="chip-label">Bathhouse / Retreat</label>
                  </div>
                  <div>
                    <input type="radio" name="modality" id="mod-salon" class="chip-input" value="Botanical Salon">
                    <label for="mod-salon" class="chip-label">Luxury Salon</label>
                  </div>
                  <div>
                    <input type="radio" name="modality" id="mod-mobile" class="chip-input" value="Mobile Beauty">
                    <label for="mod-mobile" class="chip-label">Mobile Stylists</label>
                  </div>
                </div>
              </div>

              <div class="form-row-2col">
                <div class="form-group">
                  <label for="package-tier" class="form-label">Plan or Service of Interest</label>
                  <select id="package-tier" name="tier" class="form-select">
                    <option value="Growth Plan ($395/mo)">Monthly Growth &amp; Funnels ($395/mo) &mdash; Most Popular</option>
                    <option value="Care Plan ($195/mo)">Monthly Website Care ($195/mo)</option>
                    <option value="Dedicated Studio ($790/mo)">Monthly Dedicated Studio ($790/mo)</option>
                    <option value="Signature Build ($9,480)">Signature Growth Build ($9,480 One-Time)</option>
                    <option value="Essential Build ($4,680)">Essential Turnkey Build ($4,680 One-Time)</option>
                    <option value="Enterprise Flagship ($18,960)">Enterprise Flagship ($18,960 One-Time)</option>
                    <option value="Custom Consultation">Undecided / Let's Discuss</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="timeline" class="form-label">Target Launch Timeline</label>
                  <select id="timeline" name="timeline" class="form-select">
                    <option value="Next 3-5 Weeks">Next 3-5 Weeks</option>
                    <option value="1-2 Months">1-2 Months</option>
                    <option value="Within 3-6 Months">Within 3-6 Months</option>
                    <option value="Exploring Options">Just Exploring Options</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label for="project-vision" class="form-label">What is the main goal for your new website?</label>
                <textarea id="project-vision" name="message" class="form-textarea" placeholder="e.g. We want more direct online bookings, we want our site to look as luxurious as our actual space, we need better mobile booking..."></textarea>
              </div>

              <div style="margin-top: 2rem;">
                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1.15rem 2rem;">
                  Schedule Your Discovery Call
                  <span class="btn-icon-wrapper">
                    <svg viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                  </span>
                </button>
                <p style="font-size: 0.8rem; color: var(--color-text-subtle); text-align: center; margin-top: 0.85rem;">
                  100% Privacy. We will never share your information.
                </p>
              </div>
            </form>
          </div>

        </div>
      </div>
    </section>
  </main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
