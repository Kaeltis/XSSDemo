<?php
require_once "inc/header.php";

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    die();
}

if (isset($_SESSION['username'])) {
    header("Location: index.php");
    die();
}

if (isset($_POST['username']) && isset($_POST['password'])) {
    if ($guestbook->checkUser($_POST['username'], $_POST['password'])) {
        $_SESSION['username'] = $_POST['username'];
        header("Location: index.php");
        die();
    } else {
        die("<h1>Wrong Password!</h1>");
    }
}
?>

    <div class="container">
        <h1>Login</h1>

        <form method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Username">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>

    </div>

<?php
require_once "inc/footer.php";
?>