/**
 * Jade Cursor - Interactive Booking Engine
 * Handles date picker, timeslot selector, timezone detector, and multi-step intake validation
 */

document.addEventListener('DOMContentLoaded', () => {
  initCalendarEngine();
  initTimezoneDetector();
});

function initCalendarEngine() {
  const dateRadios = document.querySelectorAll('input[name="call-date"], input[name="call_date"]');
  const timeRadios = document.querySelectorAll('input[name="call-time"], input[name="call_time"]');

  // Handle active styling for date labels
  dateRadios.forEach(radio => {
    radio.addEventListener('change', () => {
      document.querySelectorAll('.date-btn-label').forEach(el => el.classList.remove('selected'));
      const label = document.querySelector(`label[for="${radio.id}"]`);
      if (label) label.classList.add('selected');
    });
  });

  // Handle active styling for time slots
  timeRadios.forEach(radio => {
    radio.addEventListener('change', () => {
      document.querySelectorAll('.time-btn-label').forEach(el => el.classList.remove('selected'));
      const label = document.querySelector(`label[for="${radio.id}"]`);
      if (label) label.classList.add('selected');
    });
  });
}

/**
 * Detect client browser timezone and display seamlessly
 */
function initTimezoneDetector() {
  const timezoneTag = document.querySelector('.calendar-timezone-tag');
  if (!timezoneTag) return;

  try {
    const userTz = Intl.DateTimeFormat().resolvedOptions().timeZone;
    if (userTz) {
      timezoneTag.textContent = `Your Timezone: ${userTz} (Auto-Converted)`;
    }
  } catch (e) {
    // Keep fallback EST
  }
}
