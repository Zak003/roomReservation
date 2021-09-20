
<a href="index.php"><img src="pictures/EBlogo.png" class="logo"></a>
<ul><?php
    if (isset($_SESSION["prijavljen"])) {
    ?>
        <li><p style="color: #009688"><?php echo $_SESSION["username"]; if($_SESSION["admin"] == 1){ echo " (Admin)";}?></p></li>
        <li><a href="index2.php">Home</a></li>
        <li><a href="rezervacija.php">Reservation</a></li>
        <li><a href="vserezervacije.php">All reservations</a></li>
        <li><a href="logout.php">Log out</a></li>
        <?php
                                            } else {
                                                ?>
        <li><a href="index.php">Home</a></li>
        <li> <a href="prijava.php">Login</a></li>
        <li><a href="vserezervacije.php">All reservations</a></li>
        <?php }?>
</ul>
