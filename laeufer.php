<?php
include "functions.php";

//user is logged in
if(isset($_SESSION['username'])) {

    $email = $_SESSION['username'];
    $sth = $dbh->prepare("SELECT * FROM users WHERE email != ? ORDER BY RANDOM() LIMIT 1");
    $sth->execute(array($email));
    $user = $sth->fetch();
    $pagetitle = "Profil von " . htmlspecialchars($user->vorname);
}
//no logged-in user -> sees all profiles
else{
    $sth = $dbh->query("SELECT * FROM users ORDER BY RANDOM() LIMIT 1");
    $user = $sth->fetch();
    $pagetitle = "Profil von " . htmlspecialchars($user->vorname);
}

include "header.php";

?>

<div class="flexProfil">
    <div class="links">
        <div class="profilbild">
            <img src=".\img\<?php echo htmlspecialchars($user->profilbild) ?>">
        </div>

        <p><strong> Trainingsgrad: </strong> <br> <?php echo htmlspecialchars($user->trainingsgrad) ?> </p>
        <p><strong> Alter: </strong>
            <?php


            $date1 = new DateTime(htmlspecialchars($user->geburtsdatum));
            $date2 = new DateTime("now");

            $alter = date_diff($date1, $date2);
            echo $alter->format('%y');

            ?>
        </p>
        <p><strong> Info: </strong> <br> <?php echo htmlspecialchars($user->info) ?> </p>

    </div>
    <div class="rechts">
        <div class="nlauf">
        <?php
        //next run hasn't been posted yet (user only registered)
        if(is_null(htmlspecialchars($user->km))) {
            ?>
            <p>Nächster Lauf: <br>
                Es wurde noch kein Lauf eingetragen!
            </p>
            <?php
        }
        else {
            ?>
            <p>Nächster Lauf: <br>
                Datum: <?php
                $datum = htmlspecialchars($user->datum);
                $d = date('d.m.Y',strtotime($datum));
                echo $d;
                ?> <br>
                Uhrzeit:
                <?php
                $zeit = htmlspecialchars($user->uhrzeit);
                $t = date('H:i',strtotime($zeit));
                echo $t;
                ?> Uhr <br>
                Kilometer: <?php echo htmlspecialchars($user->km) ?> <br>
                Stadtteil: <?php echo htmlspecialchars($user->stadtteil) ?> <br>
                <?php
            if(isset($_SESSION['username'])){
?>
            <form method="post" action="kontaktieren.php">
                <input type="hidden" name="email" value="<?php echo htmlspecialchars($user->email)?>"/>
                <input class="buddys" type="submit" value="kontaktieren" name="kontaktieren"/>
            </form>
        </div>
            <?php
            }
        }
        ?>
    </div>
</div>

<?php

                include "footer.php";
?>
