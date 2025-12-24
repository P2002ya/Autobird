<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>AutoBird – Smart Auto‑Rickshaw Booking</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <style>
        .fullpage-wrapper {
      min-height: 100vh;
      overflow-x: hidden;
      overflow-y: auto;
      width: 100%;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: #fff;
      padding-top: 70px;
    }
    .navbar {
    background-color: rgba(26, 35, 126, 0.9);
    backdrop-filter: blur(6px);
    }


    .navbar {
      background-color: #1A237E;
    }

    .navbar-brand, .nav-link {
      color: #FFF !important;
    }

    .navbar-brand img {
      height: 50px;
      width: 50px;
      /* filter: brightness(0) invert(1); */
    }

    .hero {
      background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.4)),
        url('https://images.unsplash.com/photo-1617444460380-1a1fc95b7cc0?auto=format&fit=crop&w=1400&q=80') center/cover no-repeat;
      padding: 140px 20px;
      text-align: center;
      color: #fff;
    }

    .btn-book {
      background: #FF7043;
      color: #FFF;
      font-weight: 600;
      padding: 12px 30px;
    }

    .footer {
      background: #263238;
      color: #FFF;
      padding: 40px 0;
    }

    .footer a {
      color: #FFF;
      text-decoration: none;
    }

    .footer a:hover {
      text-decoration: underline;
    }

    .section-dark {
      background-color: #2E2E3A;
      color: white;
      padding: 60px 20px;
    }

    .section-light {
      background-color: #fdfdfd;
      padding: 60px 20px;
    }

    .section-dark h2, .section-light h2 {
      font-size: 36px;
      font-weight: bold;
    }

    .section-dark p, .section-light p {
      font-size: 18px;
    }

    .highlight-bar {
      height: 4px;
      width: 60px;
      background-color: #f9b233;
      margin: 10px 0;
    }

    .map-corner {
      position: fixed;
      bottom: 20px;
      right: 20px;
      width: 180px;
      height: 120px;
      border: 2px solid #fff;
      border-radius: 10px;
      overflow: hidden;
      z-index: 999;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    }

    .map-corner iframe {
      width: 100%;
      height: 100%;
      border: 0;
    }

    img.illustration {
      max-width: 100%;
      height: auto;
    }

    /* How It Works */
    .section-how {
      padding: 60px 0;
    }

    .switch-btns {
      margin-top: 30px;
    }

    .switch-btns button {
      margin: 0 10px;
      padding: 10px 25px;
      font-weight: bold;
    }

    .step-card {
      display: none;
    }

    .step-card.active {
      display: block;
    }

    .step-icon {
      font-size: 2.5rem;
      margin-bottom: 15px;
      color: #FF7043;
    }
    .section-light h5 {
    font-weight: 600;
    margin-top: 10px;
    }

    .section-light i {
    display: block;
    }
    



  </style>
</head>
<body>




<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top"  style="z-index: 100">
        <div class="container-fluid">
                <img src="./images/bird.png" alt="AutoBird Logo" style="height: 60px; vertical-align: middle; margin-right: 8px;">

            <h3 class="text-white" style="font-size: 30px;">Auto<span style="color: orange;">
                    bird</span></h3>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div id="navMenu" class="collapse navbar-collapse">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="main.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="userlogin.php">Book a Ride</a></li>
                        <li class="nav-item"><a class="nav-link" href="driver/driverlogin.php">Drive with Us</a></li>
                        <li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>
                        <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>         
                     </ul>
                </div>

            </div>
        </div>
    </nav>
  </nav>



<!-- NAVBAR -->
<!-- <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
  <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="main.php">
      <img src="./images/bird.png" alt="AutoBird Logo" style="height: 30px; vertical-align: middle; margin-right: 8px;">
      <span>AutoBird</span>
      </a>



      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div id="navMenu" class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="main.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="userlogin.php">Book a Ride</a></li>
          <li class="nav-item"><a class="nav-link" href="driver/driverlogin.php">Drive with Us</a></li>
          <li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>
          <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
          
        </ul>
      </div>
    </div>
  </nav> -->


<!-- HERO
<section class="hero">
  <div class="container">
    <h1>Welcome to AutoBird</h1>
    <p>Smart Auto-Rickshaw Booking in Belgaum — Instant, Reliable, and Simple</p>
    <a href="userlogin.php" class="btn btn-book mt-3">Book Now</a>
  </div>
</section> -->

