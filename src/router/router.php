<?php

use CoffeeCode\Router\Router;

$router = new Router(BASE_URL);

$router->namespace('\App\Controllers');

$router->get('/', 'UsersController:index');

$router->get('/login', 'AuthController:index');
$router->post('/login', 'AuthController:auth');

$router->get('/logout', 'LogOutController:index');

$router->get('/register', 'RegistrationController:index');
$router->post('/register', 'RegistrationController:store');

$router->get('/recover_password', 'RecoverPasswordController:index');
$router->post('/recover_password', 'RecoverPasswordController:sendRecoveryToken');

$router->get('/reset_password', 'ResetPasswordController:index');
$router->post('/reset_password', 'ResetPasswordController:reset');

$router->get('/verify_email', 'VerifyEmailController:index');

$router->get('/send_verification_email', 'SendEmailVerificationController:index');

$router->dispatch();

if ($router->error()) {
  $router->redirect('/login');
}
