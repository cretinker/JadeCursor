<?php
/**
 * Discovery Session Booking API Endpoint
 * Handles submissions from book-a-call.html and book-a-call.php
 */

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/security.php';
require_once __DIR__ . '/../includes/mailer.php';

Security::sendSecurityHeaders();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Security::jsonResponse(false, 'Method not allowed. Only POST requests are accepted.', [], 405);
}

$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

// 1. Rate Limiting Check
if (!Security::checkRateLimit()) {
    if ($isAjax) {
        Security::jsonResponse(false, 'Too many booking attempts. Please wait a few minutes before trying again.', [], 429);
    } else {
        $_SESSION['flash_error'] = 'Too many attempts. Please try again shortly.';
        header('Location: ../book-a-call.php');
        exit;
    }
}

// 2. Honeypot Anti-Spam Check
if (!Security::checkHoneypot($_POST)) {
    if ($isAjax) {
        Security::jsonResponse(true, 'Your discovery call is confirmed.');
    } else {
        header('Location: ../book-a-call.php?status=success');
        exit;
    }
}

// 3. Time-Trap Check
if (!Security::checkTimeTrap($_POST)) {
    if ($isAjax) {
        Security::jsonResponse(false, 'Submission failed verification. Please try again.', [], 400);
    } else {
        $_SESSION['flash_error'] = 'Submission failed verification. Please try again.';
        header('Location: ../book-a-call.php');
        exit;
    }
}

// 4. CSRF Validation
if (!empty($_POST['csrf_token']) && !CSRF::validateToken($_POST['csrf_token'])) {
    if ($isAjax) {
        Security::jsonResponse(false, 'Security token expired. Please refresh the page and try again.', [], 403);
    } else {
        $_SESSION['flash_error'] = 'Security verification failed. Please refresh and try again.';
        header('Location: ../book-a-call.php');
        exit;
    }
}

// 5. Input Sanitization & Validation
$callDate = Security::cleanString($_POST['call-date'] ?? $_POST['call_date'] ?? 'Upcoming Week', 40);
$callTime = Security::cleanString($_POST['call-time'] ?? $_POST['call_time'] ?? '1:30 PM EST', 40);
$spaType = Security::cleanString($_POST['spa_type'] ?? 'Day Spa / Massage', 80);
$software = Security::cleanString($_POST['software'] ?? 'Boulevard', 60);

$name = Security::cleanString($_POST['name'] ?? '', 100);
$email = Security::cleanEmail($_POST['email'] ?? '');
$website = Security::cleanUrl($_POST['website'] ?? '');
$phone = Security::cleanPhone($_POST['phone'] ?? '');
$primaryGoal = Security::cleanString($_POST['primary_goal'] ?? 'Double Direct Online Bookings', 150);
$notes = Security::cleanString($_POST['notes'] ?? '', 2000);

if (empty($name)) {
    $error = 'Please enter your full name.';
} elseif (!$email) {
    $error = 'Please provide a valid work email address.';
} elseif (empty($website)) {
    $error = 'Please enter your current spa website URL.';
} else {
    $error = null;
}

if ($error) {
    if ($isAjax) {
        Security::jsonResponse(false, $error, [], 400);
    } else {
        $_SESSION['flash_error'] = $error;
        header('Location: ../book-a-call.php');
        exit;
    }
}

// 6. Lead Data Package
$leadData = [
    'name' => $name,
    'email' => $email,
    'website' => $website,
    'phone' => $phone,
    'call_date' => $callDate,
    'call_time' => $callTime,
    'spa_type' => $spaType,
    'software' => $software,
    'primary_goal' => $primaryGoal,
    'notes' => $notes
];

// Save to backup file
Mailer::saveLead('discovery_call_booking', $leadData);

// 7. Compose & Send Internal Admin Notification Email
$adminSubject = "📅 Discovery Call Confirmed: {$name} ({$callDate} @ {$callTime})";
$adminHtml = '
<h2 style="color:#8E7350; margin-top:0; font-size:20px;">New Discovery Session Booked</h2>
<p style="color:#5E564F; font-size:14px;">A spa owner has confirmed a 30-minute video strategy session:</p>

<div style="background:rgba(0,245,160,0.08); border:1px solid rgba(0,245,160,0.3); border-radius:8px; padding:15px 20px; margin:15px 0;">
  <div style="font-size:16px; font-weight:700; color:#191512;">' . htmlspecialchars($callDate) . ' at ' . htmlspecialchars($callTime) . '</div>
  <div style="font-size:13px; color:#8E7350; margin-top:3px;">30-Minute Live Consultation &bull; Principal Director: Elijah Vance</div>
</div>

