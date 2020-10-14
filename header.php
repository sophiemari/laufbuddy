<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $pagetitle ?></title>
  <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
          integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
          crossorigin=""/>

</head>
<body>
<?php
if(isset($_SESSION['username'])) {
    ?>
    <div class="navigation">
        <nav>
            <div class="burger">
                <div class="burgerLinie"></div>
                <div class="burgerLinie"></div>
                <div class="burgerLinie"></div>
            </div>
        <ul class="menu">
            <a class="w40" href="index.php">
                <li> LaufBuddy </li>
            </a>
            <a class="w20" href="laeufer.php">
                <li> Läufer</li>
            </a>
            <a class="w20" href="profil.php">
                <li> Mein Profil</li>
            </a>
            <li id="logout">
                <form action="logout.php" method="post">
                    <input id="button" type="submit" value="LOGOUT"/>
                </form>
            </li>
        </ul>
    </nav>
    </div>
    <?php
}
else{
?>
<div class="navigation">
    <nav>
        <div class="burger">
            <div class="burgerLinie"></div>
            <div class="burgerLinie"></div>
            <div class="burgerLinie"></div>
        </div>
    <ul class="menu">
      <a class="w40" href="index.php"><li> LaufBuddy </li></a>
      <a class="w20" href="laeufer.php"><li> Läufer</li></a>
      <a class="w20" href="profil.php"><li> Mein Profil</li></a>
        <a class="w20" href="login.php"><li> Login</li></a>
    </ul>
  </nav>
</div>
<?php
}
?>

  <main>
    <h1><?php echo $pagetitle ?></h1>

