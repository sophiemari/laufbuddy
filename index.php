<?php


    include "functions.php";
    $pagetitle = "LaufBuddy";
    include "header.php";
    $users = $dbh->query("SELECT COUNT(*) AS count FROM users")->fetch()->count;
?>
<div id="flexHome">
<div id="mapHome"></div>
<p><?php echo $users ?> Leute möchten mit dir laufen gehen! <a href="login.php">einloggen</a> oder <a href="register.php">registrieren</a></p>
</div>
<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
        integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
        crossorigin=""></script>
<?php
include "karte.php";
?>
<script src="laufbuddy.js"></script>
<?php
    include "footer.php";
?>
