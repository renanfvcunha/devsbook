<?php

namespace src\models;

use core\Model;
use src\handlers\UserHandler;
use src\models\UserRelation;
use src\models\Post;

class User extends Model
{
    /**
     * Verificação de id já cadastrado
     */
    public static function idExists(int $id)
    {
        $user = self::select()
            ->where('id', $id)
            ->one();
        return $user ? true : false;
    }

    /**
     * Verificação de email já cadastrado
     */
    public static function emailExists(string $email)
    {
        $user = self::select()
            ->where('email', $email)
            ->one();
        return $user ? true : false;
    }

    public static function getUser(int $id, bool $full = false)
    {
        $data = self::select()
            ->where('id', $id)
            ->one();

        if ($data) {
            $user = new User();
            $user->id = $data['id'];
            $user->email = $data['email'];
            $user->name = $data['name'];
            $user->slug = UserHandler::nameToSlug($data['name']);
            $user->birthdate = $data['birthdate'];
            $user->city = $data['city'];
            $user->work = $data['work'];
            $user->avatar = $data['avatar'];
            $user->cover = $data['cover'];

            if ($full) {
                $user->followers = [];
                $user->following = [];
                $user->photos = [];

                // followers
                $followers = UserRelation::select()
                    ->where('user_to', $id)
                    ->get();
                foreach ($followers as $follower) {
                    $userData = User::select()
                        ->where('id', $follower['user_from'])
                        ->one();

                    $newUser = new User();
                    $newUser->id = $userData['id'];
                    $newUser->name = $userData['name'];
                    $newUser->slug = UserHandler::nameToSlug($userData['name']);
                    $newUser->avatar = $userData['avatar'];

                    $user->followers[] = $newUser;
                }
                // following
                $following = UserRelation::select()
                    ->where('user_from', $id)
                    ->get();
                foreach ($following as $follower) {
                    $userData = User::select()
                        ->where('id', $follower['user_to'])
                        ->one();

                    $newUser = new User();
                    $newUser->id = $userData['id'];
                    $newUser->name = $userData['name'];
                    $newUser->slug = UserHandler::nameToSlug($userData['name']);
                    $newUser->avatar = $userData['avatar'];

                    $user->following[] = $newUser;
                }
                //photos
                $user->photos = Post::getPhotosFrom($id);
            }

            return $user;
        }

        return false;
    }

    /**
     * Cadastro de novo usuário
     */
    public static function addUser(
        string $name,
        string $email,
        string $password,
        string $birthdate
    ) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $token = md5(time() . rand(0, 9999));

        self::insert([
            'email' => $email,
            'password' => $hash,
            'name' => $name,
            'birthdate' => $birthdate,
            'token' => $token,
        ])->execute();

        return $token;
    }

    public static function searchUser(string $search)
    {
        $users = [];
        $data = self::select()
            ->where('name', 'like', '%' . $search . '%')
            ->get();

        if ($data) {
            foreach ($data as $user) {
                $newUser = new User();
                $newUser->id = $user['id'];
                $newUser->name = $user['name'];
                $newUser->slug = UserHandler::nameToSlug($user['name']);
                $newUser->avatar = $user['avatar'];
                $users[] = $newUser;
            }
        }

        return $users;
    }

    public static function updateUser(
        int $id,
        string $name,
        string $birthdate,
        string $email,
        string $city,
        string $work,
        string $password
    ) {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        if (!empty($password)) {
            self::update([
                'name' => $name,
                'birthdate' => $birthdate,
                'email' => $email,
                'city' => $city,
                'work' => $work,
                'password' => $hash,
                'updated_at' => date('c'),
            ])
                ->where('id', $id)
                ->execute();
        } else {
            self::update([
                'name' => $name,
                'birthdate' => $birthdate,
                'email' => $email,
                'city' => $city,
                'work' => $work,
                'updated_at' => date('c'),
            ])
                ->where('id', $id)
                ->execute();
        }
    }

    public static function isFollowing(int $from, int $to)
    {
        $data = UserRelation::select()
            ->where('user_from', $from)
            ->where('user_to', $to)
            ->one();

        if ($data) {
            return true;
        }

        return false;
    }

    public static function follow(int $from, int $to)
    {
        UserRelation::insert([
            'user_from' => $from,
            'user_to' => $to,
        ])->execute();

        $followersCount = UserRelation::select()
            ->where('user_to', $to)
            ->count();

        return $followersCount;
    }

    public static function unfollow(int $from, int $to)
    {
        UserRelation::delete()
            ->where('user_from', $from)
            ->where('user_to', $to)
            ->execute();

        $followersCount = UserRelation::select()
            ->where('user_to', $to)
            ->count();

        return $followersCount;
    }
}
