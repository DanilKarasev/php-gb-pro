<?php

namespace App\Repositories;

use App\Blog\Post;
use App\Connector\SqLiteConnector;
use App\Date\DateTime;
use App\Exceptions\PostNotFoundException;
use Exception;
use PDO;

class PostRepository extends SqLiteConnector implements PostRepositoryInterface
{

    public function createPost(Post $post): void
    {
        $statement = $this->connection->prepare(
            'insert into post (author_id, title, text, created_at)
                    values (:author_id, :title, :text, :created_at)'
        );
        $statement->execute(
            [
                ':author_id'=>$post->getPostAuthorId(),
                ':title'=>$post->getPostTitle(),
                ':text'=>$post->getPostText(),
                ':created_at'=>$post->getCreatedAt(),
            ]
        );
    }

    /**
     * @throws Exception
     */
    public function getPostWithId(int $postId): Post
    {
        $statement = $this->connection->prepare(
            'select * from post where id = :postId'
        );

        $statement->execute([
            'postId' => $postId
        ]);

        $fetchedPost = $statement->fetch(PDO::FETCH_OBJ);
        if (!$fetchedPost) throw new PostNotFoundException("Post with id:$postId was not found");

        $post = new Post($fetchedPost->author_id, $fetchedPost->title, $fetchedPost->text);
        $post
            ->setId($fetchedPost->id)
            ->setCreatedAt(new DateTime($fetchedPost->created_at))
            ->setUpdatedAt(($updatedAt = $fetchedPost->updated_at) ? new DateTime($updatedAt) : null)
            ->setDeletedAt(($deletedAt = $fetchedPost->deleted_at) ? new DateTime($deletedAt) : null);

        return $post;
    }

    /**
     * @throws Exception
     */
    public function getAllPostsForUser(int $userId): array//Как сделать array of Post? Post[] ругается
    {
        $statement = $this->connection->prepare(
            'select * from post where author_id = :userId'
        );

        $statement->execute([
            'userId' => $userId
        ]);

        $setPosts = function ($fetchedPost) {
            $post = new Post($fetchedPost->author_id, $fetchedPost->title, $fetchedPost->text);
            $post
                ->setId($fetchedPost->id)
                ->setCreatedAt(new DateTime($fetchedPost->created_at))
                ->setUpdatedAt(($updatedAt = $fetchedPost->updated_at) ? new DateTime($updatedAt) : null)
                ->setDeletedAt(($deletedAt = $fetchedPost->deleted_at) ? new DateTime($deletedAt) : null);

            return $post;
        };
        $fetchedPosts = $statement->fetchAll(PDO::FETCH_OBJ);
        return array_map($setPosts, $fetchedPosts);
    }
}