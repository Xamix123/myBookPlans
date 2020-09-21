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

        $request = $db->prepare($sql);
        $request->bindParam(':userId', $userId, PDO::PARAM_INT);
        $request->setFetchMode(PDO::FETCH_ASSOC);

        $request->execute();

        return $request->fetch();
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

            $request = $db->prepare($sql);
            $request->bindParam(':id', $userId, PDO::PARAM_INT);
            $request->setFetchMode(PDO::FETCH_ASSOC);

            $request->execute();

            $i = 0;
            while ($row = $request->fetch()) {
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

            $request = $db->prepare($sql);
            $request->bindParam(':id', $userId, PDO::PARAM_INT);
            $request->setFetchMode(PDO::FETCH_ASSOC);
            $request->execute();

            $row = $request->fetch();

            return $row['count'];
        }
    }

    /**
     * @param int $userLibId
     * @param int $bookId
     * @return int
     */
    public static function getUserLibRecordBookStatus($userLibId, $bookId)
    {
        $db = Db::getConnection();
        $sql ="SELECT status FROM user_lib_record WHERE id =:userLibId AND id_book =:bookId";
        $request = $db->prepare($sql);
        $request->bindParam(':userLibId', $userLibId, PDO::PARAM_INT);
        $request->bindParam(':bookId', $bookId, PDO::PARAM_INT);
        $request->setFetchMode(PDO::FETCH_ASSOC);

        $request->execute();

        return $request->fetch();
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

            $request = $db->prepare($sql);
            $request->bindParam(':id', $userId, PDO::PARAM_INT);
            $request->bindParam(':idBook', $bookId, PDO::PARAM_INT);
            $request->setFetchMode(PDO::FETCH_NUM);

            $request->execute();

            return $request->fetch();
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

        $request = $db->prepare($sql);
        $request->bindParam(':userLibId', $userLibId, PDO::PARAM_INT);
        $request->bindParam(':bookId', $bookId, PDO::PARAM_INT);
        $request->bindParam(':status', $status, PDO::PARAM_INT);

        return $request->execute();
    }

    public static function deleteUserLibRecord($userLibId, $bookId)
    {
        $result = 0;
        $db = DB::getConnection();

        $sql = "DELETE FROM user_lib_record WHERE id_user_lib =:userLibId AND id_book =:bookId";

        $request = $db->prepare($sql);
        $request->bindParam(':userLibId', $userLibId, PDO::PARAM_INT);
        $request->bindParam(':bookId', $bookId, PDO::PARAM_INT);

        if ($request->execute()) {
            $result = $bookId;
        }

        return $result;
    }
}