<!-- HERO SLIDER START -->
<div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000" data-bs-pause="hover">
  <div class="carousel-inner">

    <!-- SLIDE 1 -->
    <div class="carousel-item active">
      <section class="hero-section d-flex flex-wrap align-items-center justify-content-center"
        style="padding: 60px 20px; background: linear-gradient(to bottom, #2c3e50, #bdc3c7); min-height: 100vh; width: 100%; box-sizing: border-box;">

        <!-- LEFT: Pickup & Drop UI -->
        <div style="flex: 1; min-width: 300px; max-width: 500px; padding: 20px;">
          <div style="background: rgba(255,255,255,0.1); padding: 24px; border-radius: 20px; backdrop-filter: blur(8px);">
            <div style="display: flex; align-items: flex-start; gap: 10px;">
              <!-- ICONS -->
              <div style="display: flex; flex-direction: column; align-items: center; margin-top: 8px;">
                <div style="width: 10px; height: 10px; background: black; border-radius: 50%; margin-bottom: 6px;"></div>
                <div style="width: 2px; height: 40px; background: black;"></div>
                <div style="width: 10px; height: 10px; background: black; margin-top: 6px;"></div>
              </div>

              <!-- INPUTS -->
              <div style="flex: 1; display: flex; flex-direction: column; gap: 16px;">
                <div style="display: flex; align-items: center; background: rgba(255,255,255,0.9); padding: 12px 16px; border-radius: 10px;">
                  <input type="text" id="pickup" placeholder="Pickup location" required
                    style="border: none; outline: none; background: transparent; font-size: 16px; width: 100%;">
                  <span style="font-size: 18px; color: #000; margin-left: 10px;">&#10148;</span>
                </div>
                <div style="display: flex; align-items: center; background: rgba(255,255,255,0.9); padding: 12px 16px; border-radius: 10px;">
                  <input type="text" id="dropoff" placeholder="Dropoff location" required
                    style="border: none; outline: none; background: transparent; font-size: 16px; width: 100%;">
                </div>
              </div>
            </div>
          </div>
          <div style="height: 40px;"></div>
        </div>

        <!-- RIGHT: Heading & CTA -->
        <div style="flex: 1; min-width: 300px; max-width: 500px; color: white; padding: 20px;">
          <h1 style="font-size: 75px; font-weight: 700; margin-bottom: 24px; line-height: 1.2;">
            Welcome to <span style="color: #ffc107;">AutoBird</span>
          </h1>
          <p style="font-size: 20px; margin-bottom: 36px;">
            Smart Auto-Rickshaw Booking in Belgaum — Instant, Reliable, and Simple
          </p>
          <a href="userlogin.php"
            style="background: #ffc107; padding: 16px 32px; font-size: 18px; font-weight: 600; color: #000; border-radius: 10px; text-decoration: none;">
            Book a Rickshaw Now
          </a>
        </div>
      </section>
    </div>

    <!-- SLIDE 2 (Optional Second Slide) -->
    <div class="carousel-item">
      <section class="hero-section d-flex align-items-center justify-content-center"
        style="background: url('images/driver_pay.png') center/cover no-repeat; min-height: 100vh;">

        <div class="text-center text-white p-5" style="background: rgba(0,0,0,0.5); border-radius: 20px;">
          <h1 style="font-size: 60px;">Direct Driver Earnings</h1>
          <p style="font-size: 20px;">No commission. 100% fare goes to the driver.</p>
        </div>

      </section>
    </div>

   <!-- SLIDE 3 -->
    <div class="carousel-item">
      <section class="hero-section d-flex align-items-center justify-content-center"
        style="background: url('images/street.jpg') center/cover no-repeat; min-height: 100vh;">

        <div class="text-center text-white p-5" style="background: rgba(0,0,0,0.5); border-radius: 20px;">
          <h1 style="font-size: 60px; font-weight: 700;">Your City, Your Ride</h1>
          <p style="font-size: 20px; margin-top: 10px;">
            No commissions, no middlemen — just direct, smart, local rides in Belgaum.
          </p>
        </div>
      </section>
    </div>
     <!-- SLIDE 4 -->
    <div class="carousel-item">
      <section class="hero-section d-flex align-items-center justify-content-center"
        style="background: url('images/traffic.jpg') center/cover no-repeat; min-height: 100vh;">

        <div class="text-center text-white p-5" style="background: rgba(0,0,0,0.5); border-radius: 20px;">
          <h1 style="font-size: 60px; font-weight: 700;">Beat the Traffic, Ride Smart</h1>
          <p style="font-size: 20px; margin-top: 10px;">
                Let AutoBird find the nearest ride and get you moving — stress-free, fast, and fair.          </p>
        </div>
      </section>
    </div>


  </div>

  <!-- ARROWS -->
  <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
  <!-- <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button> -->
</div>
<!-- HERO SLIDER END -->



<!-- SECTION 1
<section class="section-dark">
  <div class="container d-flex flex-wrap align-items-center justify-content-between">
    <div class="col-lg-6 mb-4">
      <h2>Fast, Easy and <br> Safe Rides</h2>
      <div class="highlight-bar"></div>
      <p>Blazingly fast, super-easy browser-based ride booking. <br>
        Door-step pickups by trusted local drivers for your safe ride.</p>
    </div>
    <div class="col-lg-5 text-center">
      <img src="images\ride.png" alt="Safe Ride" class="illustration">
    </div>
  </div>
