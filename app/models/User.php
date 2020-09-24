<?php

namespace myBookPlans\app\models;

use myBookPlans\app\components\Db;
use PDO;

class User
{

    /**
     * @param int $id
     *
     * @return mixed
     */
    public static function getUserById($id)
    {
        if ($id) {
            $db = Db::getConnection();
            $sql = "SELECT * FROM users WHERE id = :id";

            $result = $db->prepare($sql);
            $result->bindParam(':id', $id, PDO::PARAM_INT);

            $result->setFetchMode(PDO::FETCH_ASSOC);
            $result->execute();

            return $result->fetch();
        }
    }

    /**
     * @param string $name
     * @param string $email
     * @param string $password
     *
     * @return bool
     */
    public static function register($name, $email, $password)
    {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $db = DB::getConnection();

        $sql = 'INSERT INTO users(name, email, password) '
            . 'VALUES (:name, :email, :password)';

        $result = $db->prepare($sql);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);

        return $result->execute();
    }

    /**
     * check if email in DB
     *
     * @param string $email
     *
     * @return bool
     */
    public static function checkEmailExists($email)
    {
        $db = Db::getConnection();
        $sql = 'SELECT COUNT(*) FROM users WHERE email = :email';

        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->execute();

        $res = false;
        if ($result ->fetchColumn()) {
            $res = true;
        }

        return $res;
    }

    /**
     * @param string $email
     * @param string $password
     *
     * @return false|int
     */
    public static function checkUserData($email, $password)
    {
        $result  = false;
        $db = DB::getConnection();

        $sql = 'SELECT * FROM users where email = :email';

        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->execute();

        $user = $result->fetch();

        if ($user) {
            $result = password_verify($password, $user['password'])
                ? $user['id']
                : false;
        }

        return $result;
    }

    /**
     * put user into the session
     *
     * @param int $userId
     */
    public static function auth($userId)
    {
        $_SESSION['user'] = $userId;
    }

    /**
     * checks if the user is in the session
     *
     * @return mixed
     */
    public static function checkLogged()
    {
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }

        header("Location: /user/login");
    }

    /**
     * @return bool
     */
    public static function isGuest()
    {
        $result = true;
        if (isset($_SESSION['user'])) {
            $result = false;
        }

        return $result;
    }
}
