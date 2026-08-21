<?php
/**
 * Contact Inquiry API Endpoint
 * Handles submissions from contact.html and contact.php
 */

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/security.php';
require_once __DIR__ . '/../includes/mailer.php';

Security::sendSecurityHeaders();

// Only allow POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Security::jsonResponse(false, 'Method not allowed. Only POST requests are accepted.', [], 405);
}

$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

// 1. Rate Limiting Check
if (!Security::checkRateLimit()) {
    if ($isAjax) {
        Security::jsonResponse(false, 'Too many requests. Please wait a few minutes before submitting again.', [], 429);
    } else {
        $_SESSION['flash_error'] = 'Too many requests. Please wait a few minutes before trying again.';
        header('Location: ../contact.php');
        exit;
    }
}

// 2. Honeypot Anti-Spam Check
if (!Security::checkHoneypot($_POST)) {
    // Fake success to fool spambots
    if ($isAjax) {
        Security::jsonResponse(true, 'Your inquiry has been received.');
    } else {
        header('Location: ../contact.php?status=success');
        exit;
    }
}

// 3. Time-Trap Anti-Spam Check
if (!Security::checkTimeTrap($_POST)) {
    if ($isAjax) {
        Security::jsonResponse(false, 'Form submitted too quickly. Please try again.', [], 400);
    } else {
        $_SESSION['flash_error'] = 'Form submission was blocked. Please try again.';
        header('Location: ../contact.php');
        exit;
    }
}

// 4. CSRF Validation (if provided)
if (!empty($_POST['csrf_token']) && !CSRF::validateToken($_POST['csrf_token'])) {
    if ($isAjax) {
        Security::jsonResponse(false, 'Security token expired. Please refresh the page and try again.', [], 403);
    } else {
        $_SESSION['flash_error'] = 'Security verification failed. Please refresh and try again.';
        header('Location: ../contact.php');
        exit;
    }
}

// 5. Input Sanitization & Validation
$name = Security::cleanString($_POST['name'] ?? '', 100);
$email = Security::cleanEmail($_POST['email'] ?? '');
$spaName = Security::cleanString($_POST['spa_name'] ?? '', 120);
$website = Security::cleanUrl($_POST['website'] ?? '');
$modality = Security::cleanString($_POST['modality'] ?? 'Day Spa & Massage', 80);
$tier = Security::cleanString($_POST['tier'] ?? 'Growth Plan ($395/mo)', 100);
$timeline = Security::cleanString($_POST['timeline'] ?? 'Next 3-5 Weeks', 60);
$message = Security::cleanString($_POST['message'] ?? '', 2000);

// Validation rules
if (empty($name)) {
    $error = 'Please enter your full name.';
} elseif (!$email) {
    $error = 'Please provide a valid work email address.';
} elseif (empty($spaName)) {
    $error = 'Please enter your spa or salon business name.';
} else {
    $error = null;
}

if ($error) {
    if ($isAjax) {
        Security::jsonResponse(false, $error, [], 400);
    } else {
        $_SESSION['flash_error'] = $error;
        header('Location: ../contact.php');
        exit;
    }
}

// 6. Lead Data Package
$leadData = [
    'name' => $name,
    'email' => $email,
    'spa_name' => $spaName,
    'website' => $website,
    'modality' => $modality,
    'tier' => $tier,
    'timeline' => $timeline,
    'message' => $message
];

// Save to backup file
Mailer::saveLead('contact_inquiry', $leadData);

// 7. Compose & Send Internal Notification Email
$adminSubject = "🌿 New Spa Inquiry: {$spaName} ({$name})";
$adminHtml = '
<h2 style="color:#00F5A0; margin-top:0; font-size:20px;">New Client Project Inquiry</h2>
<p style="color:#94A3B8; font-size:14px;">A new spa founder has requested a discovery consultation from the contact page:</p>

