<?php

include("connection.php");
include("functions.php");
//session_start();

if ($_SESSION["prijavljen"] != 1) {
  header('Location: index.php');
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
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>
  <div class="banner">
    <div class="navbar">
      <?php
      include("navbar.php");
      ?>
    </div>
    <div class="form-box">
      <div class="napis">
        <h2>Reservations</h2>
      </div>
      <div class="prostori_dropdown">
        <div class="rezervacija">
         
        </div>
      </div>

      <?php
      //if (isset($_POST["kraj_id"])) {
      ?>
        <form class="reservation" action="functions.php" method="post">
          <p class="prostor" style="color:white">Room:</p>
          <select class="form-control" name="prostor_id" class="prostori_drop">
            <?php
            //$kraj_id = $_POST["kraj_id"];
            $result = mysqli_query($con, "SELECT * FROM rooms");
            while ($row = mysqli_fetch_assoc($result)) {

              $prostor_ime = $row['name'];
              $prostor_id = $row["id"];
              $floor_id = $row["floor_id"];

              echo "<option value='$prostor_id'>$prostor_ime, Floor: $floor_id</option>";
            }
            ?>
          </select>
          <div class="ime">
            <p class="ime_rezervacije" style="color:white">Name of reservation:</p>
            <input required type="text" class="form-control" name="ime"> </input>
          </div>
          <div class="datum">
            <p class="date" style="color:white">Date and time of your reservation:</p>
            <div class="form-group">
              <div style="width: 100%;">
                
                <?php
                //echo $_SESSION["Rez"];
                if(isset($_POST["day"])){
                  $dayRez=date("Y-m-d", intval($_POST["day"]));
                  $timeRez=$_POST["timeRez"];
                  $Rez = $dayRez."T".$timeRez;
                  $_SESSION["Rez"] = $Rez;
                }
                if(isset($_SESSION["Rez"])){
                  $Rez = $_SESSION["Rez"];
                }
                $mindate=date("Y-m-d");
                $mintime=date("h:m");
                $min=$mindate."T".$mintime;
                ?>
                <input required style="width: 100%; margin: auto; text-align: center" name="datum" class="form-control" type="datetime-local" id="example-date-input" value="<?php echo "$Rez"?>" min="<?php echo "$min"?>">

          </div>
          </div>
<!-- -------------------------------------------------------------- -->
          <div class="datum">
            <p class="date" style="color:white">Select end time of your reservation:</p>
            <div class="form-group">
              <div style="width: 100%;">
                <input required style="width: 100%; margin: auto; text-align: center" name="cas" class="form-control"  type="datetime-local" id="example-time-input" value="<?php echo "$Rez"?>" min="<?php echo "$Rez"?>">
          
          </div>
          </div>
<!-- -------------------------------------------------------------- -->
          <div style="margin-top: 25px" class="col text-center">
            <?php
              $datum = filter_input(INPUT_POST, 'datum');
              $cas = filter_input(INPUT_POST, 'cas'); 

              //if (zacetni datum > vneseni datum > koncni datum) {
            ?>
              <button style="border-radius:26px" type="submit" class="submit-btn" name="rezerviraj">Reserve now!</button>

          </div>
        </form>
      <?php //} ?>

    </div>
  </div>
  </div>
  <script src="i_js/jquery.min.js"></script>
  <script src="i_js/popper.js"></script>
  <script src="i_js/bootstrap.min.js"></script>
  <script src="i_js/moment-with-locales.min.js"></script>
  <script src="i_js/bootstrap-datetimepicker.min.js"></script>
  <script src="i_js/main.js"></script>


</body>

</html>
