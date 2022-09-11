<?php

namespace App\Repositories;

use App\Blog\Post;
use App\Connector\SqLiteConnector;
use App\Date\DateTime;
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
    public function getAllPostsForUser(int $userId): ?array//Как сделать array of Post? Post[] ругается
    {
        $statement = $this->connection->prepare(
            'select * from post where author_id = :userId'
        );

        $statement->execute([
            'userId' => $userId
        ]);

        $fetchedPosts = $statement->fetchAll(PDO::FETCH_OBJ);
        $posts = [];
        foreach ($fetchedPosts as $fetchedPost) {
            $post = new Post($fetchedPost->author_id, $fetchedPost->title, $fetchedPost->text);
            $post
                ->setId($fetchedPost->id)
                ->setCreatedAt(new DateTime($fetchedPost->created_at))
                ->setUpdatedAt(($updatedAt = $fetchedPost->updated_at) ? new DateTime($updatedAt) : null)
                ->setDeletedAt(($deletedAt = $fetchedPost->deleted_at) ? new DateTime($deletedAt) : null);
            $posts[] = $post;
        }
        return $posts;
    }
}