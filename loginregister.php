<?php
include "functions.php";
$pagetitle = "Login";
include "header.php";
?>
<div id="flexlogin">
    <p id="regis">Erfolgreich registriert! Bitte einloggen:</p>
<form action="login.php" method="post">
                <input type = "email" name = "email" placeholder = "E-Mail"> <br>
                <input type = "password" name = "passwort" placeholder = "Passwort"> <br>
                <input type="submit" value="Login" name="submit"/>
                <a href="register.php"><p>registrieren</p></a>
                <a href="PWvergessen.php"><p>Passwort vergessen</p></a>
            </form>
</div>
<?php
if(isset($_POST['submit'])) {
//email and password are empty
//login button was pressed w/o input
    if (isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['passwort']) && !empty($_POST['passwort'])) {
        $email = htmlspecialchars($_POST['email']);


        //check if emailexists in database

        $sth = $dbh->query(
            "SELECT COUNT(*) AS anzahl FROM users WHERE email = '$email'"
        );
        $count = $sth->fetch();

        //email does exist in database
        if ($count->anzahl != 0) {
            $sth = $dbh->prepare("SELECT passwort FROM users WHERE email=?");
            $sth->execute(array($email));
            $user = $sth->fetch();


            $hashed_password = $user->passwort;

            //password and email are correct
            if (password_verify($_POST['passwort'], $hashed_password)) {
                $_SESSION['valid'] = true;
                $_SESSION['username'] = $email;

                header("location: profil.php");
            } else {
                //wrong password or email
                ?>

                <p class="error"> Falsches Passwort oder falsche E-mail Adresse!</p>

                <?php
            }
        }
        else{
            ?>

            <p class="error"> E-Mail Adresse existiert nicht! </p>

            <?php
        }

    } else {
        ?>

        <p class="error"> Bitte E-Mail Adresse und Passwort eingeben! </p>

        <?php
    }
}
    include "footer.php";



?>