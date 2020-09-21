<?php include ROOT . '/app/views/layouts/header.php' ?>
    <section>
        <div class="container">
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
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a href="/library/addBook/">Добавить книгу</a></h4>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a href="/cabinet/">Личный кабинет</a></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if (! empty($book)): ?>
                <div class="col-sm-9 padding-right">
                    <div class="product-details"><!--book-details-->
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="view-product">
                                    <img src="<?php echo $book['img']?>" alt="" />
                                </div>
                            </div>
                            <div class="col-sm-7">
                                <div class="product-information"><!--/book-information-->
                                    <h2><?php echo $book['title']; ?></h2>
                                    <p><b>Автор:</b> <?php echo $book['author'] ?></p>
                                    <p><b>Издательство:</b> <?php echo $book['publishing_house'] ?></p>
                                    <?php if (! empty($book['countPages'])) : ?>
                                        <p><b>Количество Страниц:</b><?php echo $book['countPages'] ?></p>
                                    <?php endif; ?>
                                    <p><b>Статус:</b> <?php echo $book['status'] ?></p>

                                </div><!--/book-information-->
                                <div class="col-lg-offset-2">
                                    <a href="/library/update/<?php echo $book['id']; ?>"
                                       class="btn btn-default add-to-cart">Редактировать книгу
                                    </a>

                                    <a href="/library/delete/<?php echo $book['id']; ?>"
                                       class="btn btn-default add-to-cart">Удалить книгу
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <h5>Описание Книги</h5>
                                <?php if (! empty($book['description'])) : ?>
                                    <?php echo $book['description']; ?>
                                <?php else : ?>
                                    <p>Без описания</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div><!--/book-details-->
                <?php else: ?>
                    <img src="/app/template/images/404/404.png" alt="" />
                <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
<?php include ROOT . '/app/views/layouts/footer.php' ?>