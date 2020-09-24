<?php include ROOT . '/app/views/layouts/header.php'; ?>

    <section>
        <div class="container">
            <div class="row">

                <h1>Кабинет пользователя</h1>

                <h3>Привет, <?php echo $user['name']; ?>!</h3>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="left-sidebar">
                            <h2>Меню</h2>
                            <div class="panel-group category-products" id="accordian"><!--menu-->
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title"><a href="/library/">Библиотека</a></h4>
                                    </div>
                                </div>
                            </div><!--/menu-->
                        </div>
                    </div>

            </div>
        </div>
    </section>
<?php include ROOT . '/app/views/layouts/footer.php'; ?>