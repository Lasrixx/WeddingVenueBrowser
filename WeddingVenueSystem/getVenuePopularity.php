<?php
    include "coa123mysqlconnect.php";
    
    $venueid = $_REQUEST["venueid"];

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query = "SELECT COUNT(venue_id) AS 'count' FROM venue_booking WHERE venue_id = $venueid GROUP BY MONTH(booking_date);";

    $result = mysqli_query($conn, $query); 
    $allDataArray = array();
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $allDataArray[] = $row;
    }
    echo json_encode($allDataArray);
    
?>