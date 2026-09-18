/**
 * Spa Design Hub — High-Performance Booking Engine
 * Dynamic Calendar & Timeslot Scheduler
 * 
 * Features:
 * - Real-time business day generator (Mon-Fri) starting strictly from today/future
 * - Multi-week window navigation with past navigation strictly locked
 * - Dynamic month/year range detection
 * - Client local clock timeslot disabling for elapsed slots on "Today"
 * - Automatic selection of first valid future slot
 * - Auto-timezone detection & synchronization with form submission
 */

(function () {
  'use strict';

  // Configurable booking parameters
  const MAX_WEEK_OFFSET = 4; // Up to 5 weeks out
  const TIME_SLOTS = [
    { id: 'time-1000', value: '10:00 AM EST', label: '10:00 AM', hour: 10, minute: 0 },
    { id: 'time-1130', value: '11:30 AM EST', label: '11:30 AM', hour: 11, minute: 30 },
    { id: 'time-1330', value: '1:30 PM EST', label: '1:30 PM', hour: 13, minute: 30 },
    { id: 'time-1500', value: '3:00 PM EST', label: '3:00 PM', hour: 15, minute: 0 },
    { id: 'time-1630', value: '4:30 PM EST', label: '4:30 PM', hour: 16, minute: 30 },
    { id: 'time-1730', value: '5:30 PM EST', label: '5:30 PM', hour: 17, minute: 30 }
  ];

  let currentWeekOffset = 0;
  let selectedDateStr = null;
  let selectedTimeStr = '1:30 PM EST';

  document.addEventListener('DOMContentLoaded', () => {
    initBookingEngine();
  });

  function initBookingEngine() {
    const calendarContainer = document.querySelector('.calendar-module');
    if (!calendarContainer) return;

    initTimezone();
    initNavigationControls();
    renderBookingCalendar();
    bindTimeslotEvents();
  }

  /**
   * Auto-detect client timezone and inject into hidden form field
   */
  function initTimezone() {
    const tzDisplay = document.getElementById('calendar-tz-display') || document.querySelector('.calendar-timezone-tag');
    let userTz = 'Eastern Time (US & Canada)';

    try {
      userTz = Intl.DateTimeFormat().resolvedOptions().timeZone || userTz;
      if (tzDisplay) {
        tzDisplay.textContent = `Your Timezone: ${userTz} (Auto-Detected)`;
      }
    } catch (e) {
      if (tzDisplay) {
        tzDisplay.textContent = `Timezone: Eastern Time (US & Canada)`;
      }
    }

    // Ensure hidden input exists for submission
    const form = document.querySelector('form[action*="booking"], form[action*="book-a-call"], .booking-engine-card form');
    if (form && !form.querySelector('input[name="client_timezone"]')) {
      const tzInput = document.createElement('input');
      tzInput.type = 'hidden';
      tzInput.name = 'client_timezone';
      tzInput.value = userTz;
      form.appendChild(tzInput);
    }
  }

  /**
   * Set up < Prev and Next > week pagination buttons
   */
  function initNavigationControls() {
    const prevBtn = document.getElementById('calendar-prev-btn');
    const nextBtn = document.getElementById('calendar-next-btn');

    if (prevBtn) {
      prevBtn.addEventListener('click', (e) => {
        e.preventDefault();
        if (currentWeekOffset > 0) {
          currentWeekOffset--;
          renderBookingCalendar();
        }
      });
    }

    if (nextBtn) {
      nextBtn.addEventListener('click', (e) => {
        e.preventDefault();
        if (currentWeekOffset < MAX_WEEK_OFFSET) {
          currentWeekOffset++;
          renderBookingCalendar();
        }
      });
    }
  }

  /**
   * Get 5 business days for given week offset starting from today or next business day
   */
  function getBusinessDaysForOffset(offset) {
    const days = [];
    const now = new Date();
    
    // Check if today has any valid timeslots left
    const nowHour = now.getHours();
    const nowMin = now.getMinutes();
    const isPastEndOfDay = nowHour > 17 || (nowHour === 17 && nowMin >= 30);

    let checkDate = new Date(now.getFullYear(), now.getMonth(), now.getDate());

    // If today is a weekday and already past business hours, advance to tomorrow
    if (isPastEndOfDay && checkDate.getDay() >= 1 && checkDate.getDay() <= 5) {
      checkDate.setDate(checkDate.getDate() + 1);
    }

    // Advance to find the start of business days
    let businessDaysFound = 0;
    const targetStartIndex = offset * 5;

    while (businessDaysFound < targetStartIndex) {
      const dayOfWeek = checkDate.getDay();
      if (dayOfWeek >= 1 && dayOfWeek <= 5) { // Mon-Fri
        businessDaysFound++;
      }
      checkDate.setDate(checkDate.getDate() + 1);
    }

    // Now collect 5 consecutive business days
    while (days.length < 5) {
      const dayOfWeek = checkDate.getDay();
      if (dayOfWeek >= 1 && dayOfWeek <= 5) {
        days.push(new Date(checkDate));
      }
      checkDate.setDate(checkDate.getDate() + 1);
    }

    return days;
  }

  /**
   * Render the 5 days into .calendar-days-row and update the month/year label
   */
  function renderBookingCalendar() {
    const daysContainer = document.getElementById('calendar-days-container') || document.querySelector('.calendar-days-row');
    const monthDisplay = document.getElementById('calendar-month-display') || document.querySelector('.calendar-month-label');
    const prevBtn = document.getElementById('calendar-prev-btn');
    const nextBtn = document.getElementById('calendar-next-btn');

    if (!daysContainer) return;

    // Update navigation button states
    if (prevBtn) {
      prevBtn.disabled = (currentWeekOffset <= 0);
      prevBtn.setAttribute('aria-disabled', String(currentWeekOffset <= 0));
    }
    if (nextBtn) {
      nextBtn.disabled = (currentWeekOffset >= MAX_WEEK_OFFSET);
      nextBtn.setAttribute('aria-disabled', String(currentWeekOffset >= MAX_WEEK_OFFSET));
    }

    const businessDays = getBusinessDaysForOffset(currentWeekOffset);
    if (!businessDays || businessDays.length === 0) return;

    // Format Month & Year label
    const firstDay = businessDays[0];
    const lastDay = businessDays[businessDays.length - 1];

    const firstMonthStr = firstDay.toLocaleDateString('en-US', { month: 'long' });
    const lastMonthStr = lastDay.toLocaleDateString('en-US', { month: 'long' });
    const firstYear = firstDay.getFullYear();
    const lastYear = lastDay.getFullYear();

    if (monthDisplay) {
      if (firstMonthStr === lastMonthStr && firstYear === lastYear) {
        monthDisplay.textContent = `${firstMonthStr} ${firstYear}`;
      } else if (firstYear === lastYear) {
        monthDisplay.textContent = `${firstDay.toLocaleDateString('en-US', { month: 'short' })} — ${lastDay.toLocaleDateString('en-US', { month: 'short' })} ${firstYear}`;
      } else {
        monthDisplay.textContent = `${firstDay.toLocaleDateString('en-US', { month: 'short' })} ${firstYear} — ${lastDay.toLocaleDateString('en-US', { month: 'short' })} ${lastYear}`;
      }
    }

    // Determine today string
    const today = new Date();
    const todayStr = formatDateISO(today);

    // If current selected date is not in this window, default to first day
    const availableDates = businessDays.map(d => formatDateISO(d));
    if (!selectedDateStr || !availableDates.includes(selectedDateStr)) {
      selectedDateStr = availableDates[0];
    }

    // Render 5 date radio buttons
    daysContainer.innerHTML = '';

    businessDays.forEach((dateObj, idx) => {
      const dateISO = formatDateISO(dateObj);
      const isToday = (dateISO === todayStr);
      const dayAbbr = dateObj.toLocaleDateString('en-US', { weekday: 'short' });
      const dayNum = dateObj.getDate();
      const fullReadable = dateObj.toLocaleDateString('en-US', { weekday: 'long', month: 'short', day: 'numeric', year: 'numeric' });
      const isChecked = (dateISO === selectedDateStr);
      const inputId = `date-slot-${idx}`;

      const wrapper = document.createElement('div');
      wrapper.className = 'calendar-day-cell';

      const input = document.createElement('input');
      input.type = 'radio';
      input.name = 'call-date';
      input.id = inputId;
      input.className = 'date-radio';
      input.value = dateISO;
      input.setAttribute('data-readable', fullReadable);
      if (isChecked) input.checked = true;

      const label = document.createElement('label');
      label.htmlFor = inputId;
      label.className = `date-btn-label ${isChecked ? 'selected' : ''}`;
      label.setAttribute('aria-label', fullReadable);

      let innerHtml = '';
      if (isToday) {
        innerHtml += `<span class="date-today-badge">TODAY</span>`;
      }
      innerHtml += `
        <span class="date-day-abbr">${dayAbbr}</span>
        <span class="date-num">${dayNum}</span>
      `;
      label.innerHTML = innerHtml;

      input.addEventListener('change', () => {
        document.querySelectorAll('.date-btn-label').forEach(el => el.classList.remove('selected'));
        label.classList.add('selected');
        selectedDateStr = dateISO;
        updateTimeslotsAvailability();
      });

      wrapper.appendChild(input);
      wrapper.appendChild(label);
      daysContainer.appendChild(wrapper);
    });

    // Update timeslots for the currently active day
    updateTimeslotsAvailability();
  }

  /**
   * Filter and disable timeslots if the selected date is "Today" and time has elapsed
   */
  function updateTimeslotsAvailability() {
    const today = new Date();
    const todayStr = formatDateISO(today);
    const isSelectedDayToday = (selectedDateStr === todayStr);

    const nowHour = today.getHours();
    const nowMin = today.getMinutes();
    const bufferMinutes = 45; // 45-min advance scheduling buffer

    let hasSelectedValidTime = false;
    let firstAvailableRadio = null;

    TIME_SLOTS.forEach(slot => {
      const radio = document.getElementById(slot.id);
      if (!radio) return;
      const label = document.querySelector(`label[for="${slot.id}"]`);

      let isElapsed = false;
      if (isSelectedDayToday) {
        const slotTotalMin = slot.hour * 60 + slot.minute;
        const nowTotalMin = nowHour * 60 + nowMin + bufferMinutes;
        if (slotTotalMin <= nowTotalMin) {
          isElapsed = true;
        }
      }

      if (isElapsed) {
        radio.disabled = true;
        if (label) {
          label.classList.add('slot-disabled');
          label.classList.remove('selected');
          label.title = 'This timeslot has elapsed for today';
        }
        if (radio.checked) {
          radio.checked = false;
        }
      } else {
        radio.disabled = false;
        if (label) {
          label.classList.remove('slot-disabled');
          label.title = `Book ${slot.label}`;
        }
        if (!firstAvailableRadio) {
          firstAvailableRadio = radio;
        }
        if (radio.checked) {
          hasSelectedValidTime = true;
        }
      }
    });

    // If the currently selected timeslot became disabled or nothing is checked, pick the first valid
    if (!hasSelectedValidTime && firstAvailableRadio) {
      firstAvailableRadio.checked = true;
      selectedTimeStr = firstAvailableRadio.value;
      const label = document.querySelector(`label[for="${firstAvailableRadio.id}"]`);
      if (label) label.classList.add('selected');
    }
  }

  /**
   * Bind event listeners to timeslots
   */
  function bindTimeslotEvents() {
    const timeRadios = document.querySelectorAll('input[name="call-time"], input[name="call_time"]');
    timeRadios.forEach(radio => {
      radio.addEventListener('change', () => {
        document.querySelectorAll('.time-btn-label').forEach(el => el.classList.remove('selected'));
        const label = document.querySelector(`label[for="${radio.id}"]`);
        if (label) label.classList.add('selected');
        selectedTimeStr = radio.value;
      });
    });
  }

  /**
   * Helper to format a Date object as YYYY-MM-DD
   */
  function formatDateISO(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
  }

})();
