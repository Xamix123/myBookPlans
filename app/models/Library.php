<?php

namespace myBookPlans\app\models;

use myBookPlans\app\components\Db;
use PDO;

class Library
{
    /**
     * get id user library
     *
     * @param int $userId
     *
     * @return mixed
     */
    public static function getIdUserLibrary($userId)
    {
        $db = Db::getConnection();
        $sql = "SELECT id FROM user_lib WHERE id_user = :userId;";

        $result = $db->prepare($sql);
        $result->bindParam(':userId', $userId, PDO::PARAM_INT);
        $result->setFetchMode(PDO::FETCH_ASSOC);

        $result->execute();

        return $result->fetch();
    }

    /**
     * @param int $userId
     * @param int $page
     * @param int $count
     *
     * @return array
     */
    public static function getListBooksIds($userId, $page, $count = Book::SHOW_BY_DEFAULT)
    {
        if ($userId) {
            $db = Db::getConnection();

            $booksIds = [];
            $count = intval($count);
            $page = intval($page);

            $offset = $page == 1
                ? 0
                : ($page-1) * $count;

            $sql = "SELECT id_book FROM user_lib 
                    INNER JOIN user_lib_record 
                        ON user_lib.id = user_lib_record.id_user_lib 
                    WHERE user_lib.id = :id"
                    . " ORDER BY id_book DESC "
                    . "LIMIT " . $count
                    . " OFFSET " . $offset;

            $result = $db->prepare($sql);
            $result->bindParam(':id', $userId, PDO::PARAM_INT);
            $result->setFetchMode(PDO::FETCH_ASSOC);

            $result->execute();

            $i = 0;
            while ($row = $result->fetch()) {
                $booksIds[$i]['id'] = $row['id_book'];
                $i++;
            }

            return $booksIds;
        }
    }

    /**
     * @param $userId
     *
     * @return mixed
     */
    public static function getCountBooksInUserLibrary($userId)
    {
        if ($userId) {
            $db = Db::getConnection();
            $sql = "SELECT count(id_book) AS count FROM user_lib 
                    INNER JOIN user_lib_record 
                        ON user_lib.id = user_lib_record.id_user_lib 
                    WHERE user_lib.id = :id;";

            $result = $db->prepare($sql);
            $result->bindParam(':id', $userId, PDO::PARAM_INT);
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $result->execute();

            $row = $result->fetch();

            return $row['count'];
        }
    }

    /**
     * return array booksIds
     *
     * @param int $userId
     * @param int $bookId
     *
     * @return mixed
     */
    public static function checkLibraryContainsBook($userId, $bookId)
    {
        if ($userId) {
            $db = Db::getConnection();
            $sql = "SELECT id_book FROM user_lib 
                    INNER JOIN user_lib_record 
                        ON user_lib.id = user_lib_record.id_user_lib 
                    WHERE user_lib.id = :id AND user_lib_record.id_book =:idBook;";

            $result = $db->prepare($sql);
            $result->bindParam(':id', $userId, PDO::PARAM_INT);
            $result->bindParam(':idBook', $bookId, PDO::PARAM_INT);
            $result->setFetchMode(PDO::FETCH_NUM);

            $result->execute();

            return $result->fetch();
        }
    }

    /**
     * @param int $userLibId
     * @param int $bookId
     * @param int $status
     *
     * @return bool
     */
    public static function createNewUserLibRecord($userLibId, $bookId, $status)
    {
        $db = DB::getConnection();

        $sql = "INSERT INTO user_lib_record(id_user_lib, id_book, status) "
            . "VALUES (:userLibId, :bookId, :status)";

        $result = $db->prepare($sql);
        $result->bindParam(':userLibId', $userLibId, PDO::PARAM_INT);
        $result->bindParam(':bookId', $bookId, PDO::PARAM_INT);
        $result->bindParam(':status', $status, PDO::PARAM_INT);

        return $result->execute();
    }
}
