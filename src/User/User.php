<?php

namespace App\User;

class User
{
    public function __construct(
        private string $id,
        private string $firstName,
        private string $lastName)
    {
    }

    public function __toString(): string
    {
        return 'User with id: ' . $this->id . ' and following name: ' . $this->firstName . ' ' . $this->lastName
            . ' was successfully created!'.PHP_EOL;
    }

}