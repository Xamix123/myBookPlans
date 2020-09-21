<?php

namespace myBookPlans\app\controllers;

use myBookPlans\app\models\User;
use myBookPlans\app\validators\UserDataValidator;

class UserController
{
    public function actionLogin()
    {
        $data['email'] = '';
        $data['password'] = '';

        if (isset($_POST['submit'])) {
            $data['email'] = $_POST['email'];
            $data['password'] = $_POST['password'];

            $errors = false;

            $userId = USER::checkUserData($data['email'], $data['password']);

            if ($userId == false) {
                // если данные неправильные показываем ошибку
                $errors[] = "Неправильные данные для входа на сайт";
            } else {
                // Если данные правильные записываем пользователя в сессию
                USER::auth($userId);

                //переправляем пользователя в закрытую часть кабинет
                header("Location: /cabinet/");
            }
        }
        require_once(ROOT . '/app/views/user/login.php');

        return true;
    }
    public function actionRegister()
    {
        $data['name'] = '';
        $data['email'] = '';
        $data['password'] = '';
        $result = false;
        if (isset($_POST['submit'])) {
            $data['name'] = $_POST['name'];
            $data['email'] = $_POST['email'];
            $data['password'] = $_POST['password'];

            $errors = [];

            (new UserDataValidator())->validateData($data, $errors);

            if (empty($errors)) {
                $result = User::register($data['name'], $data['email'], $data['password']);
            }
        }
        require_once(ROOT . '/app/views/user/register.php');

        return true;
    }

    public function actionLogout()
    {
        unset($_SESSION["user"]);
        header("Location: /");
    }
}
