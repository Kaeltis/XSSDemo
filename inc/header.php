<?php
session_start();

require_once "Guestbook.php";
$guestbook = new Guestbook();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <style>
        body {
            padding-top: 5rem;
            padding-bottom: 5rem;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-fixed-top navbar-dark bg-inverse">
    <a class="navbar-brand" href="#">XSS Demo Guestbook</a>
    <ul class="nav navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
        </li>
        <?php
        if (!isset($_SESSION['username'])) {
            ?>
            <li class="nav-item">
                <a class="nav-link" href="login.php">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="register.php">Register</a>
            </li>
            <?php
        }
        ?>
    </ul>
    <?php
    if (isset($_SESSION['username'])) {
        ?>
        <ul class="nav navbar-nav float-xs-right">
            <li class="nav-item">
                <a class="nav-link" href="login.php?logout">Logout</a>
            </li>
        </ul>
        <?php
    }
    ?>
</nav>