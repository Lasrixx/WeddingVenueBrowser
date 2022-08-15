<?php
    include "coa123mysqlconnect.php";
    
    $venueid = $_REQUEST["venue_id"];

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query = "SELECT name, capacity, weekend_price, weekday_price, licensed FROM venue WHERE venue_id = $venueid;";

    $result = mysqli_query($conn, $query); 
    $allDataArray = array();
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $allDataArray[] = $row;
    }
    echo json_encode($allDataArray);
    
?>