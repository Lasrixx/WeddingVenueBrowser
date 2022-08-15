<!DOCTYPE html>
<html>
    <head>
        <title>
            Wedding Venue Coursework
        </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="SearchPageStyles.css" rel="stylesheet">
        <link href="navbarStyles.css" rel="stylesheet">
        <script src="slider.js"></script>
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

        <!--
            AJAX and JSON server request/response
        -->
        <script>
        $(document).ready(function() {
            $("#search-button").click(function() {
                
                //Get values from the filter form
                let name = $("#name").val();
                let date = new Date($("#date").val());
                let daterange = $("#incl-date-range").is(":checked");
                let excludeminprice = $("#incl-min-price").is(":checked");
                let minprice = $("#price-min").val();
                let excludemaxprice = $("#incl-max-price").is(":checked");
                let maxprice = $("#price-max").val();
                let excludemincap = $("#incl-min-cap").is(":checked");
                let mincap = $("#cap-min").val();
                let excludemaxcap = $("#incl-max-cap").is(":checked");
                let maxcap = $("#cap-max").is(":checked");
                let grade1 = $("#grade1").is(":checked");
                let grade2 = $("#grade2").is(":checked");
                let grade3 = $("#grade3").is(":checked");
                let grade4 = $("#grade4").is(":checked");
                let grade5 = $("#grade5").is(":checked");
                let licensing = $(".license:checked").val();
                // Manipulate data:
                // If user selects to have a range of dates, take 3 days either side of the supplied date
                // and give them to the php script. If not, set date1 and date2 to the inputted date
                let date1 = new Date(date);
                let date2 = new Date(date);
                if (daterange){
                    date1.setDate(date1.getDate()-3);
                    date2.setDate(date2.getDate()+3);
                }
                date1 = date1.toISOString().slice(0,10);
                date2 = date2.toISOString().slice(0,10);              
                // If user has not manually set price and capacity, set them to extreme numbers
                if (excludeminprice){
                    minprice = 0;
                }
                if (excludemaxprice){
                    maxprice = 100000;
                }
                if (excludemincap){
                    mincap = 0;
                }
                if (excludemaxcap){
                    maxcap = 10000;
                }
                //If user has set licensing to yes, both licensing queries must check for the value 1,
                //If no, then search for 0 twice, if either, then search for 1 and 0 
                let license1 = 1;
                let license2 = 0;
                if (licensing == "yes"){
                    license2 = 1;
                }
                else if (licensing == "no"){
                    license1 = 0;
                }
                //Convert boolean from catering grades to 1-5 (true) and 0 (false)
                if(grade1){
                    grade1 = 1;
                }
                else{
                    grade1 = 0;
                }
                if(grade2){
                    grade2 = 2;
                }
                else{
                    grade2 = 0;
                }
                if(grade3){
                    grade3 = 3;
                }
                else{
                    grade3 = 0;
                }
                if(grade4){
                    grade4 = 4;
                }
                else{
                    grade4 = 0;
                }
                if(grade5){
                    grade5 = 5;
                }
                else{
                    grade5 = 0;
                }
                $.ajax({
                    url: "searchVenueDatabase.php",
                    type: "GET",
                    data: {name:name, 
                        date1:date1,
                        date2:date2, 
                        minprice:minprice, 
                        maxprice:maxprice, 
                        mincap:mincap, 
                        maxcap:maxcap, 
                        grade1:grade1, 
                        grade2:grade2, 
                        grade3:grade3, 
                        grade4:grade4, 
                        grade5:grade5,
                        license1:license1,
                        license2:license2},
                    success: function (responseData) {
                        let len = responseData.length;
                        let insertedHtml = "";
                        for (let i = 0; i < len; i++) {
                            let name = responseData[i].name;
                            let id = responseData[i].venue_id;
                            //Query venuePhotos.php to get the corresponding photo for the wedding venue
                            let photo = "";
                            let description = "";
                            $.ajax({
                                url: "venuePhotos.php",
                                type: "GET",
                                data: {venuename: name},
                                success: function (responseData){
                                    photo = responseData[0];
                                },
                                error: function (xhr, status, error){
                                    console.log(xhr.status + ": " + xhr.statusText);
                                },
                                dataType: "json",
                                async: false
                            });
                            $.ajax({
                                url: "venueSummary.php",
                                type: "GET",
                                data: {venuename: name},
                                success: function (responseData){
                                    description = responseData;
                                },
                                error: function (xhr, status, error){
                                    console.log(xhr.status + ": " + xhr.statusText);
                                },
                                dataType: "json",
                                async: false
                            });
                            insertedHtml += "<div class='col'><div class='card'> \
                                            <img src="+ photo +" class='card-img-top' alt='photo of wedding venue'/> \
                                            <div class='card-body'> \
                                                <h5 class='card-title heading'>"+ name +"</h5>  \
                                                <p class='card-text' style='height:50px;'>"+description+"</p> \
                                                <a href='venueDetails.php?venue_id=" + id + "' class='btn more-details'>More details</a>    \
                                            </div>  \
                                            </div></div>" ;
                        }
                        document.getElementById("search-results").innerHTML = insertedHtml;
                        document.getElementById("search-results").scrollIntoView();
                    },
                    error: function (xhr, status, error) {
                        console.log(xhr.status + ': ' + xhr.statusText);
                    },
                    dataType: "json",
                });
            });
        });
        </script>

    </head>
    <body  onload="updateSliderVal(); setDateBoundaries('date')">
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
            <img class="search-main-image" src="SearchPage.jpg" alt="Couple stand in wedding pavilion"/>
            <h1 class="heading" id="intro-heading">Your dream venue awaits...</h1>
            <div class="form-div" onsubmit="return false;"> <!-- <- Stops page reloading when submit is pressed-->
                <h3 class="heading">Venue search</h3>
                <form class="search-form">
                    <div>
                        <label for="name">Venue Name</label>
                        <input type="text" id="name" name="name">
                    </div>
                    <div class="date-labels">
                        <div>
                            <label for="date">Date</label>
                            <input type="date" id="date" name="date" required>
                            <script>
                                document.getElementById("date").valueAsDate = new Date();
                            </script>
                        </div>
                        <div>
                            <label for="incl-date-range">+/- 3 days</label>
                            <input class="form-check-input" type="checkbox" checked=false id="incl-date-range">
                        </div>
                    </div>
                    <div>
                        <div class="slider-labels">
                            <label for="price-min">Minimum price</label>
                            <div>
                                <label for="incl-min-price">No Min</label>
                                <input class="form-check-input slider-toggle" type="checkbox" checked=true id="incl-min-price" onclick="toggleSlider(0)">
                            </div>
                        </div>
                        <input type="range" id="price-min" class="slider price" name="price-min" min="0" max="5000" onchange="setSliderBounds('price', 0); updateSliderVal()" disabled>
                        <span class="slider-value"></span>
                        <br>
                        <div class="slider-labels">
                            <label for="price-max">Maximum price</label>
                            <div>
                                <label for="incl-max-price">No Max</label>
                                <input class="form-check-input slider-toggle" type="checkbox" checked=true id="incl-max-price" onclick="toggleSlider(1)">
                            </div>
                        </div>
                        <input type="range" id="price-max" class="slider price" name="price-max" min="0" max="5000" onchange="setSliderBounds('price', 1); updateSliderVal()" disabled>
                        <span class="slider-value"></span>
                    </div>
                    <div>
                        <div class="slider-labels">
                            <label for="cap-min">Minimum capacity</label>
                            <div>
                                <label for="incl-min-cap">No Min</label>
                                <input class="form-check-input slider-toggle" type="checkbox" checked=true id="incl-min-cap" onclick="toggleSlider(2)">
                            </div>
                        </div>
                        <input type="range" id="cap-min" class="slider capacity" name="cap-min" min="0" max="1000" onchange="setSliderBounds('capacity', 0); updateSliderVal()" disabled>
                        <span class="slider-value"></span>
                        <br>
                        <div class="slider-labels">
                            <label for="cap-max">Maximum capacity</label>
                            <div>
                                <label for="incl-max-cap">No Max</label>
                                <input class="form-check-input slider-toggle" type="checkbox" checked=true id="incl-max-cap" onclick="toggleSlider(3)">
                            </div>
                        </div>
                        <input type="range" id="cap-max" class="slider capacity" name="cap-max" min="0" max="1000" onchange="setSliderBounds('capacity', 1); updateSliderVal()" disabled>
                        <span class="slider-value"></span>
                    </div>
                    <div>
                        <span>Catering grades</span>
                        <br>
                        <div class="catering-labels">
                            <div>
                                <label for="grade1">Grade 1</label>
                                <input class="form-check-input" type="checkbox" id="grade1" value="1" checked>
                            </div>
                            <div>
                                <label for="grade2">Grade 2</label>
                                <input class="form-check-input" type="checkbox" id="grade2" value="2" checked>
                            </div>
                            <div>
                                <label for="grade3">Grade 3</label>
                                <input class="form-check-input" type="checkbox" id="grade3" value="3" checked>
                            </div>
                            <div>
                                <label for="grade4">Grade 4</label>
                                <input class="form-check-input" type="checkbox" id="grade4" value="4" checked>
                            </div>
                            <div>
                                <label for="grade5">Grade 5</label>
                                <input class="form-check-input" type="checkbox" id="grade5" value="5" checked>
                            </div>
                        </div>
                    </div>
                    <div>
                        <span>Licensing</span>
                        <br>
                        <div class="licensed-labels">
                            <div>
                                <label for="licensed-yes">Yes</label>
                                <input class="form-check-input license" name="licensed" type="radio" id="licensed-yes" value="yes">
                            </div>
                            <div>
                                <label for="licensed-no">No</label>
                                <input class="form-check-input license" name="licensed" type="radio" id="licensed-no" value="no">
                            </div>
                            <div>
                                <label for="licensed-either">Either</label>
                                <input class="form-check-input license" name="licensed" type="radio" id="licensed-either" value="both" checked>
                            </div>
                        </div>
                    </div>
                </form>
                <br>
                <button id="search-button">Apply filters</button>
            </div>
            <div class="venue-display">
                <h2 class="heading" id="search-heading">Search Results</h2>
                <div id="search-results" class="row row-cols-1 row-cols-md-2 g-4">
                </div>
            </div>
        </main>
    </body>
</html>