<table style="width:100%; border-collapse:collapse; margin:20px 0; font-size:14px;">
  <tr style="border-bottom:1px solid #E5DDD0;">
    <td style="padding:10px 0; color:#5E564F; width:140px;"><strong>Client Name:</strong></td>
    <td style="padding:10px 0; color:#191512; font-weight:600;">' . htmlspecialchars($name) . '</td>
  </tr>
  <tr style="border-bottom:1px solid #E5DDD0;">
    <td style="padding:10px 0; color:#5E564F;"><strong>Work Email:</strong></td>
    <td style="padding:10px 0; color:#8E7350;"><a href="mailto:' . htmlspecialchars($email) . '" style="color:#8E7350; text-decoration:none;">' . htmlspecialchars($email) . '</a></td>
  </tr>
  <tr style="border-bottom:1px solid #E5DDD0;">
    <td style="padding:10px 0; color:#5E564F;"><strong>Phone:</strong></td>
    <td style="padding:10px 0; color:#191512;">' . ($phone ? htmlspecialchars($phone) : '<span style="color:#8F857B;">None</span>') . '</td>
  </tr>
  <tr style="border-bottom:1px solid #E5DDD0;">
    <td style="padding:10px 0; color:#5E564F;"><strong>Spa Website:</strong></td>
    <td style="padding:10px 0; color:#8E7350;"><a href="' . htmlspecialchars($website) . '" target="_blank" style="color:#8E7350;">' . htmlspecialchars($website) . '</a></td>
  </tr>
  <tr style="border-bottom:1px solid #E5DDD0;">
    <td style="padding:10px 0; color:#5E564F;"><strong>Business Type:</strong></td>
    <td style="padding:10px 0; color:#8E7350; font-weight:600;">' . htmlspecialchars($spaType) . '</td>
  </tr>
  <tr style="border-bottom:1px solid #E5DDD0;">
    <td style="padding:10px 0; color:#5E564F;"><strong>Booking Software:</strong></td>
    <td style="padding:10px 0; color:#8E7350; font-weight:600;">' . htmlspecialchars($software) . '</td>
  </tr>
  <tr style="border-bottom:1px solid #E5DDD0;">
    <td style="padding:10px 0; color:#5E564F;"><strong>Primary Goal:</strong></td>
    <td style="padding:10px 0; color:#8E7350; font-weight:600;">' . htmlspecialchars($primaryGoal) . '</td>
  </tr>
</table>

<div style="background:#FAF8F5; border-left:3px solid #8E7350; padding:15px; border-radius:4px; margin-top:15px;">
  <strong style="color:#191512; display:block; margin-bottom:5px;">Pre-Call Preparation Notes:</strong>
  <p style="color:#332D27; margin:0; font-size:14px; white-space:pre-wrap;">' . ($notes ? nl2br(htmlspecialchars($notes)) : 'No specific notes entered.') . '</p>
</div>
';

Mailer::send(ADMIN_EMAIL, $adminSubject, Mailer::getEmailTemplate('Discovery Call Confirmed', $adminHtml), $email);

// 8. Autoresponder to Client
$clientSubject = "Confirmed: Your Discovery Session with Spa Design Hub ({$callDate})";
$clientHtml = '
<h2 style="color:#8E7350; margin-top:0; font-size:20px;">Your Discovery Session is Confirmed, ' . htmlspecialchars($name) . '!</h2>
<p style="color:#191512; font-size:15px; line-height:1.6;">
  Thank you for scheduling your 30-minute strategy session. We are looking forward to reviewing <strong>' . htmlspecialchars($website) . '</strong> and showing you exactly how to double your direct online bookings.
</p>

<div style="background:#FAF8F5; border:1px solid #E5DDD0; border-radius:8px; padding:20px; margin:20px 0;">
  <div style="font-size:16px; font-weight:700; color:#191512;">📅 ' . htmlspecialchars($callDate) . ' at ' . htmlspecialchars($callTime) . '</div>
  <div style="font-size:13px; color:#8E7350; margin-top:5px;">Google Meet Private Video Link will arrive in your calendar invitation</div>
</div>

<h4 style="color:#191512; margin-bottom:10px;">What to Expect on Our Call:</h4>
<ul style="color:#5E564F; padding-left:20px; margin:0; font-size:14px; line-height:1.7;">
  <li><strong>Live Mobile Speed &amp; UX Audit:</strong> We inspect your live booking flow on phone screens</li>
  <li><strong>' . htmlspecialchars($software) . ' Deep-Link Strategy:</strong> How to eliminate 3 redundant booking steps</li>
  <li><strong>Custom Scope &amp; Roadmap:</strong> Transparent options tailored to your revenue goals</li>
  <li><strong>Zero Sales Pressure:</strong> Helpful advice from Principal Director Elijah Vance</li>
</ul>

<p style="color:#8F857B; font-size:13px; margin-top:25px;">
  If you need to reschedule or have any questions beforehand, simply reply directly to this email.
</p>
';

Mailer::send($email, $clientSubject, Mailer::getEmailTemplate('Your Discovery Session Confirmation', $clientHtml));

// 9. Response
if ($isAjax) {
    Security::jsonResponse(true, 'Your 30-minute discovery call is confirmed for ' . $callDate . ' at ' . $callTime . '! Check your email for details.');
} else {
    $_SESSION['flash_success'] = 'Your discovery call is confirmed for ' . $callDate . ' at ' . $callTime . '! We have sent confirmation details to ' . $email . '.';
    header('Location: ../book-a-call.php?status=success');
    exit;
}
