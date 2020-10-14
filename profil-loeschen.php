<?php
include "functions.php";
$email = $_SESSION['username'];
$sth = $dbh->prepare("DELETE FROM users WHERE email = ?");
$sth->execute(array($email));

$pagetitle = "gelöscht";

include "header.php"
?>
<p>Dein Profil wurde erfolgreich gelöscht! </p>
<?php
include "footer.php";
?>