</section> -->

<!-- FULLSCREEN HERO SECTION -->
<section class="section-dark d-flex align-items-center" style="height: 100vh; background-color: #111;">
  <div class="container">
    <div class="row align-items-center justify-content-between">
      
      <!-- LEFT: TEXT CONTENT -->
      <div class="col-lg-6 text-white">
        <h1 class="display-4 fw-bold mb-3">Fast, Easy and <br> Safe Rides</h1>
        <div class="mb-4" style="height: 4px; width: 80px; background-color: #00d084;"></div>
        <p class="lead">Blazingly fast, super-easy browser-based ride booking. <br>
        Door-step pickups by trusted local drivers for your safe ride.</p>
        <?php
            if (session_status() === PHP_SESSION_NONE) {
            // session_start();
        }

        if (isset($_SESSION['user_id'])) {
            echo '<a href="book1.php" class="btn">Book Your Ride</a>';
        } else {
            echo '<a href="userlogin.php" class="btn">Book Your Ride</a>';
        }
        ?>
      </div>

      <!-- RIGHT: ILLUSTRATION -->
      <div class="col-lg-5 text-center mt-5 mt-lg-0">
        <img src="images/ride.png" alt="Safe Ride" class="img-fluid" style="max-height: 400px;">
      </div>

    </div>
  </div>
</section>


<!-- SECTION 2 -->
<!-- <section class="section-light">
  <div class="container d-flex flex-wrap align-items-center justify-content-between">
    <div class="col-lg-6 mb-4">
      <h2>You pay less. <br> Drivers earn more.</h2>
      <div class="highlight-bar"></div>
      <p>This is a Direct-to-Driver platform. <br>
        No middlemen. No commission. 100% of the fare goes to drivers.</p>
    </div>
    <div class="col-lg-5 text-center">
      <img src="images\driver_pay.png" alt="Driver Earnings" class="illustration">
    </div>
  </div>
</section> -->

<!-- SECTION 2 - Fullscreen and Modern -->
<section class="section-light" style="min-height: 100vh; display: flex; align-items: center; background-color: #f9f9f9;">
  <div class="container">
    <div class="row align-items-center">
      <!-- Text Column -->
      <div class="col-md-6 mb-5 mb-md-0">
        <h1 style="font-weight: 700; font-size: 3rem;">You pay less. <br> Drivers earn more.</h1>
        <div style="height: 5px; width: 80px; background-color: #2c3e50; margin: 1rem 0;"></div>
        <p style="font-size: 1.2rem; line-height: 1.6;">
          This is a Direct-to-Driver platform. <br>
          No middlemen. No commission. <br>
          100% of the fare goes to drivers.
        </p>
      </div>

      <!-- Image Column -->
      <div class="col-md-6 text-center">
        <img src="images/driver_pay.png" alt="Driver Earnings" class="img-fluid" style="max-width: 90%; height: auto;">
      </div>
    </div>
  </div>
</section>


<section class="section-how text-center bg-light d-flex align-items-center" style="background-color: #f8f9fa;">  <div class="container-fluid" style="min-height: 40vh;">
    <h2 class="mt-4">How it Works</h2>
    <div class="switch-btns my-3">
      <button class="btn btn-dark" onclick="showSteps('riders')">Riders</button>
      <button class="btn btn-outline-dark" onclick="showSteps('drivers')">Drivers</button>
    </div>

    <!-- Rider Steps -->
    <div id="riders" class="step-card active mt-4">
      <div class="row g-4 justify-content-center">
        <div class="col-md-3">
          <div class="step-icon">📱</div>
          <h5>Book</h5>
          <p>Choose a ride and driver</p>
        </div>
        <div class="col-md-3">
          <div class="step-icon">🚖</div>
          <h5>Ride</h5>
          <p>Travel safe to your destination</p>
        </div>
        <div class="col-md-3">
          <div class="step-icon">💵</div>
          <h5>Pay Directly</h5>
          <p>100% fare goes to the driver</p>
        </div>
      </div>
    </div>

    <!-- Driver Steps -->
    <div id="drivers" class="step-card mt-4">
      <div class="row g-4 justify-content-center">
        <div class="col-md-3">
          <div class="step-icon">📱</div>
          <h5>Get Request</h5>
          <p>Get ride requests from riders</p>
        </div>
        <div class="col-md-3">
          <div class="step-icon">✅</div>
          <h5>Accept & Ride</h5>
          <p>Choose your ride and accept</p>
        </div>
        <div class="col-md-3">
          <div class="step-icon">💵</div>
          <h5>Receive Payment</h5>
          <p>Get payment directly from rider</p>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- MINI MAP -->
