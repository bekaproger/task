<div class="container">
    <div class="row justify-content-md-center">
        <form action="/login" method="POST">
            <p>Email:</p>
            <input type="text" name="email">

            <?php
            if (request()->validationErrors()['email']) {
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
            <a href="/register">
                Register
            </a>
        <a href="/" style="margin-left: 10px;">
            Tasks
        </a>
    </div>
</div>
<? include 'layout.php'?>




