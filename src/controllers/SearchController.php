<?php
namespace src\controllers;

use core\Controller;
use src\handlers\LoginHandler;
use src\models\User;

class SearchController extends Controller
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
        $search = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_SPECIAL_CHARS);

        if (empty($search)) {
            $this->redirect('');
        }

        $users = User::searchUser($search);

        $this->render('search', [
            'loggedUser' => $this->loggedUser,
            'search' => $search,
            'users' => $users,
        ]);
    }
}
