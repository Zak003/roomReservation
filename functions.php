<?php
session_start();
include("connection.php");

function check_login($con)
{

  if (isset($_SESSION['username'])) {

    $username = $_SESSION['username'];
    $query = "select * from users where username = '$username' limit 1";

    $result = mysqli_query($con, $query);
    if ($result && mysqli_num_rows($result) > 0) {

      $user_data = mysqli_fetch_assoc($result);
      return $user_data;
    }
  }
}

if (isset($_POST["prijava"]) && isset($_SESSION["prijavljen"]) != 1) {
  $uname = filter_input(INPUT_POST, 'username');
  $pass = filter_input(INPUT_POST, 'pass');
  $sql = "SELECT * FROM users";
  $result = mysqli_query($con, $sql);
  $yes = 0;

  while ($row = mysqli_fetch_assoc($result)) {
    //namesto ta druge v if stavku: password_verify($pass, $row["pass"]
    if ($row["username"] == $uname && password_verify($pass, $row["password"])) {

      $_SESSION["username"] = $uname;
      $_SESSION["pass"] = $pass;
      $_SESSION["prijavljen"] = 1;
      $_SESSION["admin"] = $row["admin"];
      $_SESSION["id"] = $row["id"];
      header('Location: index2.php');
      $yes = 1;
      break;
    } else {
      header('Location: prijava.php');
    }
  }
}

if (isset($_POST["registriraj"]) && isset($_SESSION["prijavljen"]) != 1) {
  $uname = filter_input(INPUT_POST, 'username');
  $email = filter_input(INPUT_POST, 'email');
  $pass = filter_input(INPUT_POST, 'pass');

  $passHash = password_hash($pass, PASSWORD_BCRYPT);

  $sql = "INSERT INTO users (username, email, password, admin) VALUES ('$uname', '$email', '$passHash', 0)";
  if (mysqli_query($con, $sql)) {
    //echo "New record created successfully";
    echo "<script>alert('Thank you for registration. Please sign in now.');location.href=\"prijava.php\";</script>";
    //header('Location: prijava.php');
  }else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
}

//Rezervacija

if(isset($_POST["rezerviraj"]) && $_SESSION["prijavljen"] == 1){
  $ime = filter_input(INPUT_POST, 'ime');
  $datum = filter_input(INPUT_POST, 'datum');
  $datum = date('Y-m-d H:i:s', strtotime($datum));
  $cas = filter_input(INPUT_POST, 'cas');
  $cas = date('Y-m-d H:i:s', strtotime($cas));
  $prostor_id = filter_input(INPUT_POST, 'prostor_id');
  $id = $_SESSION["id"];

  
  $sql2="SELECT r.id, r.date, r.end_time AS end_time, r.room_id AS room_id FROM reservations r WHERE (date<='$datum' AND end_time >='$cas') OR (date>='$datum' AND end_time >='$cas') OR (date<='$datum' AND end_time <='$cas') AND (room_id='$prostor_id')";

  $sql3="SELECT * FROM reservations WHERE room_id=$prostor_id";
  $result3= mysqli_query($con, $sql3);

  $rezervacijaObstaja = false;
  while($row=mysqli_fetch_assoc($result3)) //s tem dobimo use termine ki so umes med mojim vnesim datumom!!!!!!!!!!
  {
    if(!$rezervacijaObstaja)
    {
      $startTime = $row['date'];
      $endTime = $row['end_time'];

      $sql4="SELECT * FROM reservations WHERE '$datum' BETWEEN '$startTime' AND '$endTime'";
      
      $result4= mysqli_query($con, $sql4);

    if($row=mysqli_fetch_assoc($result4))$rezervacijaObstaja=true;

      $sql4="SELECT * FROM reservations WHERE '$cas' BETWEEN '$startTime' AND '$endTime'";
      
      $result4= mysqli_query($con, $sql4);

    if($row=mysqli_fetch_assoc($result4))$rezervacijaObstaja=true;
    }
   
  }

  if($rezervacijaObstaja == false)
  {
    $sql = "INSERT INTO reservations (name, date, end_time, room_id, user_id) VALUES ('$ime', '$datum', '$cas', '$prostor_id', '$id')";
    mysqli_query($con, $sql);
    echo "New record created successfully";
    sleep(2);
    header('Location: index2.php');
  }
  else
  {
    echo "<script>alert('This term is pretty busy already. Please select another or choose another room.');location.href=\"rezervacija.php\";</script>";
  }
}

if(isset($_POST["delete"]) && $_SESSION["admin"] == 1){
  $id = $_POST["id"];
  $sql = "DELETE FROM reservations WHERE id = $id";
  mysqli_query($con, $sql);
  header('Location: index2.php');
}
  //}

