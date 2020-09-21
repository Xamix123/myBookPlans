<?php include ROOT . '/app/views/layouts/header.php' ?>

    <section>
        <div class="container">
            <div class ="row">

                <div class="col-sm-4 col-sm-offset-4 padding-right">

                    <?php if (isset($errors) && is_array($errors)): ?>
                        <ul>
                            <?php foreach ($errors as $error) :?>
                                <li> -<?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                    <div class="signup-form"> <!-- sign up form -->
                        <h2>Вход на сайт</h2>
                        <form action ="#" method="post">
                            <input type="email" name="email" placeholder="E-mail" value ="<?php echo $data['email']; ?>"/>
                            <input type="password" name="password" placeholder="Пароль" value ="<?php echo $data['password']; ?>"/>
                            <input type="submit" name="submit" class="btn btn-default" value="Вход"/>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

<?php include ROOT . '/app/views/layouts/footer.php' ?>