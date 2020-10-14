<?php
include "functions.php";
$email = $_SESSION['username'];

$sth = $dbh->prepare("SELECT * FROM users WHERE email=?");
$sth->execute(array($email));
$user = $sth->fetch();


$uploaddir = dirname( $_SERVER["SCRIPT_FILENAME"] ) . "/img/";

$filename = basename($_FILES['bild']['name']);
$ext = substr($filename, -4);

if( $ext != '.jpg' && $ext != '.png' && $ext != '.gif') {
    $pagetitle = "Upload fehlgeschlagen!";
    include "header.php";
    ?>
<p>Dateien müssen das Format jpg, png oder gif haben. </p>

<?php
    include "footer.php";
}
else {

    $uploadfile = $uploaddir . $filename;

    if (move_uploaded_file($_FILES['bild']['tmp_name'], $uploadfile)) {
        $sth = $dbh->prepare(
            "UPDATE users SET
profilbild=?
WHERE email=?");

        $update_went_ok = $sth->execute(array($filename,
            $email));
        header("Location: profil.php");
        exit;
    } else {
        echo "Problem beim Speichern der Datei.\n";
    }
}

?>