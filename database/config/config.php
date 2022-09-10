<?php

function getDatabaseConfig(): array
{
    return [
        'sqlite' => [
            'DATABASE_URL' => "sqlite:".__DIR__.'/../dump/blog.sqlite'
        ]
    ];
}