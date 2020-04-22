<?php

namespace src\models;

use core\Model;
use src\handlers\UserHandler;
use src\models\User;
use src\models\UserRelation;

class Post extends Model
{
    public static function addPost(int $idUser, string $type, string $body)
    {
        if (!empty($idUser) && !empty($body)) {
            self::insert([
                'id_user' => $idUser,
                'type' => $type,
                'body' => $body,
            ])->execute();
        }
    }

    private function _postListToObject(array $postList, int $loggedUserId)
    {
        $posts = [];
        foreach ($postList as $postItem) {
            $newPost = new Post();
            $newPost->id = $postItem['id'];
            $newPost->type = $postItem['type'];
            $newPost->body = $postItem['body'];
            $newPost->created_at = $postItem['created_at'];
            $newPost->mine = false;

            if ($postItem['id_user'] === $loggedUserId) {
                $newPost->mine = true;
            }

            // preencher infos adicionais no post
            $newUser = User::select()
                ->where('id', $postItem['id_user'])
                ->one();
            $newPost->user = new User();
            $newPost->user->id = $newUser['id'];
            $newPost->user->name = $newUser['name'];
            $newPost->user->slug = UserHandler::nameToSlug($newUser['name']);
            $newPost->user->email = $newUser['email'];
            $newPost->user->avatar = $newUser['avatar'];

            // preencher informações de LIKE
            $newPost->likeCount = 0;
            $newPost->liked = false;

            // preencher informações de COMMENTS
            $newPost->comments = [];

            $posts[] = $newPost;
        }
        return $posts;
    }

    public static function getUserFeed(
        int $idUser,
        int $page,
        int $loggedUserId
    ) {
        $perPage = 5;

        // pegar os posts do perfil ordenados pela data
        $postList = self::select()
            ->where('id_user', $idUser)
            ->orderBy('created_at', 'desc')
            ->page($page, $perPage)
            ->get();

        // contar o total de posts
        $countPosts = self::select()
            ->where('id_user', $idUser)
            ->count();

        $totalPages = ceil($countPosts / $perPage);

        // transformar o resultado em objetos dos models
        $posts = self::_postListToObject($postList, $loggedUserId);

        // retornar o resultado
        return [
            'posts' => $posts,
            'totalPages' => $totalPages,
        ];
    }

    public static function getHomeFeed(int $idUser, int $page)
    {
        $perPage = 5;
        // pegar lista de usuarios que o usuário segue
        $userList = UserRelation::select()
            ->where('user_from', $idUser)
            ->get();
        $users = [];
        foreach ($userList as $userItem) {
            $users[] = $userItem['user_to'];
        }
        $users[] = $idUser;

        // pegar os posts desses usuarios ordenados pela data
        $postList = self::select()
            ->where('id_user', 'in', $users)
            ->orderBy('created_at', 'desc')
            ->page($page, $perPage)
            ->get();

        // contar o total de posts
        $countPosts = self::select()
            ->where('id_user', 'in', $users)
            ->count();

        $totalPages = ceil($countPosts / $perPage);

        // transformar o resultado em objetos dos models
        $posts = self::_postListToObject($postList, $idUser);

        // retornar o resultado
        return [
            'posts' => $posts,
            'totalPages' => $totalPages,
        ];
    }

    public static function getPhotosFrom(int $idUser)
    {
        $photosData = Post::select()
            ->where('id_user', $idUser)
            ->where('type', 'photo')
            ->get();

        $photos = [];

        foreach ($photosData as $photo) {
            $newPost = new Post();
            $newPost->id = $photo['id'];
            $newPost->type = $photo['type'];
            $newPost->created_at = $photo['created_at'];
            $newPost->body = $photo['body'];

            $photos[] = $newPost;
        }

        return $photos;
    }
}
