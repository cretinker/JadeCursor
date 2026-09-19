<?php
$pageTitle = "Book a 30-Min Discovery Strategy Call | Spa Design Hub";
$pageDescription = "Schedule a free 30-minute 1-on-1 strategy session with Principal Design Director Elijah Adah. Live mobile audit and transparent project roadmap.";
$currentPage = "book-a-call";
$extraScripts = ["js/booking.js"];

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
          Private 30-Minute Strategy Session
        </div>
        <h1>
          Schedule your spa website <span class="text-jade-accent">strategy session</span>.
        </h1>
        <p class="lead">
          A complimentary 30-minute private consultation with our principal design director. We'll audit your current website live, spot where mobile visitors are dropping off, and map out a custom 4-week build plan.
        </p>
      </div>
    </section>

    <!-- ==========================================================================
         MAIN INTERACTIVE BOOKING STAGE
         ========================================================================== -->
    <section class="section-spacing">
      <div class="site-container">
        <div class="booking-layout-grid">

          <!-- Left Column: Interactive Intake & Scheduling Engine -->
          <div class="booking-engine-card">
            <form action="api/booking.php" method="POST">
              <?= CSRF::getInputField() ?>
              
              <!-- STEP 1: Date & Time Selection -->
              <div class="form-group">
                <div class="booking-step-title">
                  <span class="booking-step-num">STEP 01</span>
                  Select Your Preferred Date &amp; Time
                </div>

                <?php
                // Dynamic fallback generation of 5 upcoming business days
                $bookingDays = [];
                $checkDate = new DateTime('today');
                $estTz = new DateTimeZone('America/New_York');
                $nowInEst = new DateTime('now', $estTz);
                if ((int)$nowInEst->format('H') >= 17 && (int)$nowInEst->format('i') >= 30) {
                    $checkDate->modify('+1 day');
                }
                while (count($bookingDays) < 5) {
                    if ((int)$checkDate->format('N') <= 5) { // Mon-Fri
                        $bookingDays[] = clone $checkDate;
                    }
                    $checkDate->modify('+1 day');
                }
                $monthStart = $bookingDays[0]->format('F Y');
                $monthEnd = end($bookingDays)->format('F Y');
                $ssrMonthLabel = ($monthStart === $monthEnd) ? $monthStart : $bookingDays[0]->format('M') . ' — ' . end($bookingDays)->format('M Y');
                ?>

                <div class="calendar-module">
                  <div class="calendar-header-row">
                    <div class="calendar-header-left">
                      <span class="calendar-month-label" id="calendar-month-display"><?= htmlspecialchars($ssrMonthLabel) ?></span>
                      <div class="calendar-nav-group" aria-label="Calendar Week Navigation">
                        <button type="button" class="calendar-nav-btn" id="calendar-prev-btn" aria-label="Previous available days" title="Previous week" disabled>
                          <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        </button>
                        <button type="button" class="calendar-nav-btn" id="calendar-next-btn" aria-label="Next available days" title="Next week">
                          <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </button>
                      </div>
                    </div>
                    <span class="calendar-timezone-tag" id="calendar-tz-display">Timezone: Eastern Time (US &amp; Canada)</span>
                  </div>

                  <!-- 5 Selectable Date Radios (SSR with JS Rehydration) -->
                  <div class="calendar-days-row" id="calendar-days-container" role="radiogroup" aria-label="Select Consultation Date">
                    <?php 
                    $todayYmd = (new DateTime('today'))->format('Y-m-d');
                    foreach ($bookingDays as $idx => $bDay): 
                      $bDateStr = $bDay->format('Y-m-d');
                      $isToday = ($bDateStr === $todayYmd);
                      $bAbbr = $bDay->format('D');
                      $bNum = $bDay->format('j');
                      $bReadable = $bDay->format('l, M j, Y');
                      $inputId = "date-slot-" . $idx;
                      $isChecked = ($idx === 0);
                    ?>
                      <div>
                        <input type="radio" name="call-date" id="<?= $inputId ?>" class="date-radio" value="<?= $bDateStr ?>" data-readable="<?= htmlspecialchars($bReadable) ?>" <?= $isChecked ? 'checked' : '' ?>>
                        <label for="<?= $inputId ?>" class="date-btn-label <?= $isChecked ? 'selected' : '' ?>">
                          <?php if ($isToday): ?>
                            <span class="date-today-badge">TODAY</span>
                          <?php endif; ?>
                          <span class="date-day-abbr"><?= htmlspecialchars($bAbbr) ?></span>
                          <span class="date-num"><?= htmlspecialchars($bNum) ?></span>
                        </label>
                      </div>
                    <?php endforeach; ?>
                  </div>

                  <!-- Selectable Time Slots -->
                  <span style="display: block; font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; color: var(--color-text-muted); margin-bottom: 0.75rem;">
                    Available 30-Min Timeslots:
                  </span>
                  <div class="timeslot-grid">
                    <div>
                      <input type="radio" name="call-time" id="time-1000" class="time-radio" value="10:00 AM EST">
                      <label for="time-1000" class="time-btn-label">10:00 AM</label>
                    </div>
                    <div>
                      <input type="radio" name="call-time" id="time-1130" class="time-radio" value="11:30 AM EST">
                      <label for="time-1130" class="time-btn-label">11:30 AM</label>
                    </div>
                    <div>
                      <input type="radio" name="call-time" id="time-1330" class="time-radio" value="1:30 PM EST" checked>
                      <label for="time-1330" class="time-btn-label">1:30 PM</label>
                    </div>
                    <div>
                      <input type="radio" name="call-time" id="time-1500" class="time-radio" value="3:00 PM EST">
                      <label for="time-1500" class="time-btn-label">3:00 PM</label>
                    </div>
                    <div>
                      <input type="radio" name="call-time" id="time-1630" class="time-radio" value="4:30 PM EST">
                      <label for="time-1630" class="time-btn-label">4:30 PM</label>
                    </div>
                    <div>
                      <input type="radio" name="call-time" id="time-1730" class="time-radio" value="5:30 PM EST">
                      <label for="time-1730" class="time-btn-label">5:30 PM</label>
                    </div>
                  </div>
                </div>
              </div>

              <!-- STEP 2: Spa Modality & Booking Software -->
              <div class="form-group">
                <div class="booking-step-title">
                  <span class="booking-step-num">STEP 02</span>
                  Your Business Category &amp; Booking Software
                </div>

                <div style="margin-bottom: 1.25rem;">
                  <label class="form-label" style="margin-bottom: 0.65rem;">What type of wellness business do you run?</label>
                  <div class="chip-grid">
                    <div>
                      <input type="radio" name="spa_type" id="type_dayspa" class="chip-input" value="Day Spa / Massage" checked>
                      <label for="type_dayspa" class="chip-label">Day Spa / Massage</label>
                    </div>
                    <div>
                      <input type="radio" name="spa_type" id="type_medspa" class="chip-input" value="MedSpa / Esthetics">
                      <label for="type_medspa" class="chip-label">Medical Aesthetics</label>
                    </div>
                    <div>
                      <input type="radio" name="spa_type" id="type_salon" class="chip-input" value="Luxury Salon">
                      <label for="type_salon" class="chip-label">Luxury Salon</label>
                    </div>
                    <div>
                      <input type="radio" name="spa_type" id="type_bathhouse" class="chip-input" value="Bathhouse / Thermal">
                      <label for="type_bathhouse" class="chip-label">Bathhouse / Thermal</label>
                    </div>
                    <div>
                      <input type="radio" name="spa_type" id="type_mobile" class="chip-input" value="Mobile Stylist">
                      <label for="type_mobile" class="chip-label">Mobile Collective</label>
                    </div>
                  </div>
                </div>

                <div>
                  <label class="form-label" style="margin-bottom: 0.65rem;">Which booking software do you use?</label>
                  <div class="chip-grid">
                    <div>
                      <input type="radio" name="software" id="soft_boulevard" class="chip-input" value="Boulevard" checked>
                      <label for="soft_boulevard" class="chip-label">Boulevard</label>
                    </div>
                    <div>
                      <input type="radio" name="software" id="soft_jane" class="chip-input" value="Jane App">
                      <label for="soft_jane" class="chip-label">Jane App</label>
                    </div>
                    <div>
                      <input type="radio" name="software" id="soft_mindbody" class="chip-input" value="Mindbody">
                      <label for="soft_mindbody" class="chip-label">Mindbody</label>
                    </div>
                    <div>
                      <input type="radio" name="software" id="soft_phorest" class="chip-input" value="Phorest">
                      <label for="soft_phorest" class="chip-label">Phorest</label>
                    </div>
                    <div>
                      <input type="radio" name="software" id="soft_fresha" class="chip-input" value="Fresha / Vagaro">
                      <label for="soft_fresha" class="chip-label">Fresha / Vagaro</label>
                    </div>
                    <div>
                      <input type="radio" name="software" id="soft_other" class="chip-input" value="Other / None">
                      <label for="soft_other" class="chip-label">Other / None</label>
                    </div>
                  </div>
                </div>
              </div>

              <!-- STEP 3: Contact & Website Details -->
              <div class="form-group">
                <div class="booking-step-title">
                  <span class="booking-step-num">STEP 03</span>
                  Your Details &amp; Website
                </div>

                <div class="form-row-2col">
                  <div class="form-group">
                    <label for="name" class="form-label">Your Full Name *</label>
                    <input type="text" id="name" name="name" class="form-input" placeholder="e.g. Sarah Jenkins" required>
                  </div>
                  <div class="form-group">
                    <label for="email" class="form-label">Work Email *</label>
                    <input type="email" id="email" name="email" class="form-input" placeholder="sarah@yourspa.com" required>
                  </div>
                </div>

                <div class="form-row-2col">
                  <div class="form-group">
                    <label for="website" class="form-label">Current Spa Website URL *</label>
                    <input type="url" id="website" name="website" class="form-input" placeholder="https://yourspa.com" required>
                  </div>
                  <div class="form-group">
                    <label for="phone" class="form-label">Phone Number (Optional)</label>
                    <input type="tel" id="phone" name="phone" class="form-input" placeholder="+1 (555) 000-0000">
                  </div>
                </div>

                <div class="form-group">
                  <label for="primary_goal" class="form-label">Primary Goal for This Redesign *</label>
                  <select id="primary_goal" name="primary_goal" class="form-select" required>
                    <option value="Double Direct Online Bookings">Double Direct Online Bookings &amp; Eliminate Phone Churn</option>
                    <option value="Fix Broken Mobile Experience">Fix Slow / Broken Mobile Experience</option>
                    <option value="Launch High-Ticket Packages">Launch High-Ticket Treatment Funnels &amp; Gift Cards</option>
                    <option value="Complete Luxury Rebranding">Complete Visual Rebrand to Match In-Person Luxury</option>
                    <option value="New Spa Grand Opening">Building a New Website for an Upcoming Spa Opening</option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="notes" class="form-label">Anything specific you'd like us to prepare for our call?</label>
                  <textarea id="notes" name="notes" class="form-textarea" placeholder="Tell us about any specific frustrations with your current website or scheduling flow..."></textarea>
                </div>
              </div>

              <!-- Submit CTA -->
              <div style="margin-top: 2rem;">
                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1.15rem; font-size: 1.05rem;">
                  Confirm 30-Minute Discovery Session
                  <span class="btn-icon-wrapper">
                    <svg viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                  </span>
                </button>
                <p style="font-size: 0.8rem; text-align: center; color: var(--color-text-muted); margin-top: 0.85rem;">
                  🔒 100% Free Consultation. No sales pitch. You will receive a calendar invite with a private video link instantly.
                </p>
              </div>

            </form>
          </div>

          <!-- Right Column: Value Rail, Agenda & Proof -->
          <div class="booking-value-rail">

            <!-- Sprint Scarcity Card -->
            <div class="sprint-scarcity-alert">
              <span class="scarcity-dot"></span>
              <span><strong>Studio Availability:</strong> Only 2 Client Onboarding Slots Open for This Month</span>
            </div>

            <!-- Call Agenda Card -->
            <div class="rail-card rail-card-highlight">
              <div class="eyebrow-pill" style="margin-bottom: 0.75rem;">
                <span class="pill-dot"></span>
                Call Agenda
              </div>
              <h3 style="font-size: 1.35rem; color: var(--color-espresso);">What We'll Cover in 30 Min:</h3>
              
              <div class="agenda-list">
                <div class="agenda-item">
                  <span class="agenda-num-bullet">01</span>
                  <div>
                    <strong>Live Mobile &amp; Speed Audit</strong>
                    <p style="font-size: 0.85rem; margin-top: 2px;">We inspect your live site on mobile devices to pinpoint exactly where prospective clients drop off.</p>
                  </div>
                </div>

                <div class="agenda-item">
                  <span class="agenda-num-bullet">02</span>
                  <div>
                    <strong>Booking Architecture Strategy</strong>
                    <p style="font-size: 0.85rem; margin-top: 2px;">How to deep-link treatments directly into your scheduling software to cut booking steps in half.</p>
                  </div>
                </div>

                <div class="agenda-item">
                  <span class="agenda-num-bullet">03</span>
                  <div>
                    <strong>Transparent Roadmap &amp; Scope</strong>
                    <p style="font-size: 0.85rem; margin-top: 2px;">We review clear options (from $195/mo care plans to complete turnkey builds) tailored to your goals.</p>
                  </div>
                </div>

                <div class="agenda-item">
                  <span class="agenda-num-bullet">04</span>
                  <div>
                    <strong>Revenue Lift Forecast</strong>
                    <p style="font-size: 0.85rem; margin-top: 2px;">A realistic forecast of how many additional direct appointments your spa can capture every month.</p>
                  </div>
                </div>
              </div>

              <!-- Director Bio -->
              <div class="director-profile-box">
                <img loading="lazy" decoding="async" src="images/founder-elijah-adah.jpg" alt="Elijah Adah — Founder &amp; Principal Design Director" class="director-avatar">
                <div>
                  <div style="font-family: var(--font-display); font-size: 0.95rem; font-weight: 700; color: var(--color-espresso);">Elijah Adah</div>
                  <div style="font-size: 0.78rem; color: var(--color-gold-text); font-weight: 600;">Founder &amp; Principal Design Director</div>
                  <div style="font-size: 0.75rem; color: var(--color-text-muted);">Direct consultation &bull; No junior middlemen</div>
                </div>
              </div>
            </div>

            <!-- Client Proof Card -->
            <div class="rail-card">
              <div style="display: flex; gap: 0.25rem; color: var(--color-gold-text); margin-bottom: 0.75rem;">
                &#9733;&#9733;&#9733;&#9733;&#9733;
              </div>
              <p style="font-size: 0.92rem; color: var(--color-text-muted); font-style: italic; line-height: 1.6; margin-bottom: 1rem;">
                "Our 30-minute discovery call gave us more actionable clarity on our booking leaks than 6 months with our previous generalist agency. Within weeks of launching our new site, our direct online inquiries surged."
              </p>
              <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--color-border); padding-top: 0.75rem;">
                <span style="font-size: 0.82rem; font-weight: 700; color: var(--color-espresso);">Dr. Chloe Chen, Founder</span>
                <span style="font-size: 0.75rem; font-family: var(--font-mono); color: var(--color-gold-text); font-weight: 700;">Soleil MedSpa (+310% Bookings)</span>
              </div>
            </div>

          </div>
        </div>
      </div>
    </section>

    <!-- ==========================================================================
         WHAT HAPPENS NEXT SECTION (3 STEPS)
         ========================================================================== -->
    <section class="section-spacing-sm" style="background-color: var(--color-bg-alt); border-top: 1px solid var(--color-border); border-bottom: 1px solid var(--color-border);">
      <div class="site-container">
        <div class="section-header text-center">
          <div class="eyebrow-pill">
            <span class="pill-dot"></span>
            Zero Friction
          </div>
          <h2>
            What happens <span class="text-jade-accent">after you book</span>?
          </h2>
          <p>
            We respect your time as a busy spa founder. Here is exactly how our discovery process works:
          </p>
        </div>

        <div class="bento-narrative-strip">
          <div class="bento-narrative-card step-solution">
            <span class="narrative-card-step">01 // Instant Calendar Confirmation</span>
            <h4>Calendar Invite &amp; Video Link</h4>
            <p>
              You'll immediately receive a calendar invitation with a private Google Meet link. No preparation or complicated questionnaires required.
            </p>
          </div>

          <div class="bento-narrative-card step-impact">
            <span class="narrative-card-step">02 // 30-Min Strategy Session</span>
            <h4>Actionable Live Audit</h4>
            <p>
              We meet for 30 minutes. We review your live website on screen, show you exactly where appointments are leaking, and share design solutions.
            </p>
          </div>

          <div class="bento-narrative-card step-solution">
            <span class="narrative-card-step">03 // Custom Blueprint &amp; Scope</span>
            <h4>Same-Day Written Proposal</h4>
            <p>
              Following our call, you receive a detailed, fixed-price project roadmap with transparent pricing options so you can make an informed decision.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- ==========================================================================
         FREQUENTLY ASKED QUESTIONS
         ========================================================================== -->
    <section class="section-spacing">
      <div class="site-container-narrow">
        <div class="section-header text-center">
          <div class="eyebrow-pill">
            <span class="pill-dot"></span>
            Pre-Call Questions
          </div>
          <h2>
            Frequently asked questions about <span class="text-jade-accent">our discovery calls</span>.
          </h2>
        </div>

        <div>
          <details class="luxury-accordion" open>
            <summary>
              <span>Is this discovery call really 100% free and without obligation?</span>
              <span class="accordion-indicator"><svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
            </summary>
            <div class="accordion-content">
              <p>
                Yes, absolutely. We do not do high-pressure sales pitches. Our discovery call is designed to analyze your current online booking bottlenecks, answer your questions, and determine whether our design and care plans are a strong mutual fit.
              </p>
            </div>
          </details>

          <details class="luxury-accordion">
            <summary>
              <span>Do I need to have all my photos, menu copy, or branding ready before the call?</span>
              <span class="accordion-indicator"><svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
            </summary>
            <div class="accordion-content">
              <p>
                Not at all. Part of our done-for-you service includes professional high-converting copywriting, menu structuring, and sourcing premium imagery if needed. We will discuss your current assets on the call.
              </p>
            </div>
          </details>

          <details class="luxury-accordion">
            <summary>
              <span>Which booking systems can you connect to our new website?</span>
              <span class="accordion-indicator"><svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
            </summary>
            <div class="accordion-content">
              <p>
                We integrate seamlessly with all major spa and clinic platforms, including Boulevard, Jane App, Mindbody, Phorest, Fresha, Vagaro, Meevo, and Acuity. We deep-link directly to individual services so guests never get lost.
              </p>
            </div>
          </details>

          <details class="luxury-accordion">
            <summary>
              <span>How quickly can we start working together after the call?</span>
              <span class="accordion-indicator"><svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg></span>
            </summary>
            <div class="accordion-content">
              <p>
                Because we work with a dedicated number of spa clients each month, we can typically kick off within 5 to 7 business days of an approved scope. For care plans, onboarding is completed within 48 hours.
              </p>
            </div>
          </details>
        </div>
      </div>
    </section>
  </main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
