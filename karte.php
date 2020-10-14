<?php
header("Cache-Controle: no-store");
ini_set('display_errors', true);

$pagetitle = "no pagetitle set";

include "config.php";

if( ! $DB_NAME ) die('please create config.php, define $DB_NAME, $DSN, $DB_USER, $DB_PASS there');

try {
    $dbh = new PDO($DSN, $DB_USER, $DB_PASS);
    $dbh->setAttribute(PDO::ATTR_ERRMODE,            PDO::ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

} catch (Exception $e) {
    die("Problem connecting to database $DB_NAME as $DB_USER: " . $e->getMessage() );
}


$stadtteile = array("Altstadt",
                        "Neustadt",
                        "Mülln",
                        "Riedenburg",
                        "Nonntal",
                       "Maxglan",
                        "Lehen",
                        "Liefering",
                        "Aigen",
                        "Parsch",
                        "Gnigl",
                        "Itzling",
                        "Elisabeth-Vorstadt",
                        "Morzg",
                        "Gneis",
                        "Leopoldskroner Moos",
                        "Salzburg-Süd",
                        "Langwied",
                        "Kasern",
                        "Taxham",
                        "Schallmoos");

$arr = array();
$j = -1;
for($i = 0; $i < count($stadtteile); ++$i){

    $sth = $dbh->prepare("SELECT * FROM users WHERE stadtteil = ? ORDER BY RANDOM() LIMIT 1");
    $sth->execute(array($stadtteile[$i]));
    $user = $sth->fetch();

    $userarr = (array)$user;
    if(!empty($user)) {
        $j++;
        $st = $user->stadtteil;
        if($st == "Mülln"){
            $stadt = "muelln";
        }
        elseif($st == "Elisabeth-Vorstadt"){
            $stadt = "elisabethvorstadt";
        }
        elseif($st == "Leopoldskroner Moos"){
            $stadt = "leopoldskronermoos";
        }
        elseif($st == "Salzburg-Süd"){
            $stadt = "salzburgsued";
        }
        else{
            $stadt = strtolower($st);
        }

        $tg = $user->trainingsgrad;
        if($tg == "Anfänger"){
            $training = "anfaenger";
        }
        else{
            $training = strtolower($tg);
        }
        $id = $user->id;

        $arr[$j] = array(
            $stadt,
            $training,
            $id
        );
    }
}


?>

<script>
    var a = <?php echo json_encode($arr); ?>;

</script>
