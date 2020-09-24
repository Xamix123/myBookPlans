<?php if ($updateBookId): ?>
    <?php header("Location: /library/") ?>;
<?php endif; ?>

<?php include ROOT . '/app/views/layouts/header.php';?>
<section>
    <div class ="container">
        <div class ="row">

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
                                <h4 class="panel-title"><a href="/cabinet/">Личный кабинет</a></h4>
                            </div>
                        </div>
                    </div><!--/menu-->
                </div>
            </div>

            <div  class="col-sm-5 col-sm-offset-2 margin-bottom:auto">

                <h4> Добавить новую книгу</h4>

                <br/>
                <?php if (isset($errors) && is_array($errors)):?>
                    <ul>
                        <?php foreach ($errors as $error) : ?>
                            <li> - <?php echo $error;?></li>
                        <?php endforeach;?>
                    </ul>
                <?php endif;?>

                <div class="login-form">
                    <form action="#" method="post" enctype="multipart/form-data">

                        <p>Название</p>
                        <input type="text" name="title" maxlength="100" placeholder="" value="<?php echo $bookData['title'] ?>">

                        <p>Автор</p>
                        <input type="text" name="author" maxlength="100" placeholder="" value="<?php echo $bookData['author'] ?>">

                        <p>Издательство</p>
                        <input type="text" name="publishingHouse" maxlength="100" placeholder="" value="<?php echo $bookData['publishing_house'] ?>">

                        <p>Серия</p>
                        <input type="text" name="series" maxlength="100" placeholder="" value="<?php echo $bookData['series'] ?>">

                        <p>Изображение</p>
                        <div class="view-product">
                            <img src="<?php echo $bookData['img']?>" alt="" />
                        </div>
                        <input type="file" name="image" placeholder="" value="<?php echo $bookData['img'] ?>">

                        <p>Количество страниц</p>
                        <input type="number" name="countPages" min="0" max="999999" placeholder="" value="<?php echo $bookData['count_pages'] ?>">

                        <p>Описание</p>
                        <textarea name="description" rows="10" maxlength="1000" placeholder="<?php echo $bookData['description'] ?>"></textarea>

                        <br/>
                        <br/>

                        <p>Статус</p>
                        <select name="status">
                            <option  value="0"
                                <?php if($bookData['status'] == 0):?>
                                    selected
                                <?php endif; ?>
                            >
                                Не прочитано
                            </option>
                            <option  value="1"
                                <?php if($bookData['status'] == 1):?>
                                   selected
                                <?php endif; ?>
                            >
                                Прочитано
                            </option>
                        </select>

                        <br/>
                        <br/>

                        <input type="submit" name="submit" class="btn btn-default" value="Сохранить"/>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include ROOT . '/app/views/layouts/footer.php'; ?>
