<div class="container">
    <div class="row justify-content-md-center">
        <form action="<?= route('tasks.store') ?>" method="POST">
            <p>Task:</p>
            <textarea name="task"></textarea>
            <?php
            if (request()->validationErrors()['task']) {
                ?>
                <p><?= request()->validationErrors()['task'] ?></p>
                <?php
            }
            ?>
            <p>Username : </p>
            <input name="username" type="text">
            <?php
            if (request()->validationErrors()['username']) {
                ?>
                <p><?= request()->validationErrors()['username'] ?></p>
                <?php
            }
            ?>
            <p>Email : </p>
            <input name="email" type="email">
            <?php
            if (request()->validationErrors()['email']) {
                ?>
                <p><?= request()->validationErrors()['email'] ?></p>
                <?php
            }
            ?>
            <div>
                <input type="submit" name="Create">
            </div>
        </form>
    </div>
</div>

<?php include dirname(__DIR__) . '/layout.php'?>