<div class="map-corner">
  <iframe 
    src="https://www.openstreetmap.org/export/embed.html?bbox=74.478%2C15.83%2C74.52%2C15.86&layer=mapnik&marker=15.8497%2C74.5017"
    allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade">
  </iframe>
</div>

<!-- REAL-TIME TRACKING SECTION -->
<!-- <section class="section-light"> -->
<section class="section-light" style="min-height: 100vh; display: flex; align-items: center; background-color: #f9f9f9;">

  <div class="container d-flex flex-wrap align-items-center justify-content-between">
    <div class="col-lg-6 mb-4">
      <iframe 
        src="https://www.openstreetmap.org/export/embed.html?bbox=74.478%2C15.83%2C74.52%2C15.86&layer=mapnik&marker=15.8497%2C74.5017" 
        width="100%" height="300" frameborder="0" style="border:1px solid #ccc; border-radius:10px;" allowfullscreen loading="lazy">
      </iframe>
    </div>
    <div class="col-lg-5">
      <h2>Real-Time Tracking</h2>
      <div class="highlight-bar"></div>
      <p>Track your ride in real-time from pickup to drop-off within Belgaum.</p>
      <div class="bg-white p-3 rounded shadow-sm mt-3">
        <strong>Vehicle Name:</strong> <br>
        <span>Showing current location...</span>
      </div>
    </div>
  </div>
</section>

<!-- WHY CHOOSE AUTOBIRD -->
<!-- <section class="section-light text-center"> -->
<section class="section-light" style="min-height: 100vh; display: flex; align-items: center; background-color: #ebf2f5ff;">

  <div class="container">
    <h2>Why Choose AutoBird?</h2>
    <div class="row mt-4">
      <div class="col-md-4">
        <div class="p-4">
          <i class="fa fa-wallet fa-2x mb-3 text-warning"></i>
          <h5>Affordable Pricing</h5>
          <p>Transparent fares and zero hidden charges for all rides.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="p-4">
          <i class="fa fa-shield-alt fa-2x mb-3 text-primary"></i>
          <h5>Safe & Secure</h5>
          <p>Verified drivers, emergency contact options & 24/7 support.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="p-4">
          <i class="fa fa-leaf fa-2x mb-3 text-success"></i>
          <h5>Eco-Friendly</h5>
          <p>Support sustainable rickshaw travel within your city.</p>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- FOOTER -->
<footer class="footer">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-4 mb-3">
        <h4>AutoBird</h4>
        <a href="https://www.facebook.com" target="_blank"><i class="fab fa-facebook-f me-2"></i></a>
        <a href="https://www.twitter.com" target="_blank"><i class="fab fa-twitter me-2"></i></a>
        <a href="https://www.instagram.com" target="_blank"><i class="fab fa-instagram me-2"></i></a>
        <a href="https://www.linkedin.com" target="_blank"><i class="fab fa-linkedin me-2"></i></a>

      </div>
      <div class="col-md-4 mb-3">
        <h5>Quick Links</h5>
        <ul class="list-unstyled">
          <li><a href="userlogin.php" target="_blank">Book a Ride</a></li>
          <li><a href="driver/driverlogin.php" target="_blank">Drive with us</a></li>
          <li><a href="admin/adminlogin.php" target="_blank">Admin</a></li>
          <li><a href="https://yourdomain.com/terms" target="_blank">Terms & Conditions</a></li>
        </ul>
      </div>
      <div class="col-md-4 mb-3 text-md-end">
        
        <h5>Contact</h5>
        <p>Belgaum, Karnataka<br>Email: <a href="mailto:support@autobird.in">support@autobird.in</a></p>
      </div>
    </div>
    <div class="text-center border-top pt-3">&copy; 2025 AutoBird. All Rights Reserved.</div>
  </div>
</footer>

<!-- SCRIPT -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function showSteps(role) {
    document.getElementById('riders').classList.remove('active');
    document.getElementById('drivers').classList.remove('active');
    document.getElementById(role).classList.add('active');
  }
</script>
<script>
  function showSteps(type) {
    document.getElementById('riders').classList.remove('active');
    document.getElementById('drivers').classList.remove('active');
    document.getElementById(type).classList.add('active');

    const buttons = document.querySelectorAll('.switch-btns .btn');
    buttons.forEach(btn => btn.classList.remove('btn-dark'));
    buttons.forEach(btn => btn.classList.add('btn-outline-dark'));

    const activeBtn = Array.from(buttons).find(btn => btn.textContent.toLowerCase().includes(type));
    if (activeBtn) {
      activeBtn.classList.remove('btn-outline-dark');
      activeBtn.classList.add('btn-dark');
    }
  }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
