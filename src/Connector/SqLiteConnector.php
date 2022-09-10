<?php

namespace App\Connector;

use PDO;

class SqLiteConnector implements ConnectorInterface
{
    public static function getConnection(): PDO
    {
        return new PDO(getDatabaseConfig()['sqlite']['DATABASE_URL']);
    }
}