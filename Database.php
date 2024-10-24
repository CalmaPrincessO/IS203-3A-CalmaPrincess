<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'dbc1';

$connection = mysqli_connect($host, $user, $password, $database);

if (mysqli_connect_error()) {
    echo "Error: Unable to connect to MSQL <br> ";
    echo "Message: " .mysqli_connect_error(). "<br>";
}
     // to check connection 
    //else 
        //echo "Sucessfully Connected to your Database"
    //

?>