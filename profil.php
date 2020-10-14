<?php
    include "functions.php";
    if(isset($_SESSION['username']) AND !empty($_SESSION['username'])) {
        $email = htmlspecialchars($_SESSION['username']);

        $sth = $dbh->prepare("SELECT * FROM users WHERE email=?");
        $sth->execute(array($email));
        $user = $sth->fetch();
        $pagetitle = "Profil von " . htmlspecialchars($user->vorname);

        include "header.php";
        ?>

        <div class="flexProfil">
            <div class="links">
                <div class="profilbild">
                    <img src=".\img\<?php echo htmlspecialchars($user->profilbild) ?>">
                </div>
                <?php
                //logged in user views his profile -> can change profile picture
                if($_SESSION['username'] == $email) {
                    ?>
                    <form action="upload.php" method="post" enctype="multipart/form-data">
                        <p id="bla">Profilbild ändern:</p>
                        <input type="file" name="bild">
                        <input  type="submit" value="hochladen">
                    </form>
                    <?php
                }
                //information everyone can see
                ?>
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
                <?php
                if($_SESSION['username'] == $email){
                    ?>
                    <div id="twobuttons">
                    <form method="post" action="profil-bearbeiten.php">
                        <input type="submit" value="Daten bearbeiten" name="submit"/>
                    </form>
                    <form method="post" action="profil-loeschen.php">
                        <input type="submit" value="Profil löschen" name="submit"/>
                    </form>
                    </div>
                    <?php
                }
                ?>
            </div>
            <div class="rechts">
                <div class="nlauf">
                <?php
                //next run hasn't been posted yet (user only registered)
                if(is_null($user->km)) {
                    ?>
                    <p>Nächster Lauf: <br>
                        Es wurde noch kein Lauf eingetragen!
                    </p>
                </div>
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
                    </p>

                    <form method="post" action="buddysuchen.php">
                        <input class="buddys" type="submit" value="nach Buddy suchen" name="bsuche"/>
                    </form>
            </div>
                    <?php
                }
            if($_SESSION['username'] == $email) {
                ?>
                <p id="newlauf"> <strong>Neuer Lauf:</strong></p>
                <form method="post"
                      action="laufdaten.php">
                    <p>Wie weit möchtest du laufen? (km)</p>
                    <input type="number" name="km" min="1" max="100" required>
                    <p>Wann möchtest du laufen gehen?</p>
                    <p>Datum:</p>
                    <input type="date" name="datum" required>
                    <p>Uhrzeit:</p>
                    <input type="time" name="zeit" required>
                    <p>Bevorzugter Trainingspartner</p>
                    <p>Geschlecht:</p>
                    <select name="bevgeschlecht">
                        <option value="weiblich">weiblich</option>
                        <option value="männlich">männlich</option>
                        <option value="andere">andere</option>
                    </select>
                    <p>Trainingsgrad:</p>
                    <select name="bevtrainingsgrad">
                        <option value="Anfänger">Anfänger</option>
                        <option value="Fortgeschritten">Fortgeschrittener</option>
                        <option value="Profi">Profi</option>
                    </select>
                    <p>Alter:</p>
                    <input type="number" name="bevalter" min="18"required>
                    <p>In welchem Stadtteil möchtest du loslaufen?</p>
                    <select name="stadtteil">
                        <option value="Altstadt">Altstadt</option>
                        <option value="Neustadt">Neustadt</option>
                        <option value="Mülln">Mülln</option>
                        <option value="Riedenburg">Riedenburg</option>
                        <option value="Nonntal">Nonntal</option>
                        <option value="Maxglan">Maxglan</option>
                        <option value="Lehen">Lehen</option>
                        <option value="Liefering">Liefering</option>
                        <option value="Aigen">Aigen</option>
                        <option value="Parsch">Parsch</option>
                        <option value="Gnigl">Gnigl</option>
                        <option value="Itzling">Itzling</option>
                        <option value="Elisabeth-Vorstadt">Elisabeth-Vorstadt</option>
                        <option value="Morzg">Morzg</option>
                        <option value="Gneis">Gneis</option>
                        <option value="Leopoldskroner Moos">Leopoldskroner Moos</option>
                        <option value="Salzburg-Süd">Salzburg-Süd</option>
                        <option value="Langwied">Langwied</option>
                        <option value="Kasern">Kasern</option>
                        <option value="Taxham">Taxham</option>
                        <option value="Schallmoos">Schallmoos</option>
                    </select>
                    <input type="hidden" value="<?php echo htmlspecialchars($user->id) ?>" name="id"/>
                    <br>
                    <br>
                    <input type="submit" value="Speichern" name="submit"/>
                </form>
                <?php
            }
            else{
                ?>
                <p>Nächster Lauf: <br>

                </p>

                <?php
            }
            ?>
            </div>
        <?php
        include "footer.php";
    }
    else{
        //user not logged in
        $pagetitle = "Dein Profil";
        include "header.php";
        ?>

<p id="nologin" > Um dein Profil sehen zu können, musst du dich <a href="login.php">einloggen</a> oder <a href="register.php">registrieren</a>! </p>

<?php
        include "footer.php";
    }
?>