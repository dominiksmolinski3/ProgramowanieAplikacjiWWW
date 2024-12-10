<?php
// cfgsmtp.php
return [
    'smtp_host' => 'smtp.gmail.com',
    'smtp_auth' => true,
    'username' => getenv('SMTP_USER'),
    'password' => getenv('SMTP_PASS'), // Use app password if 2FA is enabled
    'smtp_secure' => 'ssl', // Can also be 'tls' depending on the server
    'smtp_port' => 465,     // Use 587 for TLS
    'admin_login' => getenv('adminlogin'),
    'admin_password' => getenv('adminpass'),
];
