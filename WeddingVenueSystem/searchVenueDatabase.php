<?php
    include "coa123mysqlconnect.php";
    
    $name = trim($_REQUEST["name"]);
    $firstdate = $_REQUEST["date1"];
    $seconddate = $_REQUEST["date2"];    
    $minprice = $_REQUEST["minprice"];
    $maxprice = $_REQUEST["maxprice"];
    $mincapacity = $_REQUEST["mincap"];    
    $maxcapacity = $_REQUEST["maxcap"];
    $grade1 = $_REQUEST["grade1"];
    $grade2 = $_REQUEST["grade2"];
    $grade3 = $_REQUEST["grade3"];
    $grade4 = $_REQUEST["grade4"];
    $grade5 = $_REQUEST["grade5"];
    $license1 = $_REQUEST["license1"];
    $license2 = $_REQUEST["license2"];

    $datedifference = date_diff(date_create($firstdate)->modify("-1 day"),date_create($seconddate));
    $daysdifference = $datedifference->format("%a");

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    /*
    Decomposition of database queries:

    Searches for substrings of the name given
    SELECT * FROM `venue` WHERE name LIKE "%hotel%";

    Searches for venues with a weekday/weekend price between the maximum and minimum
    Please note if no max has been checked, it will be set to an arbitrarily large number
    and if no min has been checked, it will be set to 0.
    SELECT * FROM `venue` WHERE (weekend_price >= 2000 AND weekend_price <= 5000) OR (weekday_price >= 2000 AND weekday_price <= 5000); 

    To search by catering grade, there will need to be some manipulation of the input first 
    If the user wants to include that grade the number should be used in the query, if not 0 is used instead (there is no grade 0)
    SELECT DISTINCT venue_id FROM `catering` WHERE grade = 1 OR grade = 2 OR grade = 0 OR grade = 0 OR grade = 0;

    Searches through the database either by a specific date or by a week either side of the selected date
    This will require 2 queries and selecting one of these based on +/- 7 days being ticked or not
    SELECT DISTINCT venue_id FROM venue_booking WHERE venue_id NOT IN(
    SELECT venue_booking.venue_id 
    FROM venue_booking INNER JOIN venue 
    ON venue_booking.venue_id = venue.venue_id 
    WHERE (booking_date = "2022-01-17" AND venue_booking.venue_id = venue.venue_id));

    Search by capacity works the same as searching by price
    SELECT * FROM `venue` WHERE (capacity >= 100 AND capacity <= 1000);

    Search by licensing is simple: check if it is licensed or not, 
    if the user says they do not care whether it is licensed remove this part of the query
    SELECT * FROM `venue` WHERE licensed = 1;
    */

    $query = "SELECT DISTINCT 
                venue.venue_id AS venue_id, venue.name AS name, 
                venue.capacity, venue.weekday_price, 
                venue.weekend_price, venue.licensed 
                FROM (venue INNER JOIN catering ON venue.venue_id = catering.venue_id)
                WHERE venue.name LIKE '%$name%' 
                AND ((weekend_price >= $minprice AND weekend_price <= $maxprice) 
                    OR (weekday_price >= $minprice AND weekday_price <= $maxprice)) 
                AND (capacity >= $mincapacity AND capacity <= $maxcapacity) 
                AND (licensed=$license1 OR licensed=$license2) 
                AND (catering.grade=$grade1 OR catering.grade=$grade2 
                    OR catering.grade=$grade3 OR catering.grade=$grade4 
                    OR catering.grade=$grade5) 
                AND venue.venue_id NOT IN(
                                        SELECT venue_id 
                                        FROM venue_booking 
                                        WHERE booking_date >= '$firstdate' 
                                        AND booking_date <= '$seconddate' 
                                        GROUP BY venue_id 
                                        HAVING COUNT(venue_id) = '$daysdifference');";

//SELECT DISTINCT venue_id FROM venue_booking WHERE venue_id NOT IN (SELECT venue_id FROM venue_booking WHERE booking_date >= "2022-01-17" AND booking_date <= "2022-01-18" GROUP BY venue_id HAVING COUNT(venue_id) = 2);

    $result = mysqli_query($conn, $query); 
    $allDataArray = array();
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $allDataArray[] = $row;
    }
    
    echo json_encode($allDataArray);
    
?>