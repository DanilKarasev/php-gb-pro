<?php

namespace App\Repositories;

use App\Blog\Post;

interface PostRepositoryInterface
{
    public function createPost(Post $post): void;
    public function getAllPostsForUser(int $userId): array; //Как сделать array of Post? Post[] ругается
}