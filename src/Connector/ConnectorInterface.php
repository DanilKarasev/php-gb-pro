<?php

namespace App\Connector;
use PDO;

interface ConnectorInterface
{
    public static function getConnection(): PDO;
}