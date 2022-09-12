<?php

namespace App\User\Entities;

use App\Date\DateTime;
use App\Traits\Active;
use App\Traits\Created;
use App\Traits\Deleted;
use App\Traits\Id;
use App\Traits\Updated;
use Exception;

class User
{
    use Id;
    use Active;
    use Created;
    use Updated;
    use Deleted;

    public function __construct(
        private readonly string $userName,
        private readonly string $firstName,
        private readonly string $lastName)
    {
        $this->createdAt = new DateTime();
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @throws Exception
     */
    public function setIdAndDates($fetchedUser): void
    {
        $this
            ->setId($fetchedUser->id)
            ->setCreatedAt(new DateTime($fetchedUser->created_at))
            ->setUpdatedAt(($updatedAt = $fetchedUser->updated_at) ? new DateTime($updatedAt) : null)
            ->setDeletedAt(($deletedAt = $fetchedUser->deleted_at) ? new DateTime($deletedAt) : null);
    }

    public function __toString(): string
    {
        $activeUser = $this->isActive() ? 'Active' : 'Inactive';
        return $activeUser.
            ' user with id: ' . $this->getId() .
            ', username: '. $this->userName .
            ', first name: ' . $this->firstName .
            ', last name: ' . $this->lastName .
            ', created at '. $this->createdAt.PHP_EOL;
    }

}