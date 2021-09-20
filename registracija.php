<?php

//session_start();
include("connection.php");
include("functions.php");

?>


<!DOCTYPE html>
<html lang="sl" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Reservations</title>
  <link rel="stylesheet" href="index.css">
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
    <div class="form-box">
      <div class="button-box">
        <div id="btn">
        </div>
        <div style="text-align: center">
          <a href="prijava.php"><button style="margin: 10px; border-radius:26px" type="button" class="toggle-btn"><span></span>Sign in</button></a>
        </div>
      </div>
      <form id="register" class="input-group" method="post" action="functions.php">
        <div style="text-align: center" class="form-group w-100">
          <label for="username" style="color:white">Username:</label>
          <input id="username" type="text" class="form-control input-field w-100" placeholder="Username" name="username" required>
        </div>
        <div style="text-align: center" class="form-group w-100">
          <label for="password" style="color:white">Email:</label>
          <input id="password" type="email" class="form-control input-field w-100" placeholder="Email" name="email" required>
        </div>
        <div style="text-align: center" class="form-group w-100">
          <label for="password" style="color:white">Password:</label>
          <input id="password" type="password" class="form-control input-field w-100" placeholder="Password" name="pass" required>
        </div>
        <div style="text-align: center; width:100%">
          <button style="margin: 10px; border-radius:26px" type="submit" class="submit-btn" name="registriraj"><span></span>Register me now!</button>
        </div>
      </form>
    </div>
  </div>

</body>

</html>
