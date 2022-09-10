<?php

namespace App\Repositories;

use App\User\Entities\User;

interface UserRepositoryInterface
{
    public function saveUser(User $user): void;
    public function getUser(int $id): User;
}