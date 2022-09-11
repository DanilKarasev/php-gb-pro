<?php

namespace App\Repositories;

use App\Blog\Comment;

interface CommentRepositoryInterface
{
    public function createComment(Comment $comment): void;
    public function getAllCommentsForPost(int $postId): array;
}