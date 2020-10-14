<?php
include "functions.php";

$pagetitle = "Neues Profil";
include "header.php";

?>
<div id="formflex">
    <form method="post"
          action="register.php">
        <p>Vorname:</p>
        <input type="text" name="vorname">
        <p>Nachname:</p>
        <input type="text" name="nachname">
        <p>Geburtsdatum:</p>
        <input type="date" name="geburtsdatum">
        <p>Geschlecht:</p>
        <select name="geschlecht">
            <option value="weiblich">weiblich</option>
            <option value="männlich">männlich</option>
            <option value="andere">andere</option>
        </select>
        <p>Trainingsgrad:</p>
        <select name="trainingsgrad">
            <option value="Anfänger">Anfänger</option>
            <option value="Fortgeschritten">Fortgeschrittener</option>
            <option value="Profi">Profi</option>
        </select>
        <p>Info:</p>
        <textarea name="info" rows="7"></textarea>
        <p>Email:</p>
        <input name="email">
        <p>Passwort:</p>
        <input type="password" name="passwort" minlength="6">
        <p>Passwort wiederholen:</p>
        <input type="password" name="passwort1" minlength="6">
        <br>
        <br>
        <input type="submit" value="Registrieren" name="submit"/>
    </form>
</div>

<?php

function valid_email($email) {
    return !!filter_var($email, FILTER_VALIDATE_EMAIL);
}
//array for error-messages
$errormsgs = array();
if(isset($_POST['submit'])) {
//check if every field is filled out
    if (!empty($_POST['vorname']) && !empty($_POST['nachname']) && !empty($_POST['geburtsdatum'])
        && !empty($_POST['geschlecht']) && !empty($_POST['email']) && !empty($_POST['passwort']) && !empty($_POST['trainingsgrad'])) {

        $email = $_POST['email'];
        //check if email is valid
        if(valid_email($email)) {
            //check if email already exists in database

            $sth = $dbh->prepare(
                "SELECT COUNT(*) FROM users WHERE email = ?"
            );
            $sth->execute(array($email));
            $count = $sth->fetchColumn();

            //email does not exist in database
            if ($count == 0) {
                if($_POST['passwort'] == $_POST['passwort1']) {
                    $password = password_hash(htmlspecialchars($_POST['passwort']), PASSWORD_DEFAULT);

                $sth = $dbh->prepare(
                    "INSERT INTO users (vorname, nachname, geburtsdatum, geschlecht, email, passwort, trainingsgrad, info) VALUES (?,?,?,?,?,?,?,?)");

                $update_went_ok = $sth->execute(
                    array(
                       $_POST['vorname'],
                        $_POST['nachname'],
                        $_POST['geburtsdatum'],
                        $_POST['geschlecht'],
                        $_POST['email'],
                        $password,
                        $_POST['trainingsgrad'],
                        $_POST['info']
                    )
                );
                header("Location: loginregister.php");
                exit;
                }
                else{
                    $errormsgs[] = "<p class=\"error\"> Passwort stimmt nicht überein! </p>";
                }
            } else {
                $errormsgs[] = "<p class=\"error\"> E-mail Adresse wird bereits verwendet! </p>";
            }
        }
        else{
            $errormsgs[] = "<p class=\"error\"> Ungültige E-Mail Adresse. </p>";
        }
    } else {
        $errormsgs[] = "<p class=\"error\">Bitte alle Felder ausfüllen! </p>";
    }
}

//display errors
if(!empty($errormsgs)){

    foreach ($errormsgs as $error){
        echo $error;
    }
}

?>

<?php

include "footer.php";
?>