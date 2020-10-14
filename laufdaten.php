<?php
include "functions.php";
if(isset($_POST['submit'])) {
    $email = $_SESSION['username'];

    $sth = $dbh->prepare("SELECT * FROM users WHERE email=?");
    $sth->execute(array($email));
    $user = $sth->fetch();

        $sth = $dbh->prepare(
            "UPDATE users SET km = ?, datum = ?, uhrzeit= ?, bevgeschlecht = ?,bevalter = ?,bevtrainingsgrad = ?,stadtteil = ? WHERE email= ?");

        $update_went_ok = $sth->execute(
            array(
                $_POST['km'],
                $_POST['datum'],
                $_POST['zeit'],
                $_POST['bevgeschlecht'],
                $_POST['bevalter'],
                $_POST['bevtrainingsgrad'],
                $_POST['stadtteil'],
                $email
            )
        );
        header("Location: profil.php");
        exit;

}

?>
