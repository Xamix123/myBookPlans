<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Главная</title>
    <link href="/app/template/css/bootstrap.min.css" type="text/css" rel="stylesheet">
    <link href="/app/template/css/font-awesome.min.css" rel="stylesheet">
    <link href="/app/template/css/prettyPhoto.css" rel="stylesheet">
    <link href="/app/template/css/price-range.css" rel="stylesheet">
    <link href="/app/template/css/animate.css" rel="stylesheet">
    <link href="/app/template/css/main.css" rel="stylesheet">
    <link href="/app/template/css/responsive.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="/app/template/js/html5shiv.js"></script>
    <script src="/app/template/js/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="/app/template/images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/app/template/images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/app/template/images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/app/template/images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="/app/template/images/ico/apple-touch-icon-57-precomposed.png">
</head><!--/head-->

<body>
<header id="header"><!--header-->
    <div class="header_top"><!--header_top-->
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="contactinfo">
                        <ul class="nav nav-pills">
                            <li><a><i class="fa fa-phone"></i> +380 97 407 4714</a></li>
                            <li><a><i class="fa fa-envelope"></i> msichkar1997@gmail.com</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="social-icons pull-right">
                        <ul class="nav navbar-nav">
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/header_top-->

    <div class="header-middle"><!--header-middle-->
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="logo pull-left">
                        <a href="index.html"><img src="/app/template/images/home/logo.png" alt="" /></a>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="shop-menu pull-right">
                        <ul class="nav navbar-nav">
                            <?php use myBookPlans\app\models\User;

if (User::isGuest()) :?>
                                <li><a href="/user/login/"><i class="fa fa-lock"></i> Вход</a></li>
                                <li><a href="/user/register/"><i class="fa fa-lock"></i> Регистрация</a></li>
                            <?php else :?>
                                <li><a href="/cabinet/"><i class="fa fa-user"></i> Аккаунт</a></li>
                                <li><a href="/user/logout"><i class="fa fa-unlock"></i> Выход</a></li>
                            <?php endif;?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/header-middle-->

    <div class="header-bottom"><!--header-bottom-->
        <div class="container">
            <div class="row">
                <div class="col-sm-10"></div>
            </div>
        </div>
    </div><!--/header-bottom-->

</header><!--/header-->
