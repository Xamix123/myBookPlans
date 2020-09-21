<?php

namespace myBookPlans\app\models;

use myBookPlans\app\components\Db;
use PDO;

class Book
{
    const SHOW_BY_DEFAULT = 6;

    /**
     * get book by id
     *
     * @param int $id
     *
     * @return mixed
     */
    public static function getBookById($id)
    {
        $db = Db::getConnection();

        $sql = "SELECT * FROM books WHERE id = :id";

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);

        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();

        return $result->fetch();
    }

    /**
     * @param array $idsArray
     *
     * @return array
     */
    public static function getBooksByIds($idsArray)
    {
        $books = [];

        $db = DB::getConnection();

        $idsString = self::convertArrayIdsToString($idsArray);

        $sql = "SELECT * FROM books WHERE id IN ($idsString) ORDER BY id DESC";

        $result = $db->query($sql);

        $result->setFetchMode(PDO::FETCH_ASSOC);

        $i = 0;
        while ($row = $result->fetch()) {
            $books[$i]['id'] = $row['id'];
            $books[$i]['title'] = $row['title'];
            $books[$i]['author'] = $row['author'];
            $i++;
        }

        return $books;
    }

    /**
     * get Image extension
     *
     * @param $filePath
     *
     * @return string
     */
    public static function getImageExtension($filePath)
    {
        $result = "";
        if (exif_imagetype($filePath) == IMAGETYPE_JPEG) {
            $result = ".jpg";
        } elseif (exif_imagetype($filePath) == IMAGETYPE_PNG) {
            $result = ".png";
        }

        return $result;
    }

    /**
     * get Image path
     *
     * @param int $bookId
     *
     * @return string
     */
    public static function getImagePath($bookId)
    {
        $result = "";

        $path = "/app/upload/images/books/";

        if (is_file(ROOT . $path . $bookId . ".jpg")) {
            $result = $path . $bookId . ".jpg";
        } elseif (is_file(ROOT . $path . $bookId . ".png")) {
            $result = $path . $bookId . ".png";
        } else {
            $result = $path . "no-image.png";
        }

        return $result;
    }

    /**
     * @param array $idsArray
     *
     * @return string
     */
    private static function convertArrayIdsToString($idsArray)
    {
        $i = 0;
        $length = count($idsArray);
        $idsString = "";

        foreach ($idsArray as $id) {
            $idsString .= $i != ($length - 1)
                ? "{$id['id']},"
                : "{$id['id']}";
            $i++;
        }

        return $idsString;
    }

    /**
     * @param $data
     *
     * example data
     * data {
     *  'title' => "exampleTitle",
     *  'author' => "exampleAuthor",
     *  'publishingHouse' => "examplePublishingHouse",
     *  'series' => "exampleSeries",
     *  'countPages' => 123,
     *  'description' => "example description about book"
     * }
     *
     * @return int|string
     */
    public static function createBook($data)
    {
        $result = 0;

        $db = Db::getConnection();

        $sql = "INSERT INTO books(title, author, publishing_house, series, count_pages, description)"
            . "VALUES (:title, :author, :publishingHouse, :series, :countPages, :description)";

        $request = $db->prepare($sql);
        $request->bindParam(':title', $data['title'], PDO::PARAM_STR);
        $request->bindParam(':author', $data['author'], PDO::PARAM_STR);
        $request->bindParam(':publishingHouse', $data['publishingHouse'], PDO::PARAM_STR);
        $request->bindParam(':series', $data['series'], PDO::PARAM_STR);
        $request->bindParam(':countPages', $data['countPages'], PDO::PARAM_INT);
        $request->bindParam(':description', $data['description'], PDO::PARAM_STR);

        if ($request->execute()) {
            $result = $db->lastInsertId();
        }

        return $result;
    }

    public static function deleteBook($bookId)
    {
        $result = 0;
        $db = Db::getConnection();

        $sql = "DELETE FROM books WHERE id = :bookId";

        $request = $db->prepare($sql);
        $request->bindParam(':bookId', $bookId, PDO::PARAM_INT);

        if ($request = $request->execute()) {
            $result = $bookId;
        }

        return $result;
    }
}
