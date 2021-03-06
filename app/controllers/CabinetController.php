<?php

namespace myBookPlans\app\controllers;

use myBookPlans\app\models\Library;
use myBookPlans\app\models\User;

class CabinetController
{
    public function actionIndex()
    {
        $userId = User::checkLogged();

        $user = User::getUserById($userId);

        if(!Library::checkUserLibraryExists($userId))
        {
            Library::createNewUserLibrary($userId);
        }

        require_once(ROOT . '/app/views/cabinet/index.php');

        return true;
    }
}
