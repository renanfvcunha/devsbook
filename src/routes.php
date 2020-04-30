<?php

use core\Router;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable('../');
$dotenv->load();

$router = new Router();

$router->get('/', 'HomeController@index');

$router->get('/signin', 'LoginController@SignInRequest');
$router->post('/signin', 'LoginController@SignInAction');

$router->get('/signup', 'LoginController@SignUpRequest');
$router->post('/signup', 'LoginController@SignUpAction');

$router->post('/post/new', 'PostController@new');

$router->get('/profile/settings', 'ProfileController@settings');
$router->get('/profile/{id}/pictures', 'ProfileController@pictures');
$router->get('/profile/{id}/friends', 'ProfileController@friends');
$router->get('/profile/{id}/follow', 'ProfileController@follow');
$router->get('/profile/{id}', 'ProfileController@index');
$router->get('/profile', 'ProfileController@index');
$router->put('/profile', 'ProfileController@updateProfile');

$router->get('/friends', 'ProfileController@friends');

$router->get('/pictures', 'ProfileController@pictures');

$router->get('/search', 'SearchController@index');

$router->get('/signout', 'LoginController@SignOut');
