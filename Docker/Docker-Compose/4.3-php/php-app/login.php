<?php

include 'config.php';
session_start();

if(isset($_POST['submit'])){

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select_users) > 0){

      $row = mysqli_fetch_assoc($select_users);

      if($row['user_type'] == 'admin'){

         $_SESSION['admin_name'] = $row['name'];
         $_SESSION['admin_email'] = $row['email'];
         $_SESSION['admin_id'] = $row['id'];
         header('location:admin_page.php');
         
      }elseif($row['user_type'] == 'user'){

         $_SESSION['user_name'] = $row['name'];
         $_SESSION['user_email'] = $row['email'];
         $_SESSION['user_id'] = $row['id'];
         header('location:home.php');

      }

   }else{
      $message[] = 'incorrect email or password!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediHelp</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"/>
</head>
<body>



    <div id="page" class="site page-home">
        <aside class="site-off desktop-hide">
            <div class="off-canvas">
                <div class="canvas-head flexitem">
                    <div class="logo"><a href="/"><span class="circle"></span>Me<span class="logocolor">diH</span>elp</a></div>
                    <a href="#" class="t-close flexcenter"><i class="ri-close-line"></i></a>
                </div>
                <div class="departments"></div>
                <nav></nav>
                <div class="thetop-nav"></div>
            </div>
        </aside>
        <header>
            <div class="header-top mobile-hide">
                <div class="container">
                    <div class="wrapper flexitem">
                        <div class="left">
                            <ul class="flexitem main-link">
                                <li><a href="#">Blog</a></li>
                                <li><a href="#">Featured Products</a></li>
                                <li><a href="#">Wishlist</a></li>
                            </ul>
                        </div>
                        <div class="right">
                            <ul class="flexitem main-links">
                                <li><a href="#">My Account</a></li>
                                <li><a href="#">Order Tracking</a></li>
                                <li><a href="#">USD <span class="icon-small"><i class="ri-arrow-down-s-line"></i></span></a>
                                    <ul>
                                        <li class="current"><a href="#">USD</a></li>
                                        <li><a href="#">EURO</a></li>
                                        <li><a href="#">IDR</a></li>
                                    </ul>
                                </li>
                                <li><a href="#">English<span class="icon-small"><i class="ri-arrow-down-s-line"></i></span></a>
                                    <ul>
                                        <li class="current"><a href="#">English</a></li>
                                        <li><a href="#">Bangla</a></li>
                                        <li><a href="#">Hindi</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        <!-- header-top -->
        <div class="header-nav">
            <div class="container">
                <div class="wrapper flexitem">
                    <a href="#" class="trigger dexktop-hide"><span class="i ri-menu-2-line"></span></a>
                    <div class="lift flexitem">
                        <div class="logo"><a href="/"><span class="circle"></span>Me<span class="logocolor">diH</span>elp</a></div>
                        <nav class="mobile-hide">
                            <ul class="flexitem second-links">
                                <li><a href="#"></a></li>
                                <li class="has-child">
                                    <a href="#">
                                    </a>
                                    <div class="mega">
                                        <div class="container">
                                            <div class="wrapper">
                                                <div class="flexcol">
                                                    <div class="row">
                                                    </div>
                                                </div>
                                                <div class="flexcol">
                                                    <div class="row">
                                                        <h3> </h3>
                                                    </div>
                                                </div>
                                                <div class="flexcol products">
                                                    <div class="row">
                                                        <div class="media">
                                                            <div class="thumbnail object-cover-1">
                                                                <a href="#">
                                                                    <img src="assets/products/medicine.jpg" alt="">
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="text-content">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="has-child">
                                    <a href="#">
                                    </a>
                                    <div class="mega">
                                        <div class="container">
                                            <div class="wrapper">
                                                <div class="flexcol">
                                                    <div class="row">
                                                    </div>
                                                </div>
                                                <div class="flexcol products">
                                                    <div class="row">
                                                        <div class="media">
                                                            <div class="thumbnail object-cover-1">
                                                                <a href="#">
                                                                    <img src="assets/products/Device.jpg" alt="">
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="text-content">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="has-child">
                                    <a href="#">
                                    </a>
                                    <div class="mega">
                                        <div class="container">
                                            <div class="wrapper">
                                                <div class="flexcol">
                                                    <div class="row">
                                                    </div>
                                                </div>
                                                <div class="flexcol">
                                                    <div class="row">
                                                    </div>
                                                </div>
                                                <div class="flexcol">
                                                    <div class="row">
                                                    </div>
                                                </div>
                                                <div class="flexcol">
                                                    <div class="row">
                                                    </div>
                                                </div>
                                                <div class="flexcol products">
                                                    <div class="row">
                                                        <div class="media">
                                                            <div class="thumbnail object-cover-1">
                                                                <a href="#">
                                                                    <img src="assets/products/apparel4.jpg" alt="">
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="text-content">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li><a href="#">
                                </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        </header>
        <!-- header -->
        <?php
        if(isset($message)){
            foreach($message as $message){
                echo '
                <div class="message">
                    <span>'.$message.'</span>
                    <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
                </div>
                ';
            }
        }
        ?>

        <div class="single-checkout">
            <div class="container">
                <div class="wrapper">
                    <div class="checkout flexwrap lform1" style="margin: 1em; padding: 3em;">
                        <div class="item left styled lform" style=" padding: 4em 3em; height: 500px; border-radius: 15px;">
                            <h1>Login</h1>
                            <form action="" method="post">
                                <p>
                                    <label for="fname">Email</label>
                                    <input type="email" id="fname" name="email" required placeholder="Enter your Email">
                                </p>
                                <p>
                                    <label for="lname">Password</label>
                                    <input type="password" id="lname" name="password" required placeholder="Enter your Password">
                                </p>
                                <p>
                                    <input type="submit" name="submit" value="Login" style=" margin-top: 2px; font-size: var(--font-small); padding: 0.9em 2em; height: auto; width: fit-content; border-radius: 2em; transition: var (--trans-background-color); background-color: var(--primary-color); color: var(--white-color);">
                                </p>
                            </form>
                            <div class="primary-checkout">
                                <div class="reg" style="display: flex; padding-top: 1rem; text-align: justify; justify-content: center;">
                                <p>Don't have an account ? <a href="register.php"><span class="logocolor">Create Account</span></a></p>
                                </div>
                            </div>
                        </div>
                        <div class="item right" id="limg" style="padding: 2em;">
                            <img src="assets/login/login.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer>
            <div class="widgets">
                <div class="container">
                    <div class="wrapper">
                        <div class="flexwrap">
                            <div class="row">
                                <div class="item mini-links">
                                    <h4>Help & Contact</h4>
                                    <ul class="flexcol">
                                        <li><a href="#">Your Account</a></li>
                                        <li><a href="#">Your Order</a></li>
                                        <li><a href="#">Shipping Rates</a></li>
                                        <li><a href="#">Returns</a></li>
                                        <li><a href="#">Assistant</a></li>
                                        <li><a href="#">Help</a></li>
                                        <li><a href="#">Contact us</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="item mini-links">
                                    <h4>Product Categories</h4>
                                    <ul class="flexcol">
                                        <li><a href="#">Medicine</a></li>
                                        <li><a href="#">Medical Devices</a></li>
                                        <li><a href="#">Supplements and Vitamins</a></li>
                                        <li><a href="#">Sexual Wellness</a></li>
                                        <li><a href="#">Women Care</a></li>
                                        <li><a href="#">Baby Care</a></li>
                                        <li><a href="#">Mother Care</a></li>
                                        <li><a href="#">Personal Care</a></li>
                                        <li><a href="#">Herbal and Homeopathy</a></li>
                                        <li><a href="#">Nutrition and Drinks</a></li>
                                        <li><a href="#">Beauty, Skin and Hair Care</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="item mini-links">
                                    <h4>Payment Info</h4>
                                    <ul class="flexcol">
                                        <li><a href="#">Bussiness Card</a></li>
                                        <li><a href="#">Shop with Points</a></li>
                                        <li><a href="#">Reload Your Balance</a></li>
                                        <li><a href="#">Paypal</a></li>
                                        <li><a href="#">Bkash</a></li>
                                        <li><a href="#">Rocket</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="item mini-links">
                                    <h4>About Us</h4>
                                    <ul class="flexcol">
                                        <li><a href="#">Company info</a></li>
                                        <li><a href="#">News</a></li>
                                        <li><a href="#">Investors</a></li>
                                        <li><a href="#">Careers</a></li>
                                        <li><a href="#">Policies</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Widgets -->

            <div class="footer-info">
                <div class="container">
                    <div class="wrapper">
                        <div class="flexcol">
                            <div class="logo">
                                <a href="#"><span class="circle"></span>Me<span class="logocolor">diH</span>elp</a>
                            </div>
                            <div class="socials">
                                <ul class="flexitem">
                                    <li><a href="#"><i class="ri-twitter-line"></i></a></li>
                                    <li><a href="#"><i class="ri-facebook-line"></i></a></li>
                                    <li><a href="#"><i class="ri-instagram-line"></i></a></li>
                                    <li><a href="#"><i class="ri-linkedin-line"></i></a></li>
                                    <li><a href="#"><i class="ri-youtube-line"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <p class="mini-text">Copyright 2022 © MediHelp All right Reserved.</p>
                    </div>
                </div>
            </div>
        </footer>
        <!-- footer-->

        <div class="menu-bottom desktop-hide">
            <div class="container">
                <div class="wrapper">
                    <nav>
                        <ul class="flexitem">
                            <li>
                                <a href="#">
                                    <i class="ri-bar-chart-line"></i>
                                    <span>Trending</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="ri-user-6-line"></i>
                                    <span>Account</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="ri-heart-line"></i>
                                    <span>Wishlist</span>
                                </a>
                            </li>
                            <li>
                                <a href="#0" class="t-search">
                                    <i class="ri-search-line"></i>
                                    <span>Search</span>
                                </a>
                            </li>
                            <li>
                                <a href="#0">
                                    <i class="ri-shopping-cart-line"></i>
                                    <span>Cart</span>
                                    <div class="fly-item">
                                        <span class="item-number">0</span>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Menu Bottom -->

        <div class="search-bottom desktom-hide">
            <div class="container">
                <div class="wrapper">
                    <form action="" class="search">
                        <a href="#" class="t-close search-close flexcenter"><i class="ri-close-line"></i></a>
                        <span class="icon-large"><i class="ri-search-line"></i></span>
                        <input type="search" placeholder="Your email address" required>
                        <button type="submit">Search</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- search botton -->
        <div class="overlay"></div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <script src="script.js"></script>
</body>
</html>