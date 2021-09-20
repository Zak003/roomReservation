<?php

include("connection.php");
include("functions.php");

if (isset($_SESSION["prijavljen"]) == 1){
  header('Location: index2.php');
}

?>
<!DOCTYPE html>
<html lang="sl" dir="ltr">

<head>

  <meta charset="utf-8">
  <title>Reservations</title>
  <link rel="stylesheet" href="index.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
  <div class="banner">
    <div class="navbar">
      <?php
      include("navbar.php");
      ?>
    </div>
  </div>
  <div class="content">
    <h1>RESERVE YOUR TERMIN</h1>
    <p> Reserve your termin in this building.</p>

    <div class="button">
      <a href="prijava.php">
        <button style="border-radius:26px" type="button"><span></span>Sign in</button>
      </a>

    </div>
  </div>

</body>

</html>
