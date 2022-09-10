<?php
require_once '../vendor/autoload.php';

use App\Blog\Comment;
use App\Blog\Post;
use App\Exceptions\UserNotFoundException;
use App\Repositories\UserRepository;
use App\User\Entities\User;
use App\Connector\SqLiteConnector;

require_once __DIR__ . '/autoload_runtime.php';

$connection = SqLiteConnector::getConnection();
$userRepository = new UserRepository();
$faker = Faker\Factory::create();

if ($argv[1] === 'create_user') {
    $user = new User($faker->userName, $faker->firstName, $faker->lastName);
    $userRepository->saveUser($user);
} elseif ($argv[1] === 'get_user') {
    if (!$argv[2]) {
        echo 'Enter used id after a space'.PHP_EOL;
    } else {
        try {
            echo $userRepository->getUser($argv[2]);
        } catch (UserNotFoundException $e) {
            echo $e;
        }
    }
} elseif ($argv[1] === 'comment') {
    echo new Comment(1, $faker->uuid, 1, $faker->sentence(5));
} else {
    echo 'Unknown command!'.PHP_EOL;
}