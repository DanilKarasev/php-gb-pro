<?php

namespace App\Blog;

class Post
{
    public function __construct(
        private string $id,
        private string $authorId,
        private string $postHeader,
        private string $postText)
    {
    }

    public function __toString(): string
    {
        return 'Post:'.PHP_EOL .
            'Id: ' . $this->id .
            '; Author id: ' . $this->authorId .
            '; Header: ' . $this->postHeader
            . '; Text: ' . $this->postText.PHP_EOL;
    }
}