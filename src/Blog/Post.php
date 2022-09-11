<?php

namespace App\Blog;

use App\Date\DateTime;
use App\Traits\Created;
use App\Traits\Deleted;
use App\Traits\Id;
use App\Traits\Updated;

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

    public function __toString(): string
    {
        return 'Post:'.PHP_EOL .
            'Id: ' . $this->id .
            '; Author id: ' . $this->authorId .
            '; Header: ' . $this->postTitle
            . '; Text: ' . $this->postText.PHP_EOL;
    }
}