<?php

namespace src\controllers;

use core\Controller;
use src\handlers\LoginHandler;
use src\models\Post;

class PostController extends Controller
{
    private $loggedUser;

    public function __construct()
    {
        $this->loggedUser = LoginHandler::checkLoggedUser();

        if (!$this->loggedUser) {
            $this->redirect('/signin');
        }
    }

    /* public function index()
    {
    } */

    public function new()
    {
        $body = filter_input(INPUT_POST, 'body');

        if ($body) {
            try {
                Post::addPost($this->loggedUser->id, 'text', $body);
            } catch (\Throwable $th) {
                $_SESSION['flash'] = 'Falha ao Postar, Tente Novamente.';
            }
        }

        $this->redirect('/');
    }
}
