<?php

namespace App\Connector;

use PDO;

class SqLiteConnector implements ConnectorInterface
{
    protected PDO $connection;

    public function __construct()
    {
        $this->connection = $this->getConnection();
    }
    public static function getConnection(): PDO
    {
        return new PDO(getDatabaseConfig()['sqlite']['DATABASE_URL']);
    }
}