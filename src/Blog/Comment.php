<?php

namespace App\Blog;

use App\Date\DateTime;
use App\Traits\Created;
use App\Traits\Deleted;
use App\Traits\Id;
use App\Traits\Updated;

class Comment
{
    use Id;
    use Created;
    use Updated;
    use Deleted;

    public function __construct(
        private readonly string $authorId,
        private readonly string $postId,
        private readonly string $commentText)
    {
        $this->createdAt = new DateTime();
    }

    public function getAuthorId(): string
    {
        return $this->authorId;
    }

    public function getPostId(): string
    {
        return $this->postId;
    }

    public function getCommentText(): string
    {
        return $this->commentText;
    }

    public function __toString(): string
    {
        return 'Comment:'.PHP_EOL .
            'Id: ' . $this->id .
            '; Author id: ' . $this->authorId .
            '; Post id: ' . $this->postId
            . '; Text: ' . $this->commentText.PHP_EOL;
    }
}