<?php
session_start();

define('BASE_URL', 'http://localhost:8080/');

define('PASSWORD_HASH', PASSWORD_BCRYPT);

define('MONGODB_URI', 'mongodb://php:phppass@php_login_db:27017/php_login');
define('DB_NAME', 'php_login');

define('MAIL_NAME', 'Your Name');
define('MAIL_EMAIL_ADDRESS', 'youremail@someprovider.com');
define('MAIL_HOST', '');
define('MAIL_PORT', '');
define('MAIL_USERNAME', '');
define('MAIL_PASSWORD', '');
