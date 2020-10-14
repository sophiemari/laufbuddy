<?php
include "functions.php";

$pagetitle = "Profil bearbeiten";
include "header.php";

$email = $_SESSION['username'];
$sth = $dbh->prepare("SELECT * FROM users WHERE email=?");
$sth->execute(array($email));
$user = $sth->fetch();
?>
<div id="editwrapper">
    <div id="editleft">
<form method="post"
      action="profil-bearbeiten.php">
    <p>Vorname:</p>
    <input type="text" name="vorname" value="<?php echo htmlspecialchars($user->vorname) ?>">
    <p>Nachname:</p>
    <input type="text" name="nachname" value="<?php echo htmlspecialchars($user->nachname) ?>">
    <p>Geburtsdatum:</p>
    <input type="date" name="geburtsdatum" value="<?php echo htmlspecialchars($user->geburtsdatum) ?>">
    <p>Geschlecht:</p>
    <select name="geschlecht" value="<?php echo htmlspecialchars($user->geschlecht) ?>">
        <option value="weiblich">weiblich</option>
        <option value="männlich">männlich</option>
        <option value="andere">andere</option>
    </select>
    <p>Trainingsgrad:</p>
    <select name="trainingsgrad" value="<?php echo htmlspecialchars($user->trainingsgrad) ?>">
        <option value="Anfänger">Anfänger</option>
        <option value="Fortgeschritten">Fortgeschrittener</option>
        <option value="Profi">Profi</option>
    </select>
    <p>Info:</p>
    <textarea name="info" rows="7" ><?php echo htmlspecialchars($user->info) ?></textarea>

    <p>Neues Passwort:</p>
    <input type="password" name="passwort1" minlength="6">
    <p>Neues Passwort bestätigen:</p>
    <input type="password" name="passwort2" minlength="6">
    <br>
    <br>
    <input type="submit" value="Speichern" name="submit"/>
</form>
    </div>

<?php
//array for error-messages
$errormsgs = array();
if(isset($_POST['submit'])) {
    $email = $_SESSION['username'];
    $sth = $dbh->prepare("SELECT * FROM users WHERE email=?");
    $sth->execute(array($email));
    $user = $sth->fetch();


//check if every field is filled out
    if (!empty($_POST['vorname']) && !empty($_POST['nachname']) && !empty($_POST['geburtsdatum'])
        && !empty($_POST['geschlecht']) && !empty($_POST['trainingsgrad'])) {

        //password was not changed
        if(empty(htmlentities($_POST['passwort1']))){
            $password = $user->passwort;

            $sth = $dbh->prepare(
                "UPDATE users SET vorname = ?, nachname = ?, geburtsdatum = ?, geschlecht = ?, passwort = ?, trainingsgrad = ?, info = ? WHERE email= ?");

            $update_went_ok = $sth->execute(
                array(
                    $_POST['vorname'],
                    $_POST['nachname'],
                    $_POST['geburtsdatum'],
                    $_POST['geschlecht'],
                    $password,
                    $_POST['trainingsgrad'],
                    $_POST['info'],
                    $email
                )
            );
            header("Location: profil.php");
            exit;
        }
        else {
            if ($_POST['passwort1'] != $_POST['passwort2']) {
                $errormsgs[] = "<p>Passwort stimmt nicht überein! </p>";
                $password = $user->passwort;

                $sth = $dbh->prepare(
                    "UPDATE users SET vorname = ?, nachname = ?, geburtsdatum = ?, geschlecht = ?, passwort = ?, trainingsgrad = ?, info = ? WHERE email= ?");

                $update_went_ok = $sth->execute(
                    array(
                        $_POST['vorname'],
                        $_POST['nachname'],
                        $_POST['geburtsdatum'],
                        $_POST['geschlecht'],
                        $password,
                        $_POST['trainingsgrad'],
                        $_POST['info'],
                        $email
                    )
                );
                header("Location: profil.php");
                exit;
            } else {
                $password = password_hash(htmlentities($_POST['passwort1']), PASSWORD_DEFAULT);

                $sth = $dbh->prepare(
                    "UPDATE users SET vorname = ?, nachname = ?, geburtsdatum = ?, geschlecht = ?, passwort = ?, trainingsgrad = ?, info = ? WHERE email= ?");

                $update_went_ok = $sth->execute(
                    array(
                        $_POST['vorname'],
                        $_POST['nachname'],
                        $_POST['geburtsdatum'],
                        $_POST['geschlecht'],
                        $password,
                        $_POST['trainingsgrad'],
                        $_POST['info'],
                        $email
                    )
                );
                header("Location: profil.php");
                exit;
            }

        }
    } else {
        $errormsgs[] =  "<p>Bitte füllen Sie alle Felder aus! </p>";
    }
}
//display errors
if(!empty($errormsgs)){
?>

        <?php
        foreach ($errormsgs as $error){
            echo $error;
        }?>
</div>
<?php
}
else{
    header("Location: profil.php");
    exit;
}
?>



<?php

include "footer.php";
?>
