<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Admin Security Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration options for admin panel security
    |
    */

    // IP Whitelist untuk akses admin (kosongkan untuk allow all)
    'admin_ip_whitelist' => [
        // '127.0.0.1',
        // '192.168.1.0/24',
    ],

    // Rate Limiting
    'rate_limits' => [
        'admin_panel' => 30, // Reduced to 30 requests per minute
        'login_attempts_per_ip' => 3, // Reduced to 3 per hour
        'login_attempts_per_email' => 2, // Reduced to 2 per hour
        'api_requests' => 100, // General API rate limit
    ],

    // Session Security
    'session' => [
        'regenerate_interval' => 900, // 15 minutes (more frequent)
        'timeout' => 3600, // 1 hour (reduced from 2 hours)
        'allow_concurrent' => false,
        'force_https' => true,
    ],

    // Password Policy - Diperkuat
    'password_policy' => [
        'min_length' => 14, // Increased from 12
        'require_uppercase' => true,
        'require_lowercase' => true,
        'require_numbers' => true,
        'require_special_chars' => true,
        'max_age_days' => 60, // Reduced from 90
        'prevent_reuse_count' => 8, // Increased from 5
        'require_different_from_username' => true,
    ],

    // Account Lockout - Diperkuat
    'lockout' => [
        'max_attempts' => 3, // Reduced from 5
        'lockout_duration' => 120, // Increased to 2 hours
        'progressive_delay' => true,
        'permanent_lockout_after' => 10, // Permanent lockout after 10 failed attempts
    ],

    // Security Headers - Diperkuat
    'headers' => [
        'x_frame_options' => 'DENY',
        'x_content_type_options' => 'nosniff',
        'x_xss_protection' => '1; mode=block',
        'referrer_policy' => 'strict-origin-when-cross-origin',
        'content_security_policy' => "default-src 'self'; script-src 'self' 'strict-dynamic'; style-src 'self' 'unsafe-inline'; img-src 'self' data: https:; font-src 'self' https:; connect-src 'self'; form-action 'self'; frame-ancestors 'none'; base-uri 'self'; object-src 'none';",
        'strict_transport_security' => 'max-age=63072000; includeSubDomains; preload',
        'permissions_policy' => 'camera=(), microphone=(), geolocation=(), usb=(), magnetometer=(), accelerometer=(), gyroscope=()',
    ],

    // Monitoring & Logging - Diperluas
    'monitoring' => [
        'log_failed_logins' => true,
        'log_successful_logins' => true,
        'log_admin_actions' => true,
        'log_permission_denials' => true,
        'alert_on_suspicious_activity' => true,
        'log_file_uploads' => true,
        'log_database_queries' => false, // Set true untuk debug mode
        'log_api_requests' => true,
    ],

    // Two-Factor Authentication
    '2fa' => [
        'enabled' => false, // Set true untuk aktivasi
        'required_for_superadmin' => true,
        'backup_codes_count' => 10,
        'totp_window' => 30,
    ],

    // File Upload Security
    'file_upload' => [
        'max_size' => 10485760, // 10MB
        'allowed_extensions' => ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf', 'doc', 'docx'],
        'scan_for_malware' => true,
        'quarantine_suspicious' => true,
    ],

    // Database Security
    'database' => [
        'enable_query_log' => false, // Hanya untuk debugging
        'log_slow_queries' => true,
        'slow_query_threshold' => 2000, // milliseconds
    ],

    // Suspicious Activity Patterns
    'suspicious_patterns' => [
        'sql_injection' => ['sql', 'union', 'select', 'drop', 'insert', 'update', 'delete'],
        'xss' => ['script', 'javascript', 'vbscript', 'onload', 'onerror'],
        'path_traversal' => ['../', '..\\', '/etc/passwd', '/etc/shadow'],
        'command_injection' => ['exec', 'system', 'shell_exec', 'passthru'],
    ],
];
