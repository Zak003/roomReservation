<?php

include("connection.php");
include("functions.php");
//session_start();

if(!isset($_SESSION["teden"])) $_SESSION["teden"] = 0;

if ($_SESSION["prijavljen"] != 1){
  header('Location: index.php');
}


function whileSQL($con, $day, $time){
  $sql = "SELECT r.id AS id, r.date AS start_time, r.end_time AS end_time, r.name AS reservation_name, ro.name AS room_name, ro.floor_id AS floor_id FROM reservations r INNER JOIN rooms ro ON ro.id=r.room_id";
  $result = mysqli_query($con, $sql);
  $c = true;
  while($row=mysqli_fetch_assoc($result)){
    $c = false;
    $cas = new DateTime(date("Y-m-d",$day)." $time:00");
    $zacetek = new DateTime($row["start_time"]);
    $konec = new DateTime($row["end_time"]);
    if (($cas >= $zacetek) && ($cas < $konec)){
      echo "<div class='event'>$time – ".date('H:i', strtotime($time)+60*30)." <br>".$row["room_name"]. " - ". "Floor: ". $row["floor_id"]." <br>". "Reserved by: " .$row["reservation_name"]. "</div>";
      //echo $time."  ".$row["name"];
    }
    else{
      echo "<a class='dayInWeek' href='rezervacija.php?&day=$day$&timeRez=$time'>&nbsp;</a>";
    }
  }
  if($c){
    echo "<a class='dayInWeek' href='rezervacija.php?&day=$day$&timeRez=$time'>&nbsp;</a>";
  }
}


?>
<!DOCTYPE html>
<html lang="sl" dir="ltr">

<head>

    <meta charset="utf-8">
    <title>Reservations</title>
    <link rel="stylesheet" href="index.css">

    <link rel="stylesheet" href="calendar.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <div class="banner">
        <div class="navbar">

            <?php
      include("navbar.php");
      ?>
        </div>

        <div class="calendar">

            <header>
                <a href="rezervacija.php"><button class="secondary" style="align-self: flex-start; flex: 0 0 1">Add
                        reservation</button></a>
                <div class="calendar__title" style="display: flex; justify-content: center; align-items: center">
                    <div><a class="icon secondary chevron_left" href="index2.php?date=back">‹</a></div>
                    <?php
        $startOfWeek = date_create(date("y-m-d"));
        $endOfWeek = date_create(date('y-m-d', strtotime('+ 6 days')));
        if(isset($_REQUEST["date"])){
          if ($_REQUEST["date"] == "next"){
            $_SESSION["teden"] += 6;
          }
          else if ($_REQUEST["date"] == "back"){
            if ($_SESSION["teden"] > 0){
              $_SESSION["teden"] -= 6;
            }
          }
        }
        $t = $_SESSION["teden"];
        if ($_SESSION["teden"] != 0){
          date_add($startOfWeek,date_interval_create_from_date_string("$t days"));
          date_add($endOfWeek,date_interval_create_from_date_string("$t days"));
        }
        ?>
                    <h1 class="" style="flex: 1;"><span></span><strong><?php echo date_format($startOfWeek, "d/m") ?> -
                            <?php echo date_format($endOfWeek, "d/m") ?> </strong><?php echo date("Y"); ?></h1>
                    <div><a class="icon secondary chevron_left" href="index2.php?date=next">›</a></div>
                </div>
                <div style="align-self: flex-start; flex: 0 0 1"></div>
            </header>

            <div class="outer">
                <table>
                    <thead>
                        <tr>
                            <th class="headcol"></th>
                            <th class="today"> <?php echo date_format($startOfWeek, "D, j"); ?></th>
                            <th><?php echo date("D, j", strtotime(date_format($startOfWeek, "Y-m-d"). '+1 days')); ?>
                            </th>
                            <th><?php echo date("D, j", strtotime(date_format($startOfWeek, "Y-m-d"). '+2 days')); ?>
                            </th>
                            <th><?php echo date("D, j", strtotime(date_format($startOfWeek, "Y-m-d"). '+3 days')); ?>
                            </th>
                            <th><?php echo date("D, j", strtotime(date_format($startOfWeek, "Y-m-d"). '+4 days')); ?>
                            </th>
                            <th><?php echo date("D, j", strtotime(date_format($startOfWeek, "Y-m-d"). '+5 days')); ?>
                            </th>
                            <th><?php echo date("D, j", strtotime(date_format($startOfWeek, "Y-m-d"). '+6 days')); ?>
                            </th>
                        </tr>
                    </thead>
                </table>

                <div class="wrap">
                    <table class="offset">

                        <tbody>
                            <?php
    $times = array("09:00", "09:30", "10:00", "10:30", "11:00", "11:30", "12:00", "12:30", "13:00", "13:30", "14:00", "14:30", "15:00", "15:30", "16:00", "16:30", "17:00", "17:30", "18:00", "18:30", "19:00", "19:30");
    
    $mon = strtotime(date_format($startOfWeek, "Y-m-d"));
    $tu = strtotime(date_format($startOfWeek, "Y-m-d"). '+1 days');
    $we = strtotime(date_format($startOfWeek, "Y-m-d"). '+2 days');
    $th = strtotime(date_format($startOfWeek, "Y-m-d"). '+3 days');
    $fri = strtotime(date_format($startOfWeek, "Y-m-d"). '+4 days');
    $sat = strtotime(date_format($startOfWeek, "Y-m-d"). '+5 days');
    $sun = strtotime(date_format($startOfWeek, "Y-m-d"). '+6 days');

    foreach ($times as $time) {
      ?>
                            <tr>
                                <td class='headcol'><?php echo $time ?></td>
                                <td>
                                    <?php whileSQL($con, $mon, $time); ?>
                                </td>
                                <td>
                                  <?php whileSQL($con, $tu, $time); ?>
                                </td>
                                <td>
                                  <?php whileSQL($con, $we, $time); ?>
                                </td>
                                <td>
                                  <?php whileSQL($con, $th, $time); ?>
                                </td>
                                <td>
                                  <?php whileSQL($con, $fri, $time); ?>
                                </td>
                                <td>
                                  <?php whileSQL($con, $sat, $time); ?>
                                </td>
                                <td>
                                  <?php whileSQL($con, $sun, $time); ?>
                                </td>
                            </tr>
                            <?php
    }
    ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>
    <div class="content">
</body>

</html>