<table style="width:100%; border-collapse:collapse; margin:20px 0; font-size:14px;">
  <tr style="border-bottom:1px solid #1E293B;">
    <td style="padding:10px 0; color:#94A3B8; width:140px;"><strong>Founder Name:</strong></td>
    <td style="padding:10px 0; color:#FFFFFF; font-weight:600;">' . htmlspecialchars($name) . '</td>
  </tr>
  <tr style="border-bottom:1px solid #1E293B;">
    <td style="padding:10px 0; color:#94A3B8;"><strong>Work Email:</strong></td>
    <td style="padding:10px 0; color:#38BDF8;"><a href="mailto:' . htmlspecialchars($email) . '" style="color:#38BDF8; text-decoration:none;">' . htmlspecialchars($email) . '</a></td>
  </tr>
  <tr style="border-bottom:1px solid #1E293B;">
    <td style="padding:10px 0; color:#94A3B8;"><strong>Spa Business:</strong></td>
    <td style="padding:10px 0; color:#FFFFFF; font-weight:600;">' . htmlspecialchars($spaName) . '</td>
  </tr>
  <tr style="border-bottom:1px solid #1E293B;">
    <td style="padding:10px 0; color:#94A3B8;"><strong>Current Website:</strong></td>
    <td style="padding:10px 0; color:#38BDF8;">' . ($website ? '<a href="' . htmlspecialchars($website) . '" target="_blank" style="color:#38BDF8;">' . htmlspecialchars($website) . '</a>' : '<span style="color:#64748B;">None provided</span>') . '</td>
  </tr>
  <tr style="border-bottom:1px solid #1E293B;">
    <td style="padding:10px 0; color:#94A3B8;"><strong>Modality / Type:</strong></td>
    <td style="padding:10px 0; color:#00F5A0; font-weight:600;">' . htmlspecialchars($modality) . '</td>
  </tr>
  <tr style="border-bottom:1px solid #1E293B;">
    <td style="padding:10px 0; color:#94A3B8;"><strong>Plan of Interest:</strong></td>
    <td style="padding:10px 0; color:#FFFFFF; font-weight:600;">' . htmlspecialchars($tier) . '</td>
  </tr>
  <tr style="border-bottom:1px solid #1E293B;">
    <td style="padding:10px 0; color:#94A3B8;"><strong>Target Timeline:</strong></td>
    <td style="padding:10px 0; color:#F59E0B; font-weight:600;">' . htmlspecialchars($timeline) . '</td>
  </tr>
</table>

<div style="background:#0F172A; border-left:3px solid #00F5A0; padding:15px; border-radius:4px; margin-top:15px;">
  <strong style="color:#FFFFFF; display:block; margin-bottom:5px;">Project Goal / Message:</strong>
  <p style="color:#CBD5E1; margin:0; font-size:14px; white-space:pre-wrap;">' . ($message ? nl2br(htmlspecialchars($message)) : 'No additional notes provided.') . '</p>
</div>
';

Mailer::send(ADMIN_EMAIL, $adminSubject, Mailer::getEmailTemplate('New Spa Project Inquiry', $adminHtml), $email);

// 8. Autoresponder to Client
$clientSubject = "We received your inquiry — Jade Cursor";
$clientHtml = '
<h2 style="color:#00F5A0; margin-top:0; font-size:20px;">Thank you for connecting with Jade Cursor, ' . htmlspecialchars($name) . '.</h2>
<p style="color:#E2E8F0; font-size:15px; line-height:1.6;">
  We have received your project details for <strong>' . htmlspecialchars($spaName) . '</strong>. Our Principal Design Director, Elijah Vance, will review your current online presence and reach out within 24 business hours to schedule your 30-minute Discovery Session.
</p>
<div style="background:#0F172A; border:1px solid #1E293B; border-radius:8px; padding:20px; margin:20px 0;">
  <h4 style="color:#FFFFFF; margin-top:0; margin-bottom:10px;">What We Will Prepare for You:</h4>
  <ul style="color:#94A3B8; padding-left:20px; margin:0; font-size:14px; line-height:1.7;">
    <li>A live speed &amp; mobile checkout audit of your existing website</li>
    <li>A direct breakdown of how to deep-link treatments in your booking platform</li>
    <li>A clear, fixed-price roadmap tailored to ' . htmlspecialchars($tier) . '</li>
  </ul>
</div>
<p style="color:#64748B; font-size:13px; margin-top:25px;">
  Need immediate assistance? Feel free to reply directly to this email or book directly on our calendar.
</p>
';

Mailer::send($email, $clientSubject, Mailer::getEmailTemplate('Your Discovery Session Request', $clientHtml));

// 9. Response
if ($isAjax) {
    Security::jsonResponse(true, 'Thank you, ' . $name . '! Your inquiry has been received. Elijah will be in touch within 24 business hours.');
} else {
    $_SESSION['flash_success'] = 'Thank you, ' . $name . '! Your inquiry has been received. We will be in touch within 24 business hours.';
    header('Location: ../contact.php?status=success');
    exit;
}
