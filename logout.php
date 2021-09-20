<?php

session_start();
if(isset($_SESSION['username']))
{
    unset($_SESSION['username']);
}
if(isset($_SESSION["prijavljen"])){
    unset($_SESSION["prijavljen"]);
    unset($_SESSION["admin"]);
}

header ( "location:index.php");
