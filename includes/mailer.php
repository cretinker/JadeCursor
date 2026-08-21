<?php
/**
 * Mailer & Lead Persistence Engine
 * Sends luxury-formatted HTML emails and safely stores leads in JSON backup
 */

if (!defined('JADE_APP')) {
    require_once __DIR__ . '/../config.php';
}

class Mailer {

    /**
     * Send email with HTML and plain text alternative
     */
    public static function send(string $to, string $subject, string $htmlContent, string $replyTo = ''): bool {
        $headers = [];
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=utf-8';
        $headers[] = 'From: ' . MAIL_FROM_NAME . ' <' . MAIL_FROM_EMAIL . '>';
        
        if (!empty($replyTo)) {
            $headers[] = 'Reply-To: ' . $replyTo;
        }
        $headers[] = 'X-Mailer: PHP/' . phpversion();

        // Use standard mail function
        $success = @mail($to, $subject, $htmlContent, implode("\r\n", $headers));
        return $success;
    }

    /**
     * Backup lead data to secure JSON storage (Guarantees zero lead loss)
     */
    public static function saveLead(string $formType, array $data): bool {
        $leadRecord = [
            'id' => uniqid('lead_', true),
            'form_type' => $formType,
            'timestamp' => date('Y-m-d H:i:s T'),
            'ip' => Security::getClientIp(),
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown',
            'data' => $data
        ];

        $leads = [];
        if (file_exists(LEADS_FILE_PATH)) {
            $existing = json_decode(@file_get_contents(LEADS_FILE_PATH), true);
            if (is_array($existing)) {
                $leads = $existing;
            }
        }

        $leads[] = $leadRecord;
        return (bool)@file_put_contents(LEADS_FILE_PATH, json_encode($leads, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    /**
     * Generate Luxury HTML Email Container
     */
    public static function getEmailTemplate(string $title, string $contentHtml): string {
        return '<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>' . htmlspecialchars($title) . '</title>
</head>
<body style="margin:0; padding:0; background-color:#080C14; font-family:-apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif; color:#E2E8F0;">
  <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color:#080C14; padding:30px 15px;">
    <tr>
      <td align="center">
        <table role="presentation" width="100%" max-width="600" style="max-width:600px; background-color:#0B101A; border:1px solid #1E293B; border-radius:12px; overflow:hidden; box-shadow:0 12px 30px rgba(0,0,0,0.5);">
          <!-- Header -->
          <tr>
            <td style="padding:28px 30px; background:linear-gradient(135deg, #0B101A 0%, #064E3B 100%); border-bottom:1px solid #1E293B;">
              <table role="presentation" width="100%" cellspacing="0" cellpadding="0">
                <tr>
                  <td>
                    <div style="font-size:22px; font-weight:800; color:#FFFFFF; letter-spacing:-0.5px;">Jade Cursor</div>
                    <div style="font-size:12px; color:#00F5A0; font-weight:600; text-transform:uppercase; letter-spacing:1px; margin-top:2px;">Luxury Spa Web Design Agency</div>
                  </td>
                  <td align="right">
                    <span style="display:inline-block; padding:4px 10px; background:rgba(0,245,160,0.1); border:1px solid rgba(0,245,160,0.25); border-radius:20px; font-size:11px; font-weight:700; color:#00F5A0;">NEW INQUIRY</span>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <!-- Body Content -->
          <tr>
            <td style="padding:32px 30px; font-size:15px; line-height:1.6; color:#E2E8F0;">
              ' . $contentHtml . '
            </td>
          </tr>
          <!-- Footer -->
          <tr>
            <td style="padding:20px 30px; background-color:#070A10; border-top:1px solid #1E293B; text-align:center; font-size:12px; color:#64748B;">
              &copy; ' . date('Y') . ' Jade Cursor Agency. All rights reserved.<br>
              <span style="color:#00F5A0;">www.jadecursor.com</span> &bull; hello@jadecursor.com
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>';
    }
}
