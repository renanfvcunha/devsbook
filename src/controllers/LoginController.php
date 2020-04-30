<?php

namespace src\controllers;

use core\Controller;
use src\handlers\LoginHandler;
use src\handlers\ValidatorsHandler;
use src\models\User;

/**
 * Classe que lida com autenticação e
 * cadastro de usuários
 */
class LoginController extends Controller
{
    private $loggedUser;

    /**
     * Renderização de tela para efetuar login
     */
    public function SignInRequest()
    {
        $this->loggedUser = LoginHandler::checkLoggedUser();

        if ($this->loggedUser) {
            $this->redirect('');
        }

        $this->render('signin');
    }

    /**
     * Efetuar Login
     */
    public function SignInAction()
    {
        $data = json_decode(file_get_contents('php://input'));

        $email = filter_var($data->email, FILTER_VALIDATE_EMAIL);
        $password = filter_var($data->password, FILTER_SANITIZE_STRING);

        // Validando inputs
        if (!$email || !$password) {
            http_response_code(400);
            echo json_encode([
                "error" =>
                    "Verifique se preencheu corretamente todos os campos.",
            ]);
            exit();
        }

        // Verificando dados para autenticação
        try {
            $token = LoginHandler::verifyLogin($email, $password);
            if (!$token) {
                http_response_code(401);
                echo json_encode([
                    "error" => "E-mail e/ou Senha Incorreto(s).",
                ]);
                exit();
            }

            // Autenticando usuário e atribuindo token
            $_SESSION['token'] = $token;
        } catch (\Throwable $th) {
            http_response_code(500);
            echo json_encode([
                "error" =>
                    "Erro interno do servidor. Tente novamente ou contate o suporte.",
            ]);
            $this->setErrorLog($th);
            exit();
        }
    }

    /**
     * Renderização de tela para
     * cadastro de novo usuário
     */
    public function SignUpRequest()
    {
        $this->loggedUser = LoginHandler::checkLoggedUser();

        if ($this->loggedUser) {
            $this->redirect('');
        }

        $this->render('signup');
    }

    /**
     * Cadastro de novo usuário
     */
    public function SignUpAction()
    {
        $data = json_decode(file_get_contents('php://input'));

        $name = filter_var($data->name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_var($data->email, FILTER_VALIDATE_EMAIL);
        $password = filter_var($data->password, FILTER_SANITIZE_STRING);
        $birthdate = filter_var($data->birthdate, FILTER_SANITIZE_STRING);

        // Verificando campos obrigatórios
        if (!$name || !$email || !$password || !$birthdate) {
            http_response_code(400);
            echo json_encode([
                "error" =>
                    "Verifique se preencheu corretamente todos os campos.",
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

        try {
            // Verificando duplicidade
            if (User::emailExists($email)) {
                http_response_code(400);
                echo json_encode([
                    "error" => "E-mail informado já está cadastrado.",
                ]);
                exit();
            }

            // Cadastrando e autenticando usuário
            $token = User::addUser($name, $email, $password, $birthdate);
            $_SESSION['token'] = $token;
        } catch (\Throwable $th) {
            http_response_code(500);
            echo json_encode([
                "error" =>
                    "Erro interno do servidor. Tente novamente ou contate o suporte.",
            ]);
            $this->setErrorLog($th);
            exit();
        }
    }

    public function SignOut()
    {
        $_SESSION['token'] = '';
        $this->redirect('');
    }
}
