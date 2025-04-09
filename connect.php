<?php
/* Local Database*/

$servername = "localhost";
$username = "pesf5772_baso";
$password = "Basosangirang123";
$dbname = "pesf5772_puskesmastanahtoa";


// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}



?> 