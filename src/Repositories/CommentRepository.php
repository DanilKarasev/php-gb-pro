<?php

namespace App\Repositories;

use App\Blog\Comment;
use App\Connector\SqLiteConnector;
use App\Date\DateTime;
use Exception;
use PDO;

class CommentRepository extends SqLiteConnector implements CommentRepositoryInterface
{
    public function createComment(Comment $comment): void
    {
        $statement = $this->connection->prepare(
            'insert into comment (post_id, author_id, text, created_at)
                    values (:post_id, :author_id, :text, :created_at)'
        );
        $statement->execute(
            [
                ':post_id'=>$comment->getPostId(),
                ':author_id'=>$comment->getAuthorId(),
                ':text'=>$comment->getCommentText(),
                ':created_at'=>$comment->getCreatedAt(),
            ]
        );
    }

    public function getAllCommentsForPost(int $postId): array
    {
        $statement = $this->connection->prepare(
            'select * from comment where post_id = :postId'
        );

        $statement->execute([
            'postId' => $postId
        ]);

        /**
         * @throws Exception
         */
        $setComments = function ($fetchedComment) {
            $comment = new Comment($fetchedComment->author_id, $fetchedComment->post_id, $fetchedComment->text);
            $comment->setIdAndDates($fetchedComment);

            return $comment;
        };
        $fetchedComments = $statement->fetchAll(PDO::FETCH_OBJ);
        return array_map($setComments, $fetchedComments);
    }
}