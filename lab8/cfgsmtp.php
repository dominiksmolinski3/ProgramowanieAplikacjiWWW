<?php
// cfgsmtp.php
return [
    'smtp_host' => 'smtp.gmail.com',
    'smtp_auth' => true,
    'smtp_username' => 'your_email@gmail.com',
    'smtp_password' => 'your_app_password', // Use app password if 2FA is enabled
    'smtp_secure' => 'ssl', // Can also be 'tls' depending on the server
    'smtp_port' => 465,     // Use 587 for TLS
];
