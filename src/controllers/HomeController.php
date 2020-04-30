<?php

namespace src\controllers;

use core\Controller;
use src\handlers\LoginHandler;
use src\models\Post;

class HomeController extends Controller
{
    private $loggedUser;

    public function __construct()
    {
        $this->loggedUser = LoginHandler::checkLoggedUser();

        if (!$this->loggedUser) {
            $this->redirect('signin');
        }
    }

    public function index()
    {
        $page = 0;
        if (isset($_GET['p'])) {
            $page =
                intval(filter_input(INPUT_GET, 'p', FILTER_VALIDATE_INT)) - 1;
        }

        $feed = Post::getHomeFeed($this->loggedUser->id, $page);

        $this->render('home', [
            'loggedUser' => $this->loggedUser,
            'feed' => $feed,
            'page' => $page,
        ]);
    }
}
