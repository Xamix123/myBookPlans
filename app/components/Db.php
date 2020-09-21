<?php

namespace myBookPlans\app\components;

use PDO;
use PDOException;

class Db
{
    public static function getConnection()
    {
        $paramsPath = ROOT . '/app/config/db_params.php';

        $params = include($paramsPath);
        $db = "";
        try {
            $dsn = "mysql:host={$params['host']};dbname={$params['dbname']};charset={$params['charset']}";
            $db = new PDO($dsn, $params['user'], $params['password']);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "connection failed " . $e->getMessage();
        }

        return $db;
    }
}
