<?php

namespace src\controllers;

use core\Controller;
use src\handlers\LoginHandler;
use src\handlers\ValidatorsHandler;
use src\models\Post;
use src\models\User;

class ProfileController extends Controller
{
    private $loggedUser;

    public function __construct()
    {
        $this->loggedUser = LoginHandler::checkLoggedUser();

        if (!$this->loggedUser) {
            $this->redirect('/signin');
        }
    }

    public function index($attrs = [])
    {
        $page = 0;
        if (isset($_GET['p'])) {
            $page =
                intval(filter_input(INPUT_GET, 'p', FILTER_VALIDATE_INT)) - 1;
        }

        // Detectando o usuário acessado
        $id = $this->loggedUser->id;
        if (!empty($attrs['id'])) {
            $id = $attrs['id'];
        }

        // Pegando informações do usuário
        $user = User::getUser($id, true);
        if (!$user) {
            $this->redirect('/');
        }

        // Calculando idade do usuário
        $dateFrom = new \DateTime($user->birthdate);
        $dateTo = new \DateTime('today');
        $user->age = $dateFrom->diff($dateTo)->y;

        // Pegando o feed do usuário
        $feed = Post::getUserFeed($id, $page, $this->loggedUser->id);

        // Verificar se EU sigo o usuário
        $isFollowing = false;
        if ($user->id !== $this->loggedUser->id) {
            $isFollowing = User::isFollowing($this->loggedUser->id, $user->id);
        }

        $this->render('profile', [
            'loggedUser' => $this->loggedUser,
            'user' => $user,
            'feed' => $feed,
            'page' => $page,
            'isFollowing' => $isFollowing,
        ]);
    }

    public function follow($attrs)
    {
        $to = intval($attrs['id']);

        try {
            if (!User::idExists($to)) {
                http_response_code(400);
                echo json_encode([
                    "error" => "Usuário Não Encontrado!",
                ]);
                exit();
            }

            if (User::isFollowing($this->loggedUser->id, $to)) {
                $followersCount = User::unfollow($this->loggedUser->id, $to);
                echo json_encode([
                    "btn" => "Seguir",
                    "flwCnt" => $followersCount,
                ]);
                exit();
            } else {
                $followersCount = User::follow($this->loggedUser->id, $to);
                echo json_encode([
                    "btn" => "Deixar de Seguir",
                    "flwCnt" => $followersCount,
                ]);
                exit();
            }
        } catch (\Throwable $th) {
            http_response_code(500);
            echo json_encode([
                "error" =>
                    "Erro interno do servidor. Tente novamente ou contate o suporte.",
            ]);
            exit();
        }
    }

    public function friends($attrs = [])
    {
        // Detectando o usuário acessado
        $id = $this->loggedUser->id;
        if (!empty($attrs['id'])) {
            $id = $attrs['id'];
        }

        // Detectando o usuário acessado
        $id = $this->loggedUser->id;
        if (!empty($attrs['id'])) {
            $id = $attrs['id'];
        }

        // Pegando informações do usuário
        $user = User::getUser($id, true);
        if (!$user) {
            $this->redirect('/');
        }

        // Verificar se EU sigo o usuário
        $isFollowing = false;
        if ($user->id !== $this->loggedUser->id) {
            $isFollowing = User::isFollowing($this->loggedUser->id, $user->id);
        }

        $this->render('profile_friends', [
            'loggedUser' => $this->loggedUser,
            'user' => $user,
            'isFollowing' => $isFollowing,
        ]);
    }

    public function pictures($attrs = [])
    {
        // Detectando o usuário acessado
        $id = $this->loggedUser->id;
        if (!empty($attrs['id'])) {
            $id = $attrs['id'];
        }

        // Detectando o usuário acessado
        $id = $this->loggedUser->id;
        if (!empty($attrs['id'])) {
            $id = $attrs['id'];
        }

        // Pegando informações do usuário
        $user = User::getUser($id, true);
        if (!$user) {
            $this->redirect('/');
        }

        // Verificar se EU sigo o usuário
        $isFollowing = false;
        if ($user->id !== $this->loggedUser->id) {
            $isFollowing = User::isFollowing($this->loggedUser->id, $user->id);
        }

        $this->render('profile_pictures', [
            'loggedUser' => $this->loggedUser,
            'user' => $user,
            'isFollowing' => $isFollowing,
        ]);
    }

    public function settings()
    {
        $this->render('settings', [
            'loggedUser' => $this->loggedUser,
        ]);
    }

    public function updateProfile()
    {
        $data = json_decode(file_get_contents('php://input'));

        $name = filter_var($data->name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $birthdate = filter_var($data->birthdate, FILTER_SANITIZE_STRING);
        $email = filter_var($data->email, FILTER_VALIDATE_EMAIL);
        $city = filter_var($data->city, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $work = filter_var($data->work, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_var($data->password, FILTER_SANITIZE_STRING);
        $confPassword = filter_var($data->confPassword, FILTER_SANITIZE_STRING);

        // Verificando campos obrigatórios
        if (!$name || !$email || !$birthdate) {
            http_response_code(400);
            echo json_encode([
                "error" =>
                    "Verifique se preencheu corretamente os campos obrigatórios.",
            ]);
            exit();
        }

        // Validando campo birthdate
        $birthdate = ValidatorsHandler::birthdateValidator($birthdate);
        if (!$birthdate) {
            http_response_code(400);
            echo json_encode(["error" => "Data informada é inválida."]);
            exit();
        }

        // Verificando se as senhas correspondem
        if ($password !== $confPassword) {
            http_response_code(400);
            echo json_encode(["error" => "Senhas não correspondem."]);
            exit();
        }

        try {
            // Verificando duplicidade
            if (
                User::emailExists($email) &&
                $email !== $this->loggedUser->email
            ) {
                http_response_code(400);
                echo json_encode([
                    "error" => "E-mail informado já está cadastrado.",
                ]);
                exit();
            }

            // Atualizando dados do usuário
            User::updateUser(
                $this->loggedUser->id,
                $name,
                $birthdate,
                $email,
                $city,
                $work,
                $password,
            );
            echo json_encode([
                "msg" => "Dados atualizados com sucesso!",
            ]);
            exit();
        } catch (\Throwable $th) {
            http_response_code(500);
            echo json_encode([
                "error" =>
                    "Erro interno do servidor. Tente novamente ou contate o suporte.",
            ]);
            exit();
        }
    }
}
