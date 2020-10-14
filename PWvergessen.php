<?php
include "functions.php";
$pagetitle = "Passwort vergessen";
include "header.php";

function generateRandomPW($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

?>
<div id="flexPW">
<form method="post"
      action="PWvergessen.php">
    <input name="email" placeholder="E-Mail">

    <input type="submit" value="Neus Passwort" name="newPW"/>
</form>
</div>

<?php



if(isset($_POST['newPW'])) {

    $newPW = generateRandomPW();
    //check if every field is filled out
    if (!empty($_POST['email'])) {

        $email = $_POST['email'];
        //check if emailexists in database

        $sth = $dbh->query(
            "SELECT COUNT(*) AS anzahl FROM users WHERE email = '$email'"
        );
        $count = $sth->fetch();

        //email does exist in database
        if ($count->anzahl != 0) {
            $password = password_hash($newPW, PASSWORD_DEFAULT);
            $sth = $dbh->prepare(
                "UPDATE users SET passwort=?");

            $update_went_ok = $sth->execute(
                array(
                    $password
                )
            );
            $to = $email;
            $subject = "LaufBuddy - Neues Passwort";
            $txt = "Dein neues Passwort lautet: " . $newPW . "\r\nbitte verwende es beim nächsten Login, danach kannst du dein Passwort wieder ändern.\r\n
            Schönen Tag noch,\r\n
            Dein LaufBuddy-Team";


            mail($to, $subject, $txt);

            echo "<p> Dein neues Passwort wurde an die E-mail Adresse versendet! </p>";

        } else {
            echo "<p class=\"error\"> E-mail Adresse existiert nicht! </p>";
        }
    }
    else {
        echo "<p class=\"error\"> Bitte gib deine E-Mail Adresse an! </p>";
    }
}

include "footer.php"
?>