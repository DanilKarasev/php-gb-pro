<?php

namespace App\Repositories;
use App\Connector\SqLiteConnector;
use App\Exceptions\UserNotFoundException;
use App\User\Entities\User;

use Exception;
use PDO;

class UserRepository extends SqLiteConnector implements UserRepositoryInterface
{
    public function saveUser(User $user): void
    {
        $statement = $this->connection->prepare(
            'insert into user (username, first_name, last_name, created_at)
                    values (:username, :first_name, :last_name, :created_at)'
        );
        $statement->execute(
            [
                ':username'=>$user->getUserName(),
                ':first_name'=>$user->getFirstName(),
                ':last_name'=>$user->getLastName(),
                ':created_at'=>$user->getCreatedAt(),
            ]
        );
    }

    /**
     * @param int $id
     * @return User
     * @throws UserNotFoundException
     * @throws Exception
     */
    public function getUser(int $id): User
    {
        $statement = $this->connection->prepare(
            'select * from user where id = :userId'
        );

        $statement->execute([
            'userId' => $id
        ]);

        $fetchedUser = $statement->fetch(PDO::FETCH_OBJ);
        if (!$fetchedUser) throw new UserNotFoundException("User with id:$id was not found");

        $user = new User($fetchedUser->username, $fetchedUser->first_name, $fetchedUser->last_name);
        $user->setIdAndDates($fetchedUser);

        return $user;
    }
}