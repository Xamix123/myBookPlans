<?php

namespace myBookPlans\app\controllers;

use myBookPlans\app\components\Pagination;
use myBookPlans\app\models\Book;
use myBookPlans\app\models\User;
use myBookPlans\app\models\Library;
use myBookPlans\app\validators\BookDataValidator;

/**
 * Class LibraryController
 * @package myBookPlans\app\controllers
 */
class LibraryController
{
    /**
     * @param int $page
     * @return bool
     */
    public function actionIndex($page = 1)
    {
        $userId = User::checkLogged();
        $limit = Book::SHOW_BY_DEFAULT;

        $total = Library::getCountBooksInUserLibrary($userId);

        $userLibId = Library::getIdUserLibrary($userId);

        if ($total > 0) {
            $booksIds = Library::getListBooksIds($userId, $page);
        }

        if (! empty($booksIds)) {
            $books = Book::getBooksByIds($booksIds);

            foreach ($books as $id => $book) {
                $books[$id]['img'] = Book::getImagePath($book['id']);
            }

            $paginator = new Pagination($total, $page, $limit, 'page-');
        }
        require_once(ROOT . "/app/views/library/index.php");

        return true;
    }

    /**
     * @param int $bookId
     * @return bool
     */
    public function actionBook($bookId)
    {
        $userId = User::checkLogged();

        $userLibId = Library::getIdUserLibrary($userId);

        $bookStatus = Library::checkLibraryContainsBook($userLibId, $bookId);

        $book = [];
        if ($bookStatus) {
            $book = Book::getBookById($bookId);
            $book['img'] = Book::getImagePath($book['id']);

            $book['status'] = Library::getUserLibRecordBookStatus($userLibId, $bookId);
            $book['status'] = $book['status'] == 1
                ? "Прочитано"
                : "Не прочитано";
        }
        require_once(ROOT . "/app/views/library/book.php");

        return true;
    }

    /**
     * @return bool
     */
    public function actionAddBook()
    {
        $data = [];
        $bookId = null;
        $errors = [];
        $data = [
            "title"  => "",
            "author" => "",
            "publishingHouse" => "",
            "series" => "",
            "countPages" => "",
            "img" => "",
            "description" =>""
        ];

        $userId = User::checkLogged();
        $userLibId = Library::getIdUserLibrary($userId);

        if (isset($_POST['submit'])) {
            $data = [
                "title"  => $_POST['title'],
                "author" => $_POST['author'],
                "publishingHouse" => $_POST['publishingHouse'],
                "series" => $_POST['series'],
                "countPages" => $_POST['countPages'],
                "img" => $_FILES['image'],
                "description" => $_POST['description'],
                "status" => $_POST['status']
            ];
            $textData = [
                $data['title'],
                $data['author'],
                $data['publishingHouse'],
                $data['series'],
                $data['description']
            ];

            foreach ($textData as $item) {
                $item = trim($item);
                $item = html_entity_decode($item);
                $item = htmlspecialchars_decode($item, ENT_NOQUOTES);
            }

            $data = array_replace($data, $textData);

            BookDataValidator::validateData($data, $errors);

            if (empty($errors)) {
                //если валидация прошла успешно создаем новую запись
                $bookId = Book::createBook($data);

                //добавляем новую запись в библиотеку пользователя
                Library::createNewUserLibRecord($userLibId, $bookId, $data['status']);

                //если запись добавлена
                if ($bookId) {
                    // Если файл загрузился переместим его в нужную папку и переименуем
                    if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
                        $imgExtension = Book::getImageExtension($data['img']['tmp_name']);
                        move_uploaded_file($_FILES["image"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] .
                            "/app/upload/images/books/{$bookId}"."$imgExtension");
                    }
                }
            }
        }

        require_once(ROOT . "/app/views/library/addBook.php");

        return true;
    }

    public function actionUpdateBook($bookId)
    {
        $userId = User::checkLogged();

        $userLibId = Library::getIdUserLibrary($userId);

        if (Library::checkLibraryContainsBook($userLibId, $bookId)) {
            $bookId = Library::deleteUserLibRecord($userLibId, $bookId);
        }

        header("Location: /library/");

        return true;
    }

    /**
     * @param int $bookId
     * @return bool
     */
    public function actionDeleteBook($bookId)
    {
        $userId = User::checkLogged();

        $userLibId = Library::getIdUserLibrary($userId);

        if (Library::checkLibraryContainsBook($userLibId, $bookId)) {
            $bookId = Library::deleteUserLibRecord($userLibId, $bookId);
        }

        header("Location: /library/");

        return true;
    }
}
