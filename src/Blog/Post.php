<?php

namespace App\Blog;

use App\Date\DateTime;
use App\Traits\Created;
use App\Traits\Deleted;
use App\Traits\Id;
use App\Traits\Updated;
use Exception;

class Post
{
    use Id;
    use Created;
    use Updated;
    use Deleted;

    public function __construct(
        private readonly string $authorId,
        private readonly string $postTitle,
        private readonly string $postText)
    {
        $this->createdAt = new DateTime();
    }

    public function getPostAuthorId(): string
    {
        return $this->authorId;
    }

    public function getPostTitle(): string
    {
        return $this->postTitle;
    }

    public function getPostText(): string
    {
        return $this->postText;
    }

    /**
     * @throws Exception
     */
    public function setIdAndDates($fetchedPost): void
    {
        $this
            ->setId($fetchedPost->id)
            ->setCreatedAt(new DateTime($fetchedPost->created_at))
            ->setUpdatedAt(($updatedAt = $fetchedPost->updated_at) ? new DateTime($updatedAt) : null)
            ->setDeletedAt(($deletedAt = $fetchedPost->deleted_at) ? new DateTime($deletedAt) : null);
    }

    public function __toString(): string
    {
        return 'Post:'.PHP_EOL .
            'Id: ' . $this->id .
            '; Author id: ' . $this->authorId .
            '; Header: ' . $this->postTitle
            . '; Text: ' . $this->postText.PHP_EOL;
    }
}