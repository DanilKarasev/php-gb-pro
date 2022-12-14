<?php
require_once '../vendor/autoload.php';

use App\Blog\Comment;
use App\Blog\Post;
use App\Exceptions\PostNotFoundException;
use App\Exceptions\UserNotFoundException;
use App\Repositories\CommentRepository;
use App\Repositories\PostRepository;
use App\Repositories\UserRepository;
use App\User\Entities\User;
use App\Connector\SqLiteConnector;

require_once __DIR__ . '/autoload_runtime.php';

$connection = SqLiteConnector::getConnection();

$userRepository = new UserRepository();
$postRepository = new PostRepository();
$commentRepository = new CommentRepository();

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
} elseif ($argv[1] === 'create_post') {
    if (!$argv[2]) {
        echo 'Enter used id after a space'.PHP_EOL;
    } else {
        try {
            $user = $userRepository->getUser($argv[2]);
            $post = new Post($user->getId(), $faker->word, $faker->text);
            $postRepository->createPost($post);
        } catch (UserNotFoundException $e) {
            echo $e;
        }
    }
} elseif ($argv[1] === 'get_posts') {
    if (!$argv[2]) {
        echo 'Enter used id after a space'.PHP_EOL;
    } else {
        try {
            $user = $userRepository->getUser($argv[2]);
            $posts = $postRepository->getAllPostsForUser($user->getId());
            if (empty($posts)) {
                echo "No posts for user with id:{$argv[2]}".PHP_EOL;
            } else {
                foreach ($posts as $post) {
                    echo $post;
                }
            }
        } catch (UserNotFoundException $e) {
            echo $e;
        }
    }
} elseif ($argv[1] === 'create_comment') {
    if (!$argv[2]) {
        echo 'Enter used id after a space'.PHP_EOL;
    } if (!$argv[3]) {
        echo 'Enter post id after a space'.PHP_EOL;
    } else {
        try {
            $user = $userRepository->getUser($argv[2]);
            try {
                $post = $postRepository->getPostWithId($argv[3]);
                $comment = new Comment($user->getId(), $post->getId(), $faker->text);
                $commentRepository->createComment($comment);
            } catch (PostNotFoundException $e) {
                echo $e;
            }
        } catch (UserNotFoundException $e) {
            echo $e;
        }
    }
} elseif ($argv[1] === 'get_comments') {
    if (!$argv[2]) {
        echo 'Enter post id after a space'.PHP_EOL;
    } else {
        try {
            $post = $postRepository->getPostWithId($argv[2]);
            $comments = $commentRepository->getAllCommentsForPost($post->getId());
            if (empty($comments)) {
                echo "No comments for post with id:{$argv[2]}".PHP_EOL;
            } else {
                foreach ($comments as $comment) {
                    echo $comment;
                }
            }
        } catch (PostNotFoundException $e) {
            echo $e;
        }
    }
} else {
    echo 'Unknown command!'.PHP_EOL;
}
