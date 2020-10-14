<?php

include "functions.php";
$pagetitle = "Buddysuche";
include "header.php";

$email = $_SESSION['username'];
$sth = $dbh->prepare("SELECT * FROM users WHERE email = ?");
$sth->execute(array($email));
$user = $sth->fetch();

//date has to match buddy date
$datum = htmlspecialchars($user->datum);

//time has to match buddy time
$uhrzeit = htmlspecialchars($user->uhrzeit);

//km have to match buddy kilometer
$km = $user->km;

//stadtteil has to match buddy stadtteil
$stadtteil = htmlspecialchars($user->stadtteil);

//age has to match preferred age of buddy = bevalter
$geburtsdatum = htmlspecialchars($user->geburtsdatum);
$alter = date_diff(date_create($geburtsdatum), date_create('now'))->y;

$bevalter = htmlspecialchars($user->bevalter);

//tg has to match preffered tg of buddy = bevtrainingsgrad
$tg = htmlspecialchars($user->bevtrainingsgrad);
if($tg == "Anfänger"){
    $trainingsgrad = 0;
}
elseif ($tg == "Fortgeschritten"){
    $trainingsgrad = 1;
}
else{
    $trainingsgrad = 2;
}



$sth = $dbh->prepare("SELECT * FROM users WHERE email != ?");
$sth->execute(array($email));
$buddies = $sth->fetchAll();

$arr = array();

$i = -1;
    foreach ($buddies as $buddy) {
        ++$i;
        $id = htmlspecialchars($buddy->id);
        $bkm = $buddy->km;

        $km_diff = abs($km - $bkm);

        $buhrzeit = htmlspecialchars($buddy->uhrzeit);


        $a = new DateTime($uhrzeit);
        $b = new DateTime($buhrzeit);
        $zeitdiff = $a->diff($b);

        $zeit_diff = $zeitdiff->h;



        $bstadtteil = htmlspecialchars($buddy->stadtteil);
        if($stadtteil == $bstadtteil){
            $st_diff = 0;
        }
        else{
            $st_diff = 2;
        }

        $bgeburtsdatum = htmlspecialchars($buddy->geburtsdatum);

        $balter = date_diff(date_create($bgeburtsdatum), date_create('now'))->y;

        $alter_diff = abs($bevalter - $balter);

        $btg = htmlspecialchars($buddy->trainingsgrad);
        if($btg == "Anfänger"){
            $btrainingsgrad = 0;
        }
        elseif ($btg == "Fortgeschritten"){
            $btrainingsgrad = 1;
        }
        else{
            $btrainingsgrad = 2;
        }

        $tg_diff = abs($trainingsgrad - $btrainingsgrad);

        $metrik = $km_diff + $zeit_diff + $st_diff + $alter_diff + $tg_diff;


        $arr[$i] = array($metrik, htmlspecialchars($buddy->vorname), $id);

}


$j = 0;
asort($arr);
?>

<div class="blink">
<p> &#9734; Das sind deine TOP 3 passenden Buddies: &#9734;</p>
<?php
foreach ($arr as $a){
    $j++;
    if($j < 4){
        ?>
            <a id="blink" href="buddyprofil.php?id=<?php echo $a[2] ?>">  <?php echo $j . ". " . $a[1] ?></a>
            <br>

<?php
    }
}
?>
</div>

<?php


include "footer.php";
?>
