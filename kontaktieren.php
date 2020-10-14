<?php
include "functions.php";
$pagetitle = "Buddy kontaktieren";
include "header.php";
 $email = $_POST['email'];
?>
<div id="kontakt">
<form method="post" action="kontaktieren.php">
 <textarea name="txtarea" maxlength="1000">
 </textarea>
    <input type="hidden" value="<?php echo $email ?>" name="email"/>
 <input type="submit" value="E-Mail senden" name="senden" />
</form>
</div>

<?php

if(isset($_POST['senden']) && !empty($_POST['txtarea'])) {
    $to = $_POST['email'];

    $subject = "LaufBuddy - Passender Buddy gefunden";
    $absender = "\r\nAbsender: " . $_SESSION['username'];
    $txt = htmlspecialchars($_POST['txtarea']) . $absender;


    mail("$to", "$subject", "$txt");
}
elseif (isset($_POST['senden']) && empty($_POST['txtarea'])){
    ?>
    <P>Bitte schreib eine Nachricht!</p>
<?php
}

include "footer.php";
?>