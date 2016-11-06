<?php
require_once "inc/header.php";

if (isset($_GET['truncate'])) {
    $guestbook->truncateEntries();
    header("Location: index.php");
    die();
}

if (isset($_POST['message']) && isset($_SESSION['username'])) {
    $guestbook->createEntry($_SESSION['username'], $_POST['message']);
}
?>

    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <h1>XSS Demo</h1>
                <p class="lead">
                    Dies ist eine XSS Demo, bitte geben Sie <strong>keine</strong> vertraulichen Daten ein!
                </p>
            </div>
        </div>

        <?php
        foreach ($guestbook->getEntries() as $entry) {
            ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <h4 class="card-header">
                            <img src="img/<?= $guestbook->getAvatar($entry['username']) ?>.jpg" alt="avatar"
                                 class="rounded-circle">
                            Eintrag von <?= $guestbook->sanitizeString($entry['username']) ?> am <?= $entry['time'] ?>
                        </h4>
                        <div class="card-block">
                            <p class="card-text">
                                <?= $guestbook->sanitizeString($entry['message']) ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>


        <?php
        if (isset($_SESSION['username'])) {
            ?>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <h2>Neuer Eintrag</h2>

                    <form method="post">
                        <div class="form-group">
                            <label for="message">Eintrag:</label>
                            <textarea type="text" class="form-control" id="message" name="message" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Absenden</button>
                    </form>
                </div>
            </div>
            <?php
        }
        ?>

    </div>

<?php
require_once "inc/footer.php";
?>