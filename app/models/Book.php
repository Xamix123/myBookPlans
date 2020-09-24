<?php

namespace myBookPlans\app\models;

use myBookPlans\app\components\Db;
use PDO;

class Book
{
    const SHOW_BY_DEFAULT = 6;
    const BOOK_IMG_PATH = "/app/upload/images/books/";

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

        $request = $db->prepare($sql);
        $request->bindParam(':id', $id, PDO::PARAM_INT);

        $request->setFetchMode(PDO::FETCH_ASSOC);
        $request->execute();

        $book= [];

        $row = $request->fetch();

        $book['id'] = $row['id'];
        $book['title'] = $row['title'];
        $book['author'] = $row['author'];
        $book['publishingHouse'] = $row['publishing_house'];
        $book['series'] = $row['series'];
        $book['countPages'] = $row['count_pages'];

        return $book;
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

    /**
     * @param array $data
     * @param int $bookId
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
    public static function updateBook($data, $bookId)
    {

        $result = 0;

        $db = Db::getConnection();

        $sql = "UPDATE books SET title =:title, author =:author, publishing_house =:publishingHouse,
                series =:series, count_pages = :countPages, description = :description
                WHERE id =:bookId";

        $request = $db->prepare($sql);
        $request->bindParam(':title', $data['title'], PDO::PARAM_STR);
        $request->bindParam(':author', $data['author'], PDO::PARAM_STR);
        $request->bindParam(':publishingHouse', $data['publishingHouse'], PDO::PARAM_STR);
        $request->bindParam(':series', $data['series'], PDO::PARAM_STR);
        $request->bindParam(':countPages', $data['countPages'], PDO::PARAM_INT);
        $request->bindParam(':description', $data['description'], PDO::PARAM_STR);
        $request->bindParam(':bookId', $bookId, PDO::PARAM_INT);

        if ($request->execute()) {
            $result = $bookId;
        }

        return $result;
    }

    /**
     * @param int $bookId
     * @return int
     */
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
