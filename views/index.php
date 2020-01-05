<div>
    <p> Hello <? e(auth()->user()->getName()) ?></p>
    <form action="/logout" method="POST">
        <input type="submit" value="logout">
    </form>
</div>

<? include 'layout.php'?>
