<?php
/**
 * Jade Cursor - Production Configuration
 * Luxury Spa Web Design Agency
 */

// Prevent direct access
if (!defined('JADE_APP')) {
    define('JADE_APP', true);
}

// Environment: 'development' or 'production'
define('APP_ENV', 'production');

// Site Info
define('SITE_NAME', 'Jade Cursor');
define('SITE_TAGLINE', 'Spa Web Studio');
define('SITE_URL', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost'));
define('SITE_DOMAIN', $_SERVER['HTTP_HOST'] ?? 'jadecursor.com');

// Contact & Notification Emails
define('ADMIN_EMAIL', 'hello@jadecursor.com');
define('MAIL_FROM_NAME', 'Jade Cursor Agency');
define('MAIL_FROM_EMAIL', 'noreply@' . (strpos(SITE_DOMAIN, 'localhost') === false ? SITE_DOMAIN : 'jadecursor.com'));

// Security & Anti-Spam Parameters
define('CSRF_SECRET', 'jade_cursor_salt_98f4c2e17a3b8d60'); // Custom unique secret salt
define('RATE_LIMIT_MAX_ATTEMPTS', 5);                      // Max submissions per IP
define('RATE_LIMIT_WINDOW_SECONDS', 600);                  // 10-minute window
define('MIN_SUBMISSION_TIME_SECONDS', 2);                  // Submissions under 2 seconds rejected as bots

// Paths
define('STORAGE_PATH', __DIR__ . '/storage');
define('LEADS_FILE_PATH', STORAGE_PATH . '/leads.json');
define('RATE_LIMIT_PATH', STORAGE_PATH . '/ratelimit');

// Ensure storage directories exist
if (!is_dir(STORAGE_PATH)) {
    @mkdir(STORAGE_PATH, 0750, true);
}
if (!is_dir(RATE_LIMIT_PATH)) {
    @mkdir(RATE_LIMIT_PATH, 0750, true);
}

// Session Initialization for CSRF
if (session_status() === PHP_SESSION_NONE) {
    // Secure session cookies
    ini_set('session.cookie_httponly', '1');
    ini_set('session.use_only_cookies', '1');
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        ini_set('session.cookie_secure', '1');
    }
    session_start();
}
