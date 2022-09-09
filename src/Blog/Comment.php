<?php

namespace App\Blog;

class Comment
{
    public function __construct(
        private string $id,
        private string $authorId,
        private string $postId,
        private string $commentText)
    {
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