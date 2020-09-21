<?php

namespace myBookPlans\app\controllers;

class SiteController
{
    public function actionIndex()
    {
        require_once(ROOT .'/app/views/site/index.php');

        return true;
    }
}
