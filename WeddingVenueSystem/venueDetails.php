<!DOCTYPE html>
<html>
    <head>
        <title>
            Wedding Venue Coursework
        </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="VenueDetailsStyles.css" rel="stylesheet">
        <link href="navbarStyles.css" rel="stylesheet">
        <script src="calendarValidation.js"></script>

        <!--
        Fonts
        -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital@1&display=swap" rel="stylesheet">

        <!--
        importing Bootstrap
        -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Chart.js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

        <!-- Dynamically loading the page -->
        <?php
            $venueid = $_REQUEST["venue_id"];
        ?>
        <script>
            <?php 
                echo "let venueID = '$venueid';";
            ?>
            $(document).ready(function() {
                $.ajax({
                    url: "getVenueDetails.php",
                    type: "GET",
                    data: {venue_id:venueID},
                    success: function (responseData) {
                        let venueName = responseData[0].name;
                        let capacity = responseData[0].capacity;
                        let licensed = responseData[0].licensed;

                        document.getElementById("venue-title").innerHTML = venueName;
                        document.getElementById("capacity-text").innerHTML = capacity;
                        document.getElementById("guests").max = capacity;
                        if (licensed == 0){
                            document.getElementById("licensing-text").innerHTML = "No";
                        }
                        else if (licensed == 1){
                            document.getElementById("licensing-text").innerHTML = "Yes";
                        }

                        $.ajax({
                            url: "venuePhotos.php",
                            type: "GET",
                            data: {venuename: venueName},
                            success: function (responseData) {
                                for (let i = 0; i < responseData.length; i++){
                                    document.getElementsByClassName("venue-photo")[i].src = responseData[i];
                                }
                            },
                            error: function (xhr, status, error) {
                                consle.log(xhr.status + ": " + xhr.statusText);
                            },
                            dataType: "json",
                            async: false
                        });
                        $.ajax({
                            url: "venueDescriptions.php",
                            type: "GET",
                            data: {venuename: venueName},
                            success: function (responseData) {
                                document.getElementById("location-text").innerHTML = responseData[0];
                                document.getElementById("description-text-block").innerHTML = responseData[1].substring(1);
                                console.log(responseData[1][0]);
                                document.getElementById("description-text-first-letter").innerHTML = responseData[1][0];
                            },
                            error: function (xhr, status, error) {
                                consle.log(xhr.status + ": " + xhr.statusText);
                            },
                            dataType: "json",
                            async: false
                        });
                    },
                    error: function (xhr, status, error) {
                        console.log(xhr.status + ': ' + xhr.statusText);
                    },
                    dataType: "json",
                    async: false
                });

                $.ajax({
                    url: "getVenueCatering.php",
                    type: "GET",
                    data: {venue_id: venueID},
                    success: function (responseData) {
                        let cateringData = responseData;
                        for (let i = 0; i < responseData.length; i++){
                            let grade = responseData[i].grade;
                            let insertedHtml = "<div>   \
                                        <label for='grade"+grade+"'>Grade "+grade+"</label>    \
                                        <input class='form-check-input grade-radio' name='grade' type='radio' id='grade"+grade+"' value="+grade+" required></div>";
                            document.getElementsByClassName("grade")[i].innerHTML = insertedHtml;
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log(xhr.status + ": " + xhr.statusText);
                    },
                    dataType: "json",
                    async: false
                });
            });

            function calculateTotalPrice(){
                let totalPrice = 0;
                
                if(checkAvailability()){
                    let date = new Date(document.getElementById("date").value);
                    let guestAmount = document.getElementById("guests").value;
                    let cateringGrade = $(".grade-radio:checked").val();

                    const weekdays = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
                    let day = weekdays[date.getDay()];

                    let isWeekend = checkForWeekend(date);
                    let venuePrice = 0;
                    let wePrice = 0;
                    let wdPrice = 0;
                    $.ajax({
                        url: "getVenueDetails.php",
                        type: "GET",
                        data: {venue_id: venueID},
                        success: function (responseData) {
                            wePrice = responseData[0].weekend_price;
                            wdPrice = responseData[0].weekday_price;
                        },
                        error: function (xhr, status, error) {
                            consle.log(xhr.status + ": " + xhr.statusText);
                        },
                        dataType: "json",
                        async: false
                    });

                    if (isWeekend) {
                        venuePrice = wePrice;
                    }
                    else {
                        venuePrice = wdPrice;
                    }
                    totalPrice = parseInt(venuePrice);

                    let cateringCost = 0;
                    $.ajax({
                        url: "getCateringCost.php",
                        type: "GET",
                        data: {venue_id: venueID,
                                catering_grade:cateringGrade},
                        success: function (responseData) {
                            cateringCost = responseData[0].cost;
                        },
                        error: function (xhr, status, error) {
                            consle.log(xhr.status + ": " + xhr.statusText);
                        },
                        dataType: "json",
                        async: false
                    });

                    let totalCateringCost = cateringCost * guestAmount;
                    totalPrice += totalCateringCost;

                    document.getElementById("venue-cost-header").innerHTML = "Price of venue ("+day+")";
                    document.getElementById("venue-cost").innerHTML = '£'+venuePrice;
                    document.getElementById("catering-cost").innerHTML = '£'+totalCateringCost;
                    document.getElementById("total-cost").innerHTML = '£'+totalPrice;
                }
                else{
                    document.getElementById("venue-cost-header").innerHTML = "Price of venue";
                    document.getElementById("venue-cost").innerHTML = "-";
                    document.getElementById("catering-cost").innerHTML = "-";
                    document.getElementById("total-cost").innerHTML = "-";
                }

            }

            function checkForWeekend(date){
                if (date.getDay() == 0 || date.getDay() == 6){
                    return true;
                }
                return false;
            }

            /*
                This function checks the date given by the user against the dates in the database
                Returns an error to the user if the venue is not available on the given date
            */

            function checkAvailability(){
                let date = document.getElementById("date").value;
                let free = true;        
                document.getElementById("date-error").innerHTML = "";
                $.ajax({
                    url: "getVenueAvailability.php",
                    type: "GET",
                    data: {venueid: venueID},
                    success: function (responseData) {
                        for (let i = 0; i < responseData.length; i++){
                            if (responseData[i].booking_date == date){
                                document.getElementById("date-error").innerHTML = "Venue is not available on this date"
                                free = false;
                            }
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log(xhr.status + ": " + xhr.statusText);
                    },
                    dataType: "json",
                    async: false
                });

                return free;

            }
        </script>
    </head>
    <body onload="setDateBoundaries('popularity-date'); setDateBoundaries('date')">
        <nav class="navbar navbar-expand-lg py-3">
            <div class="container-fluid">
                <a class="navbar-brand" href="wedding.php"><img src="CWlogo.png" alt="Logo" style="width:75px;"/></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="venueSearch.php">Our Venues</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Gallery</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link">About Us</a>
                        </li>
                    </ul>
                </div>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link">Contact Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="sign-up">Sign Up to our Newsletter</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <main>
            <div id="venue-details">
                <div class="content">
                    <div id="photo-container">
                        <img src="" alt="photo of venue" class="venue-photo"/>
                        <img src="" alt="photo of venue" class="venue-photo"/>
                        <img src="" alt="photo of venue" class="venue-photo"/>
                        <img src="" alt="photo of venue" class="venue-photo"/>
                        <img src="" alt="photo of venue" class="venue-photo"/>
                        <img src="" alt="photo of venue" class="venue-photo"/>
                    </div>
                    <div id="description">
                        <h1 id="venue-title" class="heading">Venue Name</h1>
                        <br>
                        <div id="summary" style="margin-left: 0%">
                            <div id="location" class="summary-data">
                                <img src="LocationMarker.png" class="summary-icon" alt="location"/>
                                <span id="location-text">Location</span>    
                            </div>
                            <div id="capacity" class="summary-data">
                                <img src="CapacityIcon.png" class="summary-icon" alt="capacity"/>
                                <span id="capacity-text">Cap</span>
                            </div>
                            <div id="licensing" class="summary-data">
                                <span>Licensed:</span>
                                <span id="licensing-text">Yes/No</span>
                            </div>
                        </div>
                        <br>
                        <div id="detailed-description">
                            <p id="description-text" style="font-size:1.25rem"><span id="description-text-first-letter" style="font-size:2.5rem;font-family:'Playfair Display',serif;color:#F689D2;"></span><span id="description-text-block">This is placeholder text. Here, there will be a detailed description for the venue.</span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div id="popularity">
                <div>
                    <h3 class="heading">Venue Popularity</h3> 
                    <div id="popularity-input">
                        <label for="date">Please enter date:</label>
                        <input type="date" name="popularity-date" id="popularity-date" oninput="colourGraph()">
                    </div>
                </div>
                <canvas id="popularity-chart" style="width:100%;max-width:600px"></canvas>
                <script>
                    let xValues = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];

                    let yValues = [];
                    $.ajax({
                        url: "getVenuePopularity.php",
                        type: "GET",
                        data: {venueid: venueID},
                        success: function (responseData) {
                            for (let i = 0; i < responseData.length; i++){
                                yValues.push(responseData[i].count);
                            }
                        },
                        error: function (xhr, status, error) {
                            consle.log(xhr.status + ": " + xhr.statusText);
                        },
                        dataType: "json",
                        async: false
                    });

                    let barColors = "#DFDFDF";

                    let graph = new Chart("popularity-chart", {
                    type: "bar",
                    data: {
                        labels: xValues,
                        datasets: [{
                        backgroundColor: barColors,
                        data: yValues
                        }]
                    },
                    options: {
                        legend: {display: false},
                        title: {
                        display: true,
                        text: "Venue Popularity per Month"
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                    });

                    function colourGraph() {
                        let date = new Date(document.getElementById("popularity-date").value);
                        let month = date.getMonth();
                        let newColours = [];
                        for (let i = 0; i < 12 ; i++) {
                            if (i == month) {
                                newColours.push("#F689D2");
                            }
                            else{
                                newColours.push("#DFDFDF");
                            }
                        }
                        graph.data.datasets[0].backgroundColor = newColours;
                        graph.update();
                    }
                </script>
            </div>
            <div id="booking-section" class="booking">
                <h3 id="booking-heading" class="heading">Enquire now...</h3>
                <div id="enquiry-form">
                    <div>
                        <form id="booking-form" onsubmit="calculateTotalPrice(); return false;">
                            <div id="input-section">
                                <div class="form-input">
                                    <label for="date">Enter date for your wedding:</label>
                                    <input type="date" name="date" id="date" oninput="checkAvailability()" required>
                                    <span id="date-error"></span>
                                </div>
                                <div class="form-input">
                                    <label for="guests">Number of guests:</label>
                                    <input type="number" name="guests" id="guests" min="0" required> 
                                </div>
                                <div>
                                    <span>Catering grade:</span>
                                    <br>
                                    <div id="grade-section">
                                        <div class="grade"></div>
                                        <div class="grade"></div>
                                        <div class="grade"></div>
                                        <div class="grade"></div>
                                        <div class="grade"></div>
                                    </div>
                                </div>
                                <button type="submit" id="price-button" class="button">Get Price</button>
                            </div>
                        </form>
                    </div>
                    <div>
                        <div id="total-price">
                            <h4 class="heading">Price Breakdown</h4>
                            <table id="cost-breakdown">
                                <tr><th id="venue-cost-header" class="table-header">Price of venue</th><td id="venue-cost" class="values">-</td></tr>
                                <tr><th class="table-header">Price of catering</th><td id="catering-cost" class="values">-</td></tr>
                                <tr id="total-row"><th class="table-header">Total Price</th><td id="total-cost" class="values">-</td></tr>
                            </table>
                            <br>
                            <form onsubmit="window.location.href='confirmation.php'; return false;">
                                <label for="email">Email:</label>
                                <input type="email" id="email" name="email" required>
                                <br>
                                <button type="submit" class="button">Enquire now!</button>
                            </form>
                        </div>
                    <div>
                </div>
            </div>
        </main>
    </body>
</html>