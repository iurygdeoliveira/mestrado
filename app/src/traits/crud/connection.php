<?php

declare(strict_types=1);

namespace src\traits\crud;

use PDOException;
use PDO;

trait connection
{

    public function connectDB()
    {
        try {
            $pdo = new PDO(
                "mysql:host=" . CONF_MYSQL_HOST .
                    ";dbname=" . CONF_MYSQL_DATABASE,
                CONF_MYSQL_USER,
                CONF_MYSQL_PASSWORD,
                [
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_CLASS,
                    PDO::ATTR_CASE => PDO::CASE_NATURAL
                ]
            );
            $this->fail = null;
            return $pdo;
        } catch (PDOException $exception) {
            $this->fail = $exception;
            return false;
        }
    }
}
