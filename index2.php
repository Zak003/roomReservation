<?php

include("connection.php");
include("functions.php");
//session_start();

if(!isset($_SESSION["teden"])) $_SESSION["teden"] = 0;

if ($_SESSION["prijavljen"] != 1){
  header('Location: index.php');
}

//prava funkcija
/*function whileSQL($con, $day, $time){
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
}*/

//preizkus s barvami in nekaj spremembami
function whileSQL($con, $day, $time){
  $sql = "SELECT r.id AS id, r.date AS start_time, r.end_time AS end_time, r.name AS reservation_name, ro.name AS room_name, ro.floor_id AS floor_id, ro.id AS room_id, r.room_id AS rezRoom_id FROM reservations r INNER JOIN rooms ro ON ro.id=r.room_id";
  $result = mysqli_query($con, $sql);
  $c = true;
  while($row=mysqli_fetch_assoc($result)){
    $c = false;
    $cas = new DateTime(date("Y-m-d",$day)." $time:00");
    $zacetek = new DateTime($row["start_time"]);
    $konec = new DateTime($row["end_time"]);
    if (($cas > $zacetek) && ($cas <= $konec)){
      if($row['room_id'] == 1)
      {
          echo "<div class='event'>".$row["room_name"]."<div class='overlay_event'>"."<span class='text_overlay'>"."Reserved by: ".$row["reservation_name"]."</span>"."</div>"."</div>";
      }
      else if($row['room_id'] == 3)
      {
        echo "<div class='drugi_event'>".$row["room_name"]."<div class='overlay_event'>"."<span class='text_overlay'>"."Reserved by: ".$row["reservation_name"]."</span>"."</div>"."</div>";
      }
      else if($row['room_id'] == 5)
      {
        echo "<div class='tretji_event'>".$row["room_name"]."<div class='overlay_event'>"."<span class='text_overlay'>"."Reserved by: ".$row["reservation_name"]."</span>"."</div>"."</div>";
      }
      else
      {
        echo "<div class='cetrti_event'>".$row["room_name"]."<div class='overlay_event'>"."<span class='text_overlay'>"."Reserved by: ".$row["reservation_name"]."</span>"."</div>"."</div>";
      }
    }
    else{
      //echo "<a class='dayInWeek' href='rezervacija.php?&day=$day$&timeRez=$time'>&nbsp;</a>";
    }
  }
  if($c){
    //echo "<a class='dayInWeek' href='rezervacija.php?&day=$day$&timeRez=$time'>&nbsp;</a>";
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

      <?php
        $sql="SELECT * FROM rooms";
        $result=mysqli_query($con, $sql);
        while($row = mysqli_fetch_array($result))
        {
          $room_name=$row['name'];
        }
        //echo $room_name;
      ?>
        </div>
      <table class="tabela">
        <tr><td style="border: none">
        <?php
        $sql="SELECT * FROM rooms";
        
        $result=mysqli_query($con, $sql);
        
        while($row = mysqli_fetch_array($result))
        {
          $room_name=$row['name'];
          $room_id=$row['id'];
          $url_slike=$row['slika'];
        ?>
        <div class="container">

        <p class="tekst_slike">  <?php echo $room_name.":"; ?> </p><img src="<?php echo $url_slike; ?>" alt="Avatar" class="image">
                                       
        <div class="overlay">
          <div style="overflow-y: scroll; height:210px;">
          <h3 class="naslov_zasedenosti"> Already used termins: </h3>
          
        <?php
        $sql2="SELECT r.date AS start_time, r.end_time AS end_time FROM reservations r WHERE (room_id=$room_id) AND (r.end_time >= CURRENT_TIMESTAMP()) ORDER BY start_time ASC";
        $result2=mysqli_query($con, $sql2); 
        echo '<ul>';
        while($row2 = mysqli_fetch_array($result2))
            {echo '<li>';
              $start_time=$row2['start_time'];
              $start_time = date('F j, g:i a', strtotime($start_time));
              
              $end_time=$row2['end_time'];
              $end_time = date('F j, g:i a', strtotime($end_time));
              ?>

              <div class="text"><?php echo "- FROM "."<mark>".$start_time."</mark>"." TO "."<mark>".$end_time."</mark>"; ?></div>
            
        <?php echo '</li>'; } echo '</ul>';
          
          //echo '<button class="overlay_button"><a href="rezervacija.php?ajdi_sobe='.$room_id.'" class="overlay_povezava"><p class="text_overlay_button">Book for '.$room_name.'</p></a></button>';
        ?>

      </div>
      <?php echo '<a href="rezervacija.php?ajdi_sobe='.$room_id.'" class="overlay_povezava"><p class="text_overlay">
          <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-link" viewBox="0 0 16 16">
          <path d="M6.354 5.5H4a3 3 0 0 0 0 6h3a3 3 0 0 0 2.83-4H9c-.086 0-.17.01-.25.031A2 2 0 0 1 7 10.5H4a2 2 0 1 1 0-4h1.535c.218-.376.495-.714.82-1z"/>
          <path d="M9 5.5a3 3 0 0 0-2.83 4h1.098A2 2 0 0 1 9 6.5h3a2 2 0 1 1 0 4h-1.535a4.02 4.02 0 0 1-.82 1H12a3 3 0 1 0 0-6H9z"/>
        </svg>
          Book for '.$room_name.'</p></a>';?> 
      </div>
                          
    </div><hr class="crta_pod_sliko"><?php } ?>
                                      
      </td>
      
      
      <td class="table_row"><div class="sticky_row"> <div class="calendar">

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
    $times = array("07:00","07:30","08:00","08:30","09:00", "09:30", "10:00", "10:30", "11:00", "11:30", "12:00", "12:30", "13:00", "13:30", "14:00", "14:30", "15:00", "15:30", "16:00", "16:30", "17:00", "17:30", "18:00", "18:30", "19:00", "19:30", "20:00", "20:30", "21:00");
    
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
            </div></div></td></tr>  </table>
        </div>

    </div>
    <div class="content">
</body>

</html>