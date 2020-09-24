<?php include ROOT . '/app/views/layouts/header.php'; ?>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="left-sidebar">
                        <h2>Меню</h2>
                        <div class="panel-group category-products" id="accordian"><!--menu-->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a class="active" href="/library/">Все книги</a></h4>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a href="/library/addBook/">Добавить книгу</a></h4>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a href="/cabinet/">В личный кабинет</a></h4>
                                </div>
                            </div>
                        </div><!--/menu-->
                    </div>
                </div>

                <?php if (empty($books)) : ?>
                    <div class ="col-sm-9 padding-right">
                        <p class="title text-center">В вашей библиотеке нет книг</p>
                    </div>
                <?php else : ?>
                <div class="col-sm-9 padding-right">
                    <div class="features_items"><!--features_items-->
                        <h2 class="title text-center">Ваши Книги</h2>
                        <?php foreach ($books as $book) : ?>
                            <div class="col-sm-4">
                                <div class="product-image-wrapper">
                                    <div class="single-products">
                                        <div class="productinfo text-center">
                                            <img src="<?php echo $book['img']; ?>" alt="" />
                                            <p>
                                                <a href ="/library/book/<?php echo $book['id']; ?>">
                                                    <?php echo $book['title']?>
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        <?php endforeach; ?>
                    </div><!--features_items-->

                        <?php if ($total > $limit) :?>
                            <div>
                                <?php echo $paginator->get() ?>;
                            </div>
                        <?php endif; ?>

                    <?php endif ?>
                </div>
            </div>
        </div>
    </section>
<?php include ROOT . '/app/views/layouts/footer.php'; ?>