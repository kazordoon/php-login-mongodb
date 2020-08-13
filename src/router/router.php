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

$router->get('/recover_password', 'RecoverPassword:index');
$router->post('/recover_password', 'RecoverPassword:sendRecoveryToken');

$router->dispatch();

if ($router->error()) {
  $router->redirect('/login');
}
