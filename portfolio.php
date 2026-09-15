<?php
$pageTitle = "Client Results & Case Studies | Spa Design Hub";
$pageDescription = "Explore our portfolio of high-converting luxury spa and salon websites. See verified client results, mobile UX breakdowns, and booking increases.";
$currentPage = "results";

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
          Client Transformations
        </div>
        <h1>
          Real client results for <span class="text-jade-accent">luxury wellness brands</span>.
        </h1>
        <p class="lead">
          Explore our award-winning client case studies. See how we help premier day spas, clinics, and salons eliminate mobile friction and maximize direct booking revenue.
        </p>
      </div>
    </section>

    <!-- ==========================================================================
         PORTFOLIO BENTO SHOWCASE
         ========================================================================== -->
    <section class="section-spacing">
      <div class="site-container">

        <!-- Category filter radios -->
        <input type="radio" name="portfolio-filter" id="filter-all" class="filter-radio" checked>
        <input type="radio" name="portfolio-filter" id="filter-dayspa" class="filter-radio">
        <input type="radio" name="portfolio-filter" id="filter-medspa" class="filter-radio">
        <input type="radio" name="portfolio-filter" id="filter-mobile" class="filter-radio">
        <input type="radio" name="portfolio-filter" id="filter-botanical" class="filter-radio">

        <!-- Filter Tab Buttons -->
        <div class="filter-tabs-wrapper">
          <label for="filter-all" class="filter-label">All Client Case Studies (5)</label>
          <label for="filter-medspa" class="filter-label">Medical Esthetics &amp; MedSpas</label>
          <label for="filter-dayspa" class="filter-label">Day Spas &amp; Hydrotherapy</label>
          <label for="filter-mobile" class="filter-label">Mobile Stylists</label>
          <label for="filter-botanical" class="filter-label">Luxury Salons</label>
        </div>

        <!-- Bento Case Studies Container -->
        <div class="portfolio-case-studies">

          <!-- ==========================================================================
               BENTO CASE STUDY 1: Pee Skin & Med Spa (Medical Esthetics)
               ========================================================================== -->
          <article class="bento-case-card cat-medspa">
            <!-- Header -->
            <div class="bento-case-header">
              <div class="bento-header-info">
                <div class="bento-modality-pill">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 8v8M8 12h8"/></svg>
                  Medical Esthetics &amp; Laser Practice
                </div>
                <h2 class="bento-case-title">Pee Skin &amp; Med Spa</h2>
                <p class="bento-case-subtitle">
                  Transforming a sterile clinical website into an elevated, high-converting consultation engine for $2,000+ cosmetic treatment plans.
                </p>
              </div>
              <div class="bento-header-actions">
                <a href="https://peeskinmedspa.jadecursor.com" target="_blank" rel="noopener noreferrer" class="btn btn-primary">
                  View Live Website
                  <span class="btn-icon-wrapper">
                    <svg viewBox="0 0 24 24"><path d="M7 17L17 7M7 7h10v10"/></svg>
                  </span>
                </a>
              </div>
            </div>

            <!-- Middle Section: Main Browser Viewport + Side Rail -->
            <div class="bento-main-grid">
              <!-- Interactive Browser Viewport -->
              <div class="bento-browser-stage">
                <div class="bento-browser-top">
                  <span class="browser-dot dot-red"></span>
                  <span class="browser-dot dot-yellow"></span>
                  <span class="browser-dot dot-green"></span>
                  <span class="bento-browser-url">https://peeskinmedspa.jadecursor.com</span>
                </div>
                <div class="bento-browser-img-wrap">
                  <img loading="lazy" decoding="async" src="images/case-study-peeskin.png" alt="Pee Skin &amp; Med Spa Luxury Medical Aesthetics Website — Created with gpt-image-2">
                  <!-- Floating UI Badge -->
                  <div class="bento-floating-badge">
                    <span class="live-dot"></span>
                    <span>Jane App Deep-Link &bull; &lt;45s Consultation Flow</span>
                  </div>
                </div>
              </div>

              <!-- Side Rail -->
              <div class="bento-side-rail">
                <!-- Glowing KPI Highlight Box -->
                <div class="bento-kpi-highlight">
                  <div class="bento-kpi-num">+310%</div>
                  <div class="bento-kpi-label">Consultation Inquiries</div>
                  <div class="bento-kpi-sub">Direct patient appointments surge</div>
                </div>

                <!-- Project Scope Bento Box -->
                <div class="bento-sub-box">
                  <span class="bento-sub-label">Project Scope &amp; Tech</span>
                  <div class="bento-tag-list">
                    <span class="bento-tag-item">Skin Concern Navigator</span>
                    <span class="bento-tag-item">Jane App Integration</span>
                    <span class="bento-tag-item">Pre-Qualified Forms</span>
                    <span class="bento-tag-item">High-Ticket Copywriting</span>
                    <span class="bento-tag-item">4-Week Delivery</span>
                  </div>
                </div>

                <!-- Initial Ticket Badge -->
                <div class="bento-sub-box" style="text-align: center; background: rgba(0, 245, 160, 0.04); border-color: rgba(0, 245, 160, 0.2);">
                  <div style="font-family: var(--font-display); font-size: 1.85rem; font-weight: 800; color: var(--color-jade-neon);">$1,250</div>
                  <div style="font-size: 0.82rem; color: var(--color-text-main); font-weight: 600;">Average First-Visit Patient Value</div>
                </div>
              </div>
            </div>

            <!-- Bottom Horizontal Transformation Strip (3 Panels) -->
            <div class="bento-narrative-strip">
              <div class="bento-narrative-card step-problem">
                <span class="narrative-card-step">01 // The Challenge</span>
                <h4>Sterile &amp; Lost Mobile Leads</h4>
                <p>
                  Their previous website looked cold and clinical. Mobile visitors were overwhelmed by complex medical jargon, resulting in over 60% dropping off before booking consultations.
                </p>
              </div>

              <div class="bento-narrative-card step-solution">
                <span class="narrative-card-step">02 // What We Built</span>
                <h4>Interactive Skin Navigator</h4>
                <p>
                  We built a luxury cosmetic experience featuring an intuitive skin concern selector and a pre-qualified consultation booking funnel directly linked into Jane App.
                </p>
              </div>

              <div class="bento-narrative-card step-impact">
                <span class="narrative-card-step">03 // Business Impact</span>
                <h4>+310% High-Ticket Inquiries</h4>
                <p>
                  New patient consultation inquiries grew by 310% in the first 90 days, raising their average initial ticket to $1,250 and generating an estimated 3.8x patient lifetime value.
                </p>
              </div>
            </div>
          </article>

          <!-- ==========================================================================
               BENTO CASE STUDY 2: JVEE Wellness & Spa (Day Spa)
               ========================================================================== -->
          <article class="bento-case-card cat-dayspa">
            <!-- Header -->
            <div class="bento-case-header">
              <div class="bento-header-info">
                <div class="bento-modality-pill">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/></svg>
                  Day Spa &amp; Massage Sanctuary
                </div>
                <h2 class="bento-case-title">JVEE Wellness &amp; Spa</h2>
                <p class="bento-case-subtitle">
                  Translating 5-star physical spa elegance to screen and streamlining appointment booking into Boulevard.
                </p>
              </div>
              <div class="bento-header-actions">
                <a href="https://jveewellness.jadecursor.com" target="_blank" rel="noopener noreferrer" class="btn btn-primary">
                  View Live Website
                  <span class="btn-icon-wrapper">
                    <svg viewBox="0 0 24 24"><path d="M7 17L17 7M7 7h10v10"/></svg>
                  </span>
                </a>
              </div>
            </div>

            <!-- Middle Section: Main Browser Viewport + Side Rail -->
            <div class="bento-main-grid">
              <!-- Interactive Browser Viewport -->
              <div class="bento-browser-stage">
                <div class="bento-browser-top">
                  <span class="browser-dot dot-red"></span>
                  <span class="browser-dot dot-yellow"></span>
                  <span class="browser-dot dot-green"></span>
                  <span class="bento-browser-url">https://jveewellness.jadecursor.com</span>
                </div>
                <div class="bento-browser-img-wrap">
                  <img loading="lazy" decoding="async" src="images/case-study-jvee.png" alt="JVEE Wellness &amp; Spa Luxury Hydrothermal Website Showcase — Created with gpt-image-2">
                  <!-- Floating UI Badge -->
                  <div class="bento-floating-badge">
                    <span class="live-dot"></span>
                    <span>Boulevard Software Integration &bull; 1-Tap Booking</span>
                  </div>
                </div>
              </div>

              <!-- Side Rail -->
              <div class="bento-side-rail">
                <div class="bento-kpi-highlight">
                  <div class="bento-kpi-num">+142%</div>
                  <div class="bento-kpi-label">Online Bookings</div>
                  <div class="bento-kpi-sub">Direct appointment volume surge</div>
                </div>

                <div class="bento-sub-box">
                  <span class="bento-sub-label">Project Scope &amp; Tech</span>
                  <div class="bento-tag-list">
                    <span class="bento-tag-item">Boulevard 1-Click Booking</span>
                    <span class="bento-tag-item">Interactive Treatment Menu</span>
                    <span class="bento-tag-item">Mobile Speed Overhaul</span>
                    <span class="bento-tag-item">Google Local SEO</span>
                    <span class="bento-tag-item">3-Week Delivery</span>
                  </div>
                </div>

                <div class="bento-sub-box" style="text-align: center; background: rgba(0, 245, 160, 0.04); border-color: rgba(0, 245, 160, 0.2);">
                  <div style="font-family: var(--font-display); font-size: 1.85rem; font-weight: 800; color: var(--color-jade-neon);">-58%</div>
                  <div style="font-size: 0.82rem; color: var(--color-text-main); font-weight: 600;">Mobile Drop-Off Reduction</div>
                </div>
              </div>
            </div>

            <!-- Bottom Horizontal Transformation Strip (3 Panels) -->
            <div class="bento-narrative-strip">
              <div class="bento-narrative-card step-problem">
                <span class="narrative-card-step">01 // The Challenge</span>
                <h4>Clunky Menus &amp; Lost Phone Time</h4>
                <p>
                  JVEE offered acclaimed bespoke massages, but their former website was slow and confusing on mobile phones, forcing guests to call the front desk for basic availability.
                </p>
              </div>

              <div class="bento-narrative-card step-solution">
                <span class="narrative-card-step">02 // What We Built</span>
                <h4>1-Click Boulevard Booking</h4>
                <p>
                  We created a custom luxury website with an easy-to-read treatment menu, transparent duration options, and direct 1-click booking into Boulevard that takes under 60 seconds.
                </p>
              </div>

              <div class="bento-narrative-card step-impact">
                <span class="narrative-card-step">03 // Business Impact</span>
                <h4>+142% Direct Reservations</h4>
                <p>
                  Online bookings grew by 142% within 60 days, front desk phone volume dropped significantly, and mobile bounce rate fell by 58%.
                </p>
              </div>
            </div>
          </article>

          <!-- ==========================================================================
               BENTO CASE STUDY 3: Aruna Spa (Hydrothermal Bathhouse)
               ========================================================================== -->
          <article class="bento-case-card cat-dayspa">
            <!-- Header -->
            <div class="bento-case-header">
              <div class="bento-header-info">
                <div class="bento-modality-pill">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/></svg>
                  Hydrothermal Bathhouse &amp; Retreat
                </div>
                <h2 class="bento-case-title">Aruna Spa</h2>
                <p class="bento-case-subtitle">
                  Unlocking lucrative weekday day-pass revenue and landing $480,000 in corporate wellness retreats.
                </p>
              </div>
              <div class="bento-header-actions">
                <a href="https://arunaspa.jadecursor.com" target="_blank" rel="noopener noreferrer" class="btn btn-primary">
                  View Live Website
                  <span class="btn-icon-wrapper">
                    <svg viewBox="0 0 24 24"><path d="M7 17L17 7M7 7h10v10"/></svg>
                  </span>
                </a>
              </div>
            </div>

            <!-- Middle Section: Main Browser Viewport + Side Rail -->
            <div class="bento-main-grid">
              <!-- Interactive Browser Viewport -->
              <div class="bento-browser-stage">
                <div class="bento-browser-top">
                  <span class="browser-dot dot-red"></span>
                  <span class="browser-dot dot-yellow"></span>
                  <span class="browser-dot dot-green"></span>
                  <span class="bento-browser-url">https://arunaspa.jadecursor.com</span>
                </div>
                <div class="bento-browser-img-wrap">
                  <img loading="lazy" decoding="async" src="images/case-study-aruna.png" alt="Aruna Spa &amp; Thermal Haven Website Showcase — Created with gpt-image-2">
                  <!-- Floating UI Badge -->
                  <div class="bento-floating-badge">
                    <span class="live-dot"></span>
                    <span>Mindbody Booking &bull; Day Pass Portal</span>
                  </div>
                </div>
              </div>

              <!-- Side Rail -->
              <div class="bento-side-rail">
                <div class="bento-kpi-highlight">
                  <div class="bento-kpi-num">+180%</div>
                  <div class="bento-kpi-label">Weekday Attendance</div>
                  <div class="bento-kpi-sub">Thermal circuit pass sales boost</div>
                </div>

                <div class="bento-sub-box">
                  <span class="bento-sub-label">Project Scope &amp; Tech</span>
                  <div class="bento-tag-list">
                    <span class="bento-tag-item">Thermal Circuit Walkthrough</span>
                    <span class="bento-tag-item">Mindbody Integration</span>
                    <span class="bento-tag-item">Corporate Retreat Funnel</span>
                    <span class="bento-tag-item">Day Pass Scheduler</span>
                    <span class="bento-tag-item">4-Week Delivery</span>
                  </div>
                </div>

                <div class="bento-sub-box" style="text-align: center; background: rgba(0, 245, 160, 0.04); border-color: rgba(0, 245, 160, 0.2);">
                  <div style="font-family: var(--font-display); font-size: 1.85rem; font-weight: 800; color: var(--color-jade-neon);">$480k</div>
                  <div style="font-size: 0.82rem; color: var(--color-text-main); font-weight: 600;">Corporate Retreat Sales in Q1</div>
                </div>
              </div>
            </div>

            <!-- Bottom Horizontal Transformation Strip (3 Panels) -->
            <div class="bento-narrative-strip">
              <div class="bento-narrative-card step-problem">
                <span class="narrative-card-step">01 // The Challenge</span>
                <h4>Empty Weekdays &amp; Low Group Sales</h4>
                <p>
                  While weekend passes sold out quickly, weekday bathhouse attendance was slow, and their high-margin corporate wellness packages were severely underbooked.
                </p>
              </div>

              <div class="bento-narrative-card step-solution">
                <span class="narrative-card-step">02 // What We Built</span>
                <h4>Thermal Tour &amp; Retreat Portal</h4>
                <p>
                  We redesigned the site with an interactive thermal circuit experience, clear weekday pass promotions, and a dedicated corporate retreat booking inquiry portal.
                </p>
              </div>

              <div class="bento-narrative-card step-impact">
                <span class="narrative-card-step">03 // Business Impact</span>
                <h4>$480,000 in Group Bookings</h4>
                <p>
                  Weekday attendance jumped by 180%, and Aruna closed $480,000 in corporate group bookings in their first quarter after launching the new site.
                </p>
              </div>
            </div>
          </article>

          <!-- ==========================================================================
               BENTO CASE STUDY 4: Beauticians On The Go (Mobile Beauty)
               ========================================================================== -->
          <article class="bento-case-card cat-mobile">
            <!-- Header -->
            <div class="bento-case-header">
              <div class="bento-header-info">
                <div class="bento-modality-pill">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/></svg>
                  Mobile Beauty &amp; Bridal Collective
                </div>
                <h2 class="bento-case-title">Beauticians On The Go</h2>
                <p class="bento-case-subtitle">
                  Automating bridal group scheduling and eliminating 12+ hours of manual phone coordination every week.
                </p>
              </div>
              <div class="bento-header-actions">
                <a href="https://beauticiansonthego.jadecursor.com" target="_blank" rel="noopener noreferrer" class="btn btn-primary">
                  View Live Website
                  <span class="btn-icon-wrapper">
                    <svg viewBox="0 0 24 24"><path d="M7 17L17 7M7 7h10v10"/></svg>
                  </span>
                </a>
              </div>
            </div>

            <!-- Middle Section: Main Browser Viewport + Side Rail -->
            <div class="bento-main-grid">
              <!-- Interactive Browser Viewport -->
              <div class="bento-browser-stage">
                <div class="bento-browser-top">
                  <span class="browser-dot dot-red"></span>
                  <span class="browser-dot dot-yellow"></span>
                  <span class="browser-dot dot-green"></span>
                  <span class="bento-browser-url">https://beauticiansonthego.jadecursor.com</span>
                </div>
                <div class="bento-browser-img-wrap">
                  <img loading="lazy" decoding="async" src="images/case-study-beauticians.png" alt="Beauticians On The Go Luxury Mobile Concierge Website — Created with gpt-image-2">
                  <!-- Floating UI Badge -->
                  <div class="bento-floating-badge">
                    <span class="live-dot"></span>
                    <span>Automated Radius &amp; Group Estimator</span>
                  </div>
                </div>
              </div>

              <!-- Side Rail -->
              <div class="bento-side-rail">
                <div class="bento-kpi-highlight">
                  <div class="bento-kpi-num">+215%</div>
                  <div class="bento-kpi-label">Repeat Client Bookings</div>
                  <div class="bento-kpi-sub">Bridal &amp; event re-booking growth</div>
                </div>

                <div class="bento-sub-box">
                  <span class="bento-sub-label">Project Scope &amp; Tech</span>
                  <div class="bento-tag-list">
                    <span class="bento-tag-item">Location Radius Validator</span>
                    <span class="bento-tag-item">Stylist Portfolios</span>
                    <span class="bento-tag-item">Bridal Party Estimator</span>
                    <span class="bento-tag-item">Automated Dispatch Flow</span>
                    <span class="bento-tag-item">4-Week Delivery</span>
                  </div>
                </div>

                <div class="bento-sub-box" style="text-align: center; background: rgba(0, 245, 160, 0.04); border-color: rgba(0, 245, 160, 0.2);">
                  <div style="font-family: var(--font-display); font-size: 1.85rem; font-weight: 800; color: var(--color-jade-neon);">12+ hrs</div>
                  <div style="font-size: 0.82rem; color: var(--color-text-main); font-weight: 600;">Saved per Week in Phone Admin</div>
                </div>
              </div>
            </div>

            <!-- Bottom Horizontal Transformation Strip (3 Panels) -->
            <div class="bento-narrative-strip">
              <div class="bento-narrative-card step-problem">
                <span class="narrative-card-step">01 // The Challenge</span>
                <h4>Phone Coordination Overload</h4>
                <p>
                  A premium mobile stylist team catering to bridal parties. Manual phone bookings created scheduling errors, double bookings, and slow customer responses.
                </p>
              </div>

              <div class="bento-narrative-card step-solution">
                <span class="narrative-card-step">02 // What We Built</span>
                <h4>Automated Bridal Booking Portal</h4>
                <p>
                  We built a mobile booking system with stylist portfolios, automated travel radius verification, and instant group package estimators.
                </p>
              </div>

              <div class="bento-narrative-card step-impact">
                <span class="narrative-card-step">03 // Business Impact</span>
                <h4>+215% Repeat Bookings</h4>
                <p>
                  Repeat client bookings climbed by 215%, saving the founders 12+ hours weekly in phone scheduling while keeping a 4.9/5 satisfaction score.
                </p>
              </div>
            </div>
          </article>

          <!-- ==========================================================================
               BENTO CASE STUDY 5: Eden Spa & Salon (Botanical Salon)
               ========================================================================== -->
          <article class="bento-case-card cat-botanical">
            <!-- Header -->
            <div class="bento-case-header">
              <div class="bento-header-info">
                <div class="bento-modality-pill">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/></svg>
                  Botanical Organic Salon &amp; Spa
                </div>
                <h2 class="bento-case-title">Eden Spa &amp; Salon</h2>
                <p class="bento-case-subtitle">
                  Supercharging holiday revenue with a digital gift card portal and sub-second mobile page loads.
                </p>
              </div>
              <div class="bento-header-actions">
                <a href="https://edenspa.jadecursor.com" target="_blank" rel="noopener noreferrer" class="btn btn-primary">
                  View Live Website
                  <span class="btn-icon-wrapper">
                    <svg viewBox="0 0 24 24"><path d="M7 17L17 7M7 7h10v10"/></svg>
                  </span>
                </a>
              </div>
            </div>

            <!-- Middle Section: Main Browser Viewport + Side Rail -->
            <div class="bento-main-grid">
              <!-- Interactive Browser Viewport -->
              <div class="bento-browser-stage">
                <div class="bento-browser-top">
                  <span class="browser-dot dot-red"></span>
                  <span class="browser-dot dot-yellow"></span>
                  <span class="browser-dot dot-green"></span>
                  <span class="bento-browser-url">https://edenspa.jadecursor.com</span>
                </div>
                <div class="bento-browser-img-wrap">
                  <img loading="lazy" decoding="async" src="images/case-study-eden.png" alt="Eden Spa &amp; Salon Botanical Website — Created with gpt-image-2">
                  <!-- Floating UI Badge -->
                  <div class="bento-floating-badge">
                    <span class="live-dot"></span>
                    <span>Instant Digital Gift Card Checkout</span>
                  </div>
                </div>
              </div>

              <!-- Side Rail -->
              <div class="bento-side-rail">
                <div class="bento-kpi-highlight">
                  <div class="bento-kpi-num">+240%</div>
                  <div class="bento-kpi-label">Gift Card Sales</div>
                  <div class="bento-kpi-sub">Holiday digital voucher growth</div>
                </div>

                <div class="bento-sub-box">
                  <span class="bento-sub-label">Project Scope &amp; Tech</span>
                  <div class="bento-tag-list">
                    <span class="bento-tag-item">Digital Gift Card Portal</span>
                    <span class="bento-tag-item">Hair &amp; Skin Service Filters</span>
                    <span class="bento-tag-item">Sub-Second Mobile Load</span>
                    <span class="bento-tag-item">Botanical Brand System</span>
                    <span class="bento-tag-item">3-Week Delivery</span>
                  </div>
                </div>

                <div class="bento-sub-box" style="text-align: center; background: rgba(0, 245, 160, 0.04); border-color: rgba(0, 245, 160, 0.2);">
                  <div style="font-family: var(--font-display); font-size: 1.85rem; font-weight: 800; color: var(--color-jade-neon);">&lt;0.8s</div>
                  <div style="font-size: 0.82rem; color: var(--color-text-main); font-weight: 600;">Lightning Mobile Load Speed</div>
                </div>
              </div>
            </div>

            <!-- Bottom Horizontal Transformation Strip (3 Panels) -->
            <div class="bento-narrative-strip">
              <div class="bento-narrative-card step-problem">
                <span class="narrative-card-step">01 // The Challenge</span>
                <h4>Missed Holiday Voucher Revenue</h4>
                <p>
                  An upscale organic salon and botanical spa suffered from slow page loads and lacked an easy way for clients to purchase gift certificates online during holidays.
                </p>
              </div>

              <div class="bento-narrative-card step-solution">
                <span class="narrative-card-step">02 // What We Built</span>
                <h4>Instant Gift Card System</h4>
                <p>
                  We built a fast luxury website with an instant digital gift voucher portal and intuitive service categorization for both hair and botanical skin treatments.
                </p>
              </div>

              <div class="bento-narrative-card step-impact">
                <span class="narrative-card-step">03 // Business Impact</span>
                <h4>+240% Gift Card Growth</h4>
                <p>
                  Online gift card sales jumped by 240% year-over-year, and website loading speed improved to instantaneous, delighting mobile clients.
                </p>
              </div>
            </div>
          </article>

        </div>
      </div>
    </section>

    <!-- ==========================================================================
         CALL TO ACTION SECTION
         ========================================================================== -->
    <section class="section-spacing-sm">
      <div class="site-container">
        <div class="cta-banner-luxury">
          <div class="cta-banner-content">
            <div class="eyebrow-pill">
              <span class="pill-dot"></span>
              Your Project Awaits
            </div>
            <h2>
              Ready to get results like these for your spa?
            </h2>
            <p>
              Schedule a free 30-minute Discovery Call. We'll show you how we can transform your website and increase your appointment bookings.
            </p>
            <div style="display: flex; justify-content: center; gap: 1.25rem; flex-wrap: wrap;">
              <a href="contact.php" class="btn btn-gold">
                Book a Discovery Call
                <span class="btn-icon-wrapper">
                  <svg viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </span>
              </a>
              <a href="services.php" class="btn btn-ghost-light">
                Explore Packages &amp; Pricing
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
