<?php

$cn = mysqli_connect('localhost', 'root', '', 'inventory_management_system');

if(mysqli_connect_error()){
    echo "Failed to connect to MySQL: " .mysqli_connect_error();
    die();
}

?>