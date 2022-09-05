<?php
require_once 'vendor/autoload.php';
use App\User\User;
use App\Blog\Post;
use App\Blog\Comment;
$loader = require __DIR__ . '/vendor/autoload.php';

//Это чтоб на пятерку)
function replacer($string): string
{
    $stringArray = explode( "\\", $string);
    $changedElement = str_replace('_', '\\', array_pop($stringArray));
    $stringArray[] = $changedElement;
    return join('\\', $stringArray);
}
echo (replacer('\my\package_name\Class_Name')).PHP_EOL;

$faker = Faker\Factory::create();

if ($argv[1] === 'user') {
    echo new User($faker->uuid, $faker->firstName, $faker->lastName);
} elseif ($argv[1] === 'post') {
    echo new Post(1, $faker->uuid, $faker->words(2, true), $faker->sentence);
} elseif ($argv[1] === 'comment') {
    echo new Comment(1, $faker->uuid, 1, $faker->sentence(5));
} else {
    echo 'Unknown command!'.PHP_EOL;
}