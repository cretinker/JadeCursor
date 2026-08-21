<?php
/**
 * CSRF Protection Helper
 * Generates and validates cryptographic anti-forgery tokens
 */

if (!defined('JADE_APP')) {
    require_once __DIR__ . '/../config.php';
}

class CSRF {
    /**
     * Generate a new CSRF token and store it in session
     */
    public static function generateToken(): string {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
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
        if (empty($_SESSION['csrf_token']) || empty($token)) {
            return false;
        }
        return hash_equals($_SESSION['csrf_token'], $token);
    }
}
