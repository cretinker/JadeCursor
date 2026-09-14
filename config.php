<?php
/**
 * Spa Design Hub - Production Configuration
 * Elite Web Design Studio & Conversion Engine for Luxury Spas & MedSpas
 */

if (!defined('JADE_APP')) {
    define('JADE_APP', true);
}

define('APP_ENV', 'production');

// Site Info
define('SITE_NAME', 'Spa Design Hub');
define('SITE_TAGLINE', 'Luxury Spa Web Design Studio');
define('SITE_URL', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost'));
define('SITE_DOMAIN', $_SERVER['HTTP_HOST'] ?? 'spadesignhub.com');

// Contact & Notification Emails
define('ADMIN_EMAIL', 'hello@spadesignhub.com');
define('MAIL_FROM_NAME', 'Spa Design Hub Agency');
define('MAIL_FROM_EMAIL', 'noreply@' . (strpos(SITE_DOMAIN, 'localhost') === false ? SITE_DOMAIN : 'spadesignhub.com'));

// Security & Anti-Spam Parameters
define('CSRF_SECRET', 'spadesignhub_salt_73e2a910bf4c8d55');
define('RATE_LIMIT_MAX_ATTEMPTS', 5);
define('RATE_LIMIT_WINDOW_SECONDS', 600);
define('MIN_SUBMISSION_TIME_SECONDS', 2);

// Paths
define('STORAGE_PATH', __DIR__ . '/storage');
define('LEADS_FILE_PATH', STORAGE_PATH . '/leads.json');
define('RATE_LIMIT_PATH', STORAGE_PATH . '/ratelimit');

// Ensure storage directories exist silently
if (!is_dir(STORAGE_PATH)) {
    @mkdir(STORAGE_PATH, 0755, true);
}
if (!is_dir(RATE_LIMIT_PATH)) {
    @mkdir(RATE_LIMIT_PATH, 0755, true);
}
