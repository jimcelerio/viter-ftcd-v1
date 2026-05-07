<?php

// for local computer configuration
define('WEB_API_KEY', require __DIR__ . "/../../../apikey.php");
// for production/deployment configuration
// define('WEB_API_KEY', require $_SERVER['DOCUMENT_ROOT'] . "/../../api_key.php");

// for set email
define('FROM', 'HRIS');
define('VERIFY_ACCOUNT', 'Account Verification');
define('RESET_PASSWORD', 'Password Reset');
define('VERIFY_EMAIL', 'Email Verification');
// email account
// define('USERNAME', 'noreply@groupoptix.com');
// define('PASSWORD', "1s$42*Gs1CvBezsI");
// define('HOST', 'smtp.hostinger.com');
// define('PORT', 587);
// define('SMTPSECURE', 'tls');

// // GROUP OPTIX HOSTINGER EMAIL
define("USERNAME", "noreply@groupoptix.com");
define("PASSWORD", "1s$42*Gs1CvbEzsI");
// // GROUP OPTIX HOSTINGER
define("HOST", "smtp.hostinger.com");
define("PORT", 587);
define("SMTPSECURE", "tls");

// ROOT DOMAIN
// local computer
define('ROOT_DOMAIN', 'http://localhost:5173');
define('IMAGES_URL', 'http://localhost:5173/img');
// PRODUCTION
// define('ROOT_DOMAIN', 'https://localhost/react-vite/viter-hris');
// define('IMAGES_URL', 'https://localhost/react-vite/viter-hris/img');