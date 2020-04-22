<?php

namespace src\handlers;

use src\models\User;

class LoginHandler extends User
{
    private function formatDateToBr(string $date)
    {
        $intlDate = explode('-', $date);
        $brDate = $intlDate['2'] . '/' . $intlDate['1'] . '/' . $intlDate['0'];

        return $brDate;
    }

    /**
     * Verificação de usuário logado
     */
    public static function checkLoggedUser()
    {
        if (!empty($_SESSION['token'])) {
            $token = $_SESSION['token'];

            $data = User::select()
                ->where('token', $token)
                ->one();

            if (count($data) > 0) {
                $loggedUser = new User();
                $loggedUser->id = $data['id'];
                $loggedUser->email = $data['email'];
                $loggedUser->name = $data['name'];
                $loggedUser->slug = UserHandler::nameToSlug($data['name']);
                $loggedUser->birthdate = self::formatDateToBr(
                    $data['birthdate'],
                );
                $loggedUser->city = $data['city'];
                $loggedUser->work = $data['work'];
                $loggedUser->avatar = $data['avatar'];

                return $loggedUser;
            }
        }

        return false;
    }

    /**
     * Verificação de dados para autenticação
     */
    public static function verifyLogin(string $email, string $password)
    {
        $user = User::select()
            ->where('email', $email)
            ->one();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $token = md5(time() . rand(0, 9999));
                User::update()
                    ->set('token', $token)
                    ->where('email', $email)
                    ->execute();
                return $token;
            }
        }

        return false;
    }
}
