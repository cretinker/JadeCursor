<?php
/**
 * CSRF Protection Helper
 * Generates and validates cryptographic anti-forgery tokens without holding session locks
 */

if (!defined('JADE_APP')) {
    require_once __DIR__ . '/../config.php';
}

class CSRF {
    /**
     * Start session safely and return session data without permanent lock
     */
    private static function startSession(): void {
        if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
            @ini_set('session.cookie_httponly', '1');
            @ini_set('session.use_only_cookies', '1');
            @session_start();
        }
    }

    /**
     * Generate a new CSRF token and store it in session
     */
    public static function generateToken(): string {
        self::startSession();
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        $token = $_SESSION['csrf_token'];
        // Release session lock immediately so parallel page assets load with zero delay
        @session_write_close();
        return $token;
    }

    /**
     * Get hidden input HTML for forms
     */
    public static function getInputField(): string {
        $token = self::generateToken();
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
    }

    /**
     * Validate an incoming CSRF token
     */
    public static function validateToken(?string $token): bool {
        self::startSession();
        if (empty($_SESSION['csrf_token']) || empty($token)) {
            @session_write_close();
            return false;
        }
        $isValid = hash_equals($_SESSION['csrf_token'], $token);
        @session_write_close();
        return $isValid;
    }
}
