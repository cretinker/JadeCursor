# Jade Cursor — Production Hosting & Deployment Guide

This guide details how to host and deploy the Jade Cursor website across various hosting environments with maximum security and sub-second performance.

---

## 📁 Project Architecture Overview

```
JadeCursor/
├── config.php                 # Global configuration (admin email, security secrets, environment)
├── .htaccess                  # Apache/LiteSpeed security headers, SSL force, compression & caching
├── robots.txt                 # Search engine directives
├── sitemap.xml                # SEO XML sitemap
├── DEPLOYMENT.md              # Deployment guide
│
├── includes/                  # Reusable PHP modules
│   ├── header.php             # Luxury glassmorphism navbar (About after Home)
│   ├── footer.php             # Global footer & mobile sticky CTA
│   ├── csrf.php               # Anti-forgery token generator & validator
│   ├── security.php           # Sanitizer, honeypot check, time-trap & rate limiter
│   └── mailer.php             # HTML email builder & lead JSON persistence
│
├── api/                       # Secure form processing endpoints
│   ├── contact.php            # Contact inquiry handler
│   ├── booking.php            # 30-min discovery session booking handler
│   └── audit.php              # 5-min video audit request handler
│
├── storage/                   # Protected data storage (auto-secured by storage/.htaccess)
│   ├── leads.json             # 0% lead loss JSON backup of all submissions
│   └── ratelimit/             # File-based IP rate limit hashes
│
├── css/
│   └── styles.css             # High-end bespoke design system
│
├── js/
│   ├── app.js                 # AJAX form engine, toast alerts, mobile nav, ROI calculator
│   └── booking.js             # Interactive calendar, timeslot selector & timezone detector
│
├── index.php / index.html     # Homepage
├── about.php / about.html     # About Us & Leadership
├── services.php / services.html # Services & Subscription Pricing
├── portfolio.php / portfolio.html # Case Studies & Verified Results
├── process.php / process.html # How We Work & Turnkey Delivery
├── audit.php / audit.html     # Free 5-Min Video Audit
├── contact.php / contact.html # Contact Inquiries
├── book-a-call.php / book-a-call.html # 30-Min Discovery Session Booking
└── 404.php / 404.html         # Custom Luxury 404 Error Page
```

---

## 🚀 Option 1: Standard cPanel / Shared Hosting (Hostinger, SiteGround, Bluehost, Namecheap)

1. **Upload Files**:
   - Log into your hosting cPanel or File Manager.
   - Navigate to `public_html/`.
   - Upload all files and folders in this repository directly into `public_html/`.
2. **Configure Email**:
   - Open `config.php` and set your desired admin notification email:
     ```php
     define('ADMIN_EMAIL', 'your-email@yourdomain.com');
     ```
3. **Permissions**:
   - Ensure the `storage/` directory has write permissions (`0750` or `0775`).
4. **SSL / HTTPS**:
   - Ensure a free Let's Encrypt SSL certificate is activated in your hosting control panel. The included `.htaccess` will automatically force HTTPS traffic.

---

## ⚡ Option 2: Nginx Web Server (LEMP Stack, Cloudways, DigitalOcean, VPS)

If you are running an **Nginx** server instead of Apache, add the following server block directives:

```nginx
server {
    listen 80;
    server_name jadecursor.com www.jadecursor.com;
    return 301 https://$host$request_uri;
}

server {
    listen 443 ssl http2;
    server_name jadecursor.com www.jadecursor.com;
    root /var/www/jadecursor;
    index index.php index.html;

    # SSL Certificates
    ssl_certificate /etc/letsencrypt/live/jadecursor.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/jadecursor.com/privkey.pem;

    # Security Headers
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "strict-origin-when-cross-origin" always;
    add_header Strict-Transport-Security "max-age=31536000; includeSubDomains; preload" always;

    # Deny access to sensitive files and directories
    location ~ ^/(storage|includes|config\.php|\.git|\.env) {
        deny all;
        return 404;
    }

    # Clean URLs
    location / {
        try_files $uri $uri/ $uri.php $uri.html?$query_string;
    }

    # PHP-FPM Handler
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
    }

    # Gzip Compression & Static Asset Caching
    location ~* \.(css|js|jpg|jpeg|png|webp|svg|woff2)$ {
        expires 1y;
        add_header Cache-Control "public, no-transform";
    }

    error_page 404 /404.php;
}
```

---

## 🌐 Option 3: Static Jamstack Hosting (Netlify, Vercel, Cloudflare Pages)

The website maintains full `.html` equivalents alongside `.php`:
- The client-side JavaScript (`js/app.js` and `js/booking.js`) operates autonomously.
- If deployed without a PHP backend, the forms feature automatic graceful fallback handling with instant user confirmation.
- You can also connect the forms to Formspree, Basin, or Make.com by modifying the form `action=""` URL in `js/app.js`.

---

## 🛡️ Built-in Security Features

1. **CSRF Protection**: Cryptographically secure anti-forgery tokens on all forms (`includes/csrf.php`).
2. **Honeypot Anti-Spam Trap**: Silent hidden input trap that instantly traps automated spambots.
3. **Time-Trap Validation**: Submissions completed under 2 seconds are blocked as automated scripts.
4. **Rate Limiting**: Automatic IP rate limiter preventing brute-force form floods (max 5 submits per 10 minutes).
5. **Zero-Loss Lead Backup**: Every submission is written to `storage/leads.json` in addition to sending HTML notification emails.
6. **Hardened HTTP Headers**: Comprehensive Content Security Policy, HSTS, X-Frame-Options, and MIME sniff prevention.
