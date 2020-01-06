<div class="container">
    <div class="row justify-content-md-center">
        <form action="/register" method="POST">
            <p>Name:</p>
            <input type="text" name="name">
            <?php
            if (isset(request()->validationErrors()['name'])) {
                ?>

                <p><?= request()->validationErrors()['name'] ?></p>

                <?php
            }
            ?>
            <p>Email:</p>
            <input type="email" name="email">
            <?php
            if (isset(request()->validationErrors()['email'])) {
                ?>

                <p><?= request()->validationErrors()['email'] ?></p>

                <?php
            }
            ?>
            <p>Password:</p>
            <input type="password" name="password">
            <?php
            if (isset(request()->validationErrors()['password'])) {
                ?>

                <p><?= request()->validationErrors()['password'] ?></p>

                <?php
            }
            ?>
            <div>
                <input type="submit">
            </div>
        </form>
    </div>
    <div class="row justify-content-md-center">
        <a href="/login">
            Login
        </a>
    </div>

<? include 'layout.php'?>




