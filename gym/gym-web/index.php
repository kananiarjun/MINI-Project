<?php
if (session_status() === PHP_SESSION_NONE)
{
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login2.php");
    exit;
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "gym_user";

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Insert data safely
if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    
    $sql = "INSERT INTO user_data (name, email, message) VALUES ('$name', '$email', '$message')";
    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Close connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Gym Template">
    <meta name="keywords" content="Gym, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gym | Master</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Oswald:300,400,500,600,700&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/flaticon.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/barfiller.css" type="text/css">
    <link rel="stylesheet" href="css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <style>
        #pricing {
            display: block; /* Ensure it's not hidden */
        }
    </style>
</head>

<body>
    <!-- Page Preloader -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Remove Offcanvas Menu Section as requested -->
    <!-- Offcanvas Menu Section Begin -->
    <!--
    <div class="offcanvas-menu-overlay"></div>
    <div class="offcanvas-menu-wrapper">
      <div class="canvas-close">
        <i class="fa fa-close"></i>
      </div>
      <div class="canvas-search search-switch">
        <i class="fa fa-search"></i>
      </div>
      <nav class="canvas-menu mobile-menu">
        <ul>
          <li><a href="./index.php">Home</a></li>
          <li><a href="./about-us.html">About Us</a></li>
          <li><a href="./classes.html">Classes</a></li>
          <li><a href="./services.html">Services</a></li>
          <li><a href="./team.html">Our Team</a></li>
          <li>
            <a href="#">Pages</a>
            <ul class="dropdown">
              <li><a href="./class-timetable.html">Classes Timetable</a></li>
              <li><a href="#">Attendance</a></li>
            </ul>
          </li>
          <li><a href="./contact.php">Contact</a></li>
          <li id="admin-link"><a href="./admin_login.php">Admin Login</a></li>
          <li id="logout-link" style="display:none;"><a href="logout.php">Logout</a></li>
        </ul>
      </nav>
    </div>
    -->
    <!-- Offcanvas Menu Section End -->

    <!-- Header Section Begin -->
    <header class="header-section">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-6 col-md-3">
                    <div class="logo">
                        <a href="./index.php">
                            <img src="img/logo.png" alt="Gym Logo">
                        </a>
                    </div>
                </div>
                <div class="col-6 col-md-9">
                    <nav class="nav-menu" style="display: block;">
                        <ul>
                            <li class="active"><a href="./index.html">Home</a></li>
                            <li><a href="./about-us.html">About Us</a></li>
                            <li><a href="./services.html">Services</a></li>
                            <li>
                                <a href="#">Pages</a>
                                <ul class="dropdown">
                                    <li><a href="./admin_login.php">Admin Login</a></li>
                                    <li><a href="./team.html">Our Team</a></li>
                                    <li><a href="./class-timetable.html">Classes timetable</a></li>
                                    <li><a href="./class-details.html">Classes</a></li>
                                </ul>
                            </li>
                            <li><a href="./contact.php">Contact</a></li>
                            <li class="login-btn"><a href="http://127.0.0.1:5500/login.html" target="_blank" rel="noopener noreferrer">Store</a></li>
                            <!-- <li class="login-btn"><a href="http://192.168.14.215:5500/login.html" target="_blank" rel="noopener noreferrer">Store</a></li> -->
                            <li class="login-btn"><a href="logout.php">Logout</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- Header End -->

    <!-- Hero Section Begin -->
    <section class="hero-section">
        <div class="hs-slider owl-carousel">
            <div class="hs-item set-bg" data-setbg="img/hero/hero-1.jpg">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 offset-lg-6">
                            <div class="hi-text">
                                <span>Shape your body</span>
                                <h1>Be <strong>strong</strong> traning hard</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hs-item set-bg" data-setbg="img/hero/hero-2.jpg">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 offset-lg-6">
                            <div class="hi-text">
                                <span>Shape your body</span>
                                <h1>Be <strong>strong</strong> traning hard</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- ChoseUs Section Begin -->
    <section class="choseus-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Why chose us?</span>
                        <h2>PUSH YOUR LIMITS FORWARD</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="cs-item">
                        <span class="flaticon-034-stationary-bike"></span>
                        <h4>Modern equipments</h4>
                        <p>Innovate Your Workout - Experience Excellence!</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="cs-item">
                        <span class="flaticon-033-juice"></span>
                        <h4>Healthy nutrition plan</h4>
                        <p>Nourish to Flourish - Your Path to Wellness!</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="cs-item">
                        <span class="flaticon-002-dumbell"></span>
                        <h4>Professional training plan</h4>
                        <p>Expert Guidance for Unmatched Results!</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="cs-item">
                        <span class="flaticon-014-heart-beat"></span>
                        <h4>Unique to your needs</h4>
                        <p>Your Goals, Our Mission - Together We Achieve!</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ChoseUs Section End -->

    <!-- Classes Section Begin -->
    <section class="classes-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Our Classes</span>
                        <h2>WHAT WE CAN OFFER</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="class-item">
                        <div class="ci-pic">
                            <img src="img/gallery/gallery-7.jpg" alt="Indoor cycling">
                        </div>
                        <div class="ci-text">
                            <span>Cardio</span>
                            <h5>Indoor cycling</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="class-item">
                        <div class="ci-pic">
                            <img src="img/gallery/gallery-1.jpg" alt="Kettlebell power">
                        </div>
                        <div class="ci-text">
                            <span>STRENGTH</span>
                            <h5>Kettlebell power</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="class-item">
                        <div class="ci-pic">
                            <img src="img/classes/class-4.jpg" alt="Muscle Building">
                        </div>
                        <div class="ci-text">
                            <span>STRENGTH</span>
                            <h4>Muscle Building</h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="class-item">
                        <div class="ci-pic">
                            <img src="img/classes/class-5.jpg" alt="Boxing">
                        </div>
                        <div class="ci-text">
                            <span>Training</span>
                            <h4>Boxing</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Classes Section End -->

    <!-- Banner Section Begin -->
    <section class="banner-section set-bg" data-setbg="img/banner-bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="bs-text">
                        <h2>registration now to get more deals</h2>
                        <div class="bt-tips">Where health, beauty and fitness meet.</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Section End -->

    <!-- Pricing Section Begin -->
    <section class="pricing-section spad" id="pricing">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <span>Our Plan</span>
                    <h2>Choose your pricing plan</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-8">
                <div class="ps-item">
                    <h3>3 Month unlimited</h3>
                    <div class="pi-price">
                        <h2>₹ 3,500.0</h2>
                        <span>SINGLE CLASS</span>
                    </div>
                    <ul>
                        <li>Enjoy access to gym facilities without restrictions.</li>
                        <li>Use any equipment available in the gym.</li>
                        <li>Guidance and support from a personal trainer included.</li>
                        <li>Join specialized weight loss sessions.</li>
                        <li>Flexibility to continue or cancel monthly.</li>
                        <li>Use the gym facilities at your convenience.</li>
                    </ul>
                    <a href="payment39.php" class="primary-btn pricing-btn">Enroll now</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-8">
                <div class="ps-item">
                    <h3>6 Month unlimited</h3>
                    <div class="pi-price">
                        <h2>₹ 6,500.0</h2>
                        <span>SINGLE CLASS</span>
                    </div>
                    <ul>
                        <li>Similar access to gym facilities with flexibility.</li>
                        <li>Access to all gym equipment.</li>
                        <li>Includes personal training services.</li>
                        <li>Participation in weight management classes.</li>
                        <li>Monthly enrollment flexibility.</li>
                        <li> Flexible usage times for gym access.</li>
                    </ul>
                    <a href="payment59.php" class="primary-btn pricing-btn">Enroll now</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-8">
                <div class="ps-item">
                    <h3>12 Month unlimited</h3>
                    <div class="pi-price">
                        <h2>₹ 12,500.0</h2>
                        <span>SINGLE CLASS</span>
                    </div>
                    <ul>
                        <li>Unlimited access to gym equipment and facilities.</li>
                        <li>Full access to all available equipment.</li>
                        <li>Personalized attention and training guidance.</li>
                        <li>Weight loss programs offered.</li>
                        <li>Option to continue or cancel each month.</li>
                        <li>Access available any time as per convenience.</li>
                    </ul>
                    <a href="payment99.php" class="primary-btn pricing-btn">Enroll now</a>
                </div>
            </div>
        </div>
    </section>
    <!-- Pricing Section End -->

    <!-- Gallery Section Begin -->
    <div class="gallery-section">
        <div class="gallery">
            <div class="grid-sizer"></div>
            <div class="gs-item set-bg" data-setbg="img/gallery/gallery-4.jpg">
                <a href="img/gallery/gallery-4.jpg" class="thumb-icon image-popup"><i class="fa fa-picture-o"></i></a>
            </div>
            <div class="gs-item set-bg" data-setbg="img/gallery/gallery-5.jpg">
                <a href="img/gallery/gallery-5.jpg" class="thumb-icon image-popup"><i class="fa fa-picture-o"></i></a>
            </div>
            <div class="gs-item grid-wide set-bg" data-setbg="img/gallery/gallery-6.jpg">
                <a href="img/gallery/gallery-6.jpg" class="thumb-icon image-popup"><i class="fa fa-picture-o"></i></a>
            </div>
        </div>
    </div>
    <!-- Gallery Section End -->

    <!-- Team Section Begin -->
    <section class="team-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="team-title">
                        <div class="section-title">
                            <span>Our Team</span>
                            <h2>TRAIN WITH EXPERTS</h2>
                        </div>
                        <a href="#" id="enroll-btn" class="primary-btn btn-normal appoinment-btn"> Enroll</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="ts-slider owl-carousel">
                    <div class="col-lg-4">
                        <div class="ts-item set-bg" data-setbg="img/team/team-1.jpg">
                            <div class="ts_text">
                                <h4>Athart Rachel</h4>
                                <span>Strength & Conditioning Coach</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="ts-item set-bg" data-setbg="img/team/team-2.jpg">
                            <div class="ts_text">
                                <h4>Jordan Wells</h4>
                                <span>Personal Trainer</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="ts-item set-bg" data-setbg="img/team/team-3.jpg">
                            <div class="ts_text">
                                <h4>Blake Hunter</h4>
                                <span>Bodybuilding Specialist</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="ts-item set-bg" data-setbg="img/team/team-4.jpg">
                            <div class="ts_text">
                                <h4>Noah Reed</h4>
                                <span> Functional Training Expert</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="ts-item set-bg" data-setbg="img/team/team-5.jpg">
                            <div class="ts_text">
                                <h4>Sophia Lane</h4>
                                <span>Yoga & Flexibility Trainer</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="ts-item set-bg" data-setbg="img/team/team-6.jpg">
                            <div class="ts_text">
                                <h4>Ava Knight</h4>
                                <span>HIIT & Endurance Coach</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Team Section End -->

    <!-- Get In Touch Section Begin -->
    <div class="gettouch-section">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="gt-text">
                        <i class="fa fa-map-marker"></i>
                        <p>Atmiya University Kalawad Rd, Rajkot,<br/> GUJ 360004</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="gt-text">
                        <i class="fa fa-mobile"></i>
                        <ul>
                            <li>87330 57636</li>
                            <li>76003 62035</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="gt-text email">
                        <i class="fa fa-envelope"></i>
                        <p>aak509694@gmail.com</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Get In Touch Section End -->

    <!-- Footer Section Begin -->
    <section class="footer-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="fs-about">
                        <div class="fa-logo">
                            <a href="#"><img src="img/logo.png" alt="Logo"></a>
                        </div>
                        <p>Where strength is built, and limits are shattered. Show up, put in the work, and own your progress.💪🔥</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="fs-widget">
                        <h4>Useful links</h4>
                        <ul>
                            <li><a href="team.html">Our Team</a></li>
                            <li><a href="services.html">Services</a></li>
                            <li><a href="class-details.html">Classes</a></li>
                            <li><a href="contact.php">Contact</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="fs-widget">
                        <h4>Tips & Guides</h4>
                        <div class="fw-recent">
                            <h6><a href="#">Physical fitness may help prevent depression, anxiety</a></h6>
                        </div>
                        <div class="fw-recent">
                            <h6><a href="#">Fitness: The best exercise to lose belly fat and tone up...</a></h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="copyright-text">
                        <p>Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer Section End -->

    <!-- Search model Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch">+</div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Search here....." autocomplete="off">
            </form>
        </div>
    </div>
    <!-- Search model end -->

    <script>
        document.getElementById("enroll-btn").addEventListener("click", function(event) {
            event.preventDefault();
            const section = document.getElementById("pricing");
            window.scrollTo({
                top: section.offsetTop - 20,
                behavior: "smooth"
            });
        });
    </script>

    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/masonry.pkgd.min.js"></script>
    <script src="js/jquery.barfiller.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
