<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="navbarStyles.css" rel="stylesheet">
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
<title>
    Wedding Venue Coursework
</title>
<style>
  .intro{
    position: relative;
  }
  .carousel-item{
    background-color: black;
  }
  .carousel-item img{
    opacity: 0.5;
  }
  .intro-caption{
    position: absolute;
    bottom: 15%;
    left: 35%;
    z-index: 1;
  }
  .intro-caption p, button{
    display: flex;
    justify-content: center;
    text-align: center;
    font-size: 1.5rem;
    font-family: 'Playfair Display', serif; 
  }
  .intro-caption button{
    left: 100px;
    width: 30%;
    color:white;
    background-color: #F689D2;
    margin-left: 10%;
  }
  .intro-caption a{
    text-decoration: none;
  }
  .intro-caption p{
    width: 50%;
    color: #F689D2;
  }
</style>
</head>
<body>
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
          <a class="nav-link" id="sign-up">Sign Up to Our Newsletter</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<main>
<figure class="intro">
  <div id="intro-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000" data-bs-pause="false">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="HomePageSlide1.jpg" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="HomePageSlide2.jpg" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="HomePageSlide3.jpg" class="d-block w-100" alt="...">
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#intro-carousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#intro-carousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
  <figcaption class="intro-caption">
    <img src="CWlogo.png" alt="logo" style="width: 200px; margin-left: 150px; opacity:0.7;"/>
    <p>Whimsical Weddings provides an intelligent system for sourcing your perfect wedding venue.</p>
    <a class="get-started-button" href="venueSearch.php"><button type="button">Get Started</button></a>
  </figcaption>
</figure>
</main>
<footer>

</footer>
</body>
</html>