<?php
/**
 * Free Video Website Audit API Endpoint
 * Handles submissions from audit.html and audit.php
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
        Security::jsonResponse(false, 'Too many requests. Please wait a few minutes before trying again.', [], 429);
    } else {
        $_SESSION['flash_error'] = 'Too many requests. Please try again shortly.';
        header('Location: ../audit.php');
        exit;
    }
}

// 2. Honeypot Check
if (!Security::checkHoneypot($_POST)) {
    if ($isAjax) {
        Security::jsonResponse(true, 'Your video audit request has been received.');
    } else {
        header('Location: ../audit.php?status=success');
        exit;
    }
}

// 3. Time-Trap Check
if (!Security::checkTimeTrap($_POST)) {
    if ($isAjax) {
        Security::jsonResponse(false, 'Submission failed verification. Please try again.', [], 400);
    } else {
        $_SESSION['flash_error'] = 'Submission blocked. Please try again.';
        header('Location: ../audit.php');
        exit;
    }
}

// 4. CSRF Validation
if (!empty($_POST['csrf_token']) && !CSRF::validateToken($_POST['csrf_token'])) {
    if ($isAjax) {
        Security::jsonResponse(false, 'Security token expired. Please refresh the page and try again.', [], 403);
    } else {
        $_SESSION['flash_error'] = 'Security verification failed. Please refresh and try again.';
        header('Location: ../audit.php');
        exit;
    }
}

// 5. Input Sanitization & Validation
$name = Security::cleanString($_POST['name'] ?? '', 100);
$email = Security::cleanEmail($_POST['email'] ?? '');
$website = Security::cleanUrl($_POST['website'] ?? '');
$software = Security::cleanString($_POST['software'] ?? 'Boulevard', 60);
$notes = Security::cleanString($_POST['notes'] ?? '', 2000);

if (empty($name)) {
    $error = 'Please enter your full name.';
} elseif (!$email) {
    $error = 'Please provide a valid work email address.';
} elseif (empty($website)) {
    $error = 'Please provide your current spa website URL.';
} else {
    $error = null;
}

if ($error) {
    if ($isAjax) {
        Security::jsonResponse(false, $error, [], 400);
    } else {
        $_SESSION['flash_error'] = $error;
        header('Location: ../audit.php');
        exit;
    }
}

// 6. Lead Data Package
$leadData = [
    'name' => $name,
    'email' => $email,
    'website' => $website,
    'software' => $software,
    'notes' => $notes
];

// Save to backup file
Mailer::saveLead('free_audit_request', $leadData);

// 7. Compose & Send Internal Admin Notification Email
$adminSubject = "🔍 Free Video Audit Requested: {$name} ({$website})";
$adminHtml = '
<h2 style="color:#8E7350; margin-top:0; font-size:20px;">New Free Website Audit Request</h2>
<p style="color:#5E564F; font-size:14px;">A spa owner has requested a custom 5-minute video audit:</p>

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
    <td style="padding:10px 0; color:#5E564F;"><strong>Website to Audit:</strong></td>
    <td style="padding:10px 0; color:#8E7350;"><a href="' . htmlspecialchars($website) . '" target="_blank" style="color:#8E7350; font-weight:700;">' . htmlspecialchars($website) . '</a></td>
  </tr>
  <tr style="border-bottom:1px solid #E5DDD0;">
    <td style="padding:10px 0; color:#5E564F;"><strong>Booking System:</strong></td>
    <td style="padding:10px 0; color:#8E7350; font-weight:600;">' . htmlspecialchars($software) . '</td>
  </tr>
</table>

<div style="background:#FAF8F5; border-left:3px solid #8E7350; padding:15px; border-radius:4px; margin-top:15px;">
  <strong style="color:#191512; display:block; margin-bottom:5px;">Biggest Frustration / Notes:</strong>
  <p style="color:#332D27; margin:0; font-size:14px; white-space:pre-wrap;">' . ($notes ? nl2br(htmlspecialchars($notes)) : 'No specific frustration listed.') . '</p>
</div>
';

Mailer::send(ADMIN_EMAIL, $adminSubject, Mailer::getEmailTemplate('Free Video Audit Request', $adminHtml), $email);

// 8. Autoresponder to Client
$clientSubject = "Your Free 5-Minute Video Audit is Being Prepared — Spa Design Hub";
$clientHtml = '
<h2 style="color:#8E7350; margin-top:0; font-size:20px;">We are reviewing ' . htmlspecialchars($website) . ', ' . htmlspecialchars($name) . '.</h2>
<p style="color:#191512; font-size:15px; line-height:1.6;">
  Thank you for requesting your custom video audit. Our Principal Design Director, Elijah Adah, will record a candid, 5-minute video walkthrough of your live website.
</p>

<div style="background:#FAF8F5; border:1px solid #E5DDD0; border-radius:8px; padding:20px; margin:20px 0;">
  <h4 style="color:#191512; margin-top:0; margin-bottom:10px;">What We Will Cover in Your Video:</h4>
  <ul style="color:#5E564F; padding-left:20px; margin:0; font-size:14px; line-height:1.7;">
    <li><strong>Mobile Speed Test:</strong> Load time bottlenecks on 4G/5G connections</li>
    <li><strong>Booking Friction Points:</strong> Where guests get confused and drop off</li>
    <li><strong>' . htmlspecialchars($software) . ' Connection Check:</strong> How your booking link performs</li>
    <li><strong>Visual Luxury Score:</strong> Whether the site reflects your in-person ambiance</li>
  </ul>
</div>

<p style="color:#8F857B; font-size:13px; margin-top:25px;">
  You will receive your private Loom video link by email within 24 business hours. No spam, no sales calls.
</p>
';

Mailer::send($email, $clientSubject, Mailer::getEmailTemplate('Your Video Audit is on the Way', $clientHtml));

// 9. Response
if ($isAjax) {
    Security::jsonResponse(true, 'Thank you, ' . $name . '! Your video audit request has been received. Expect your custom 5-minute review in your inbox within 24 business hours.');
} else {
    $_SESSION['flash_success'] = 'Thank you, ' . $name . '! Your video audit request has been received. Look out for our email within 24 business hours.';
    header('Location: ../audit.php?status=success');
    exit;
}
