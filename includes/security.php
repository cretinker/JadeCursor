<?php
/**
 * Security & Anti-Spam Helper Suite
 * Handles input sanitization, rate limiting, honeypot traps, and security headers
 */

if (!defined('JADE_APP')) {
    require_once __DIR__ . '/../config.php';
}

class Security {
    /**
     * Send Hardened Production Security Headers
     */
    public static function sendSecurityHeaders(): void {
        if (headers_sent()) return;

        header("X-Content-Type-Options: nosniff");
        header("X-Frame-Options: SAMEORIGIN");
        header("X-XSS-Protection: 1; mode=block");
        header("Referrer-Policy: strict-origin-when-cross-origin");
        header("Permissions-Policy: camera=(), microphone=(), geolocation=()");
        
        // HSTS (HTTP Strict Transport Security)
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
        }
    }

    /**
     * Sanitize general text string
     */
    public static function cleanString(?string $data, int $maxLength = 1000): string {
        if ($data === null) return '';
        $data = trim($data);
        $data = strip_tags($data);
        $data = mb_substr($data, 0, $maxLength, 'UTF-8');
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Sanitize and validate email address
     */
    public static function cleanEmail(?string $email): ?string {
        if ($email === null) return null;
        $email = trim(filter_var($email, FILTER_SANITIZE_EMAIL));
        if (filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($email) <= 120) {
            return strtolower($email);
        }
        return null;
    }

    /**
     * Sanitize and validate website URL
     */
    public static function cleanUrl(?string $url): string {
        if ($url === null) return '';
        $url = trim($url);
        if (empty($url)) return '';
        
        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = "https://" . $url;
        }
        
        $url = filter_var($url, FILTER_SANITIZE_URL);
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            return htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
        }
        return '';
    }

    /**
     * Sanitize phone number
     */
    public static function cleanPhone(?string $phone): string {
        if ($phone === null) return '';
        $phone = trim($phone);
        // Allow digits, spaces, hyphens, plus, parentheses
        return preg_replace('/[^\d\+\-\(\)\s]/', '', mb_substr($phone, 0, 30, 'UTF-8'));
    }

    /**
     * Verify Honeypot (bot trap field)
     * If the hidden field is filled, it is a bot submission
     */
    public static function checkHoneypot(array $postData, string $fieldName = '_website_url_hp'): bool {
        if (!empty($postData[$fieldName])) {
            return false; // Bot caught
        }
        return true;
    }

    /**
     * Verify Time Trap
     * Real humans take at least 2-3 seconds to complete the form
     */
    public static function checkTimeTrap(array $postData, string $timestampField = '_form_timestamp'): bool {
        if (empty($postData[$timestampField])) {
            return true; // Pass if field missing in non-JS environment
        }
        $timestamp = (int)$postData[$timestampField];
        $currentTime = time();
        
        // If submitted faster than MIN_SUBMISSION_TIME_SECONDS, it's automated bot
        if (($currentTime - $timestamp) < MIN_SUBMISSION_TIME_SECONDS) {
            return false;
        }
        // If submitted more than 4 hours later, token expired
        if (($currentTime - $timestamp) > 14400) {
            return false;
        }
        return true;
    }

    /**
     * Client IP retrieval with proxy handling
     */
    public static function getClientIp(): string {
        if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
            $ip = $_SERVER['HTTP_CF_CONNECTING_IP']; // Cloudflare
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $ip = trim($ips[0]);
        } else {
            $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        }
        return filter_var($ip, FILTER_VALIDATE_IP) ? $ip : '127.0.0.1';
    }

    /**
     * File-based IP Rate Limiting
     */
    public static function checkRateLimit(): bool {
        $ip = self::getClientIp();
        $ipHash = md5($ip . CSRF_SECRET);
        $rateFile = RATE_LIMIT_PATH . '/' . $ipHash . '.json';

        $currentTime = time();
        $attempts = [];

        if (file_exists($rateFile)) {
            $data = json_decode(@file_get_contents($rateFile), true);
            if (is_array($data)) {
                // Filter attempts within the active window
                $attempts = array_filter($data, function($timestamp) use ($currentTime) {
                    return ($currentTime - $timestamp) < RATE_LIMIT_WINDOW_SECONDS;
                });
            }
        }

        if (count($attempts) >= RATE_LIMIT_MAX_ATTEMPTS) {
            return false; // Rate limit exceeded
        }

        $attempts[] = $currentTime;
        @file_put_contents($rateFile, json_encode($attempts));
        return true;
    }

    /**
     * Send JSON Response and Terminate
     */
    public static function jsonResponse(bool $success, string $message, array $extra = [], int $statusCode = 200): void {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(array_merge([
            'success' => $success,
            'message' => $message
        ], $extra));
        exit;
    }
}
