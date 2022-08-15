<?php
    include "coa123mysqlconnect.php";
    
    $venueid = $_REQUEST["venue_id"];
    $grade = $_REQUEST["catering_grade"];

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query = "SELECT cost FROM catering WHERE venue_id = $venueid AND grade = $grade;";

    $result = mysqli_query($conn, $query); 
    $allDataArray = array();
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $allDataArray[] = $row;
    }
    echo json_encode($allDataArray);
    
?>