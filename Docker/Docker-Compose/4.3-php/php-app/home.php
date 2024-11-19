<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:home.php');
}

if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_cart_numbers) > 0){
      $message[] = 'already added to cart!';
   }else{
      mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
      $message[] = 'product added to cart!';
   }

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Medihelp</title>

   <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"/>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/style1.css">

</head>
<body>
   
<?php include 'header.php'; ?>
   <header>
         <div class="header-main mobile-hide">
            <div class="container">
                <div class="wrapper flexitem">
                    <div class="left">
                        <div class="dpt-cat">
                            <div class="dpt-head">
                                <div class="main-text">All Departments</div>
                                <div class="mini-text mobile-hide">
                                    <?php 
                                       $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
                                       $number_of_products = mysqli_num_rows($select_products);
                                    ?>
                                    <p style="font-size: 10px;">Total <?php echo $number_of_products; ?> Products</p>
                                 </div>
                                <a href="#" class="dpt-trigger mobile-hide">
                                    <i class="ri-menu-3-line ri-xl"></i>
                                </a>
                            </div>
                            <div class="dpt-menu">
                                <ul class="second-links">
                                <li class="has-child Medicine">
                                        <a href="medicine.php">
                                            <div class="icon-large"><i class="ri-capsule-fill"></i></div>
                                            Medicine
                                        </a>
                                        
                                    </li>
                                    <li class="has-child Devices">
                                        <a href="device.php">
                                            <div class="icon-large"><i class="ri-thermometer-line"></i></div>
                                            Medical Devices
                                        </a>
                                    </li>
                                    <li>
                                        <a href="vitamins.php">
                                            <div class="icon-large"><i class="ri-medicine-bottle-line"></i></div>
                                            Supplements & Vitamins
                                        </a>
                                    </li>
                                    <li>
                                        <a href="sexual.php">
                                            <div class="icon-large"><i class="ri-psychotherapy-line"></i></i></div>
                                            Sexual Wellness
                                        </a>
                                    </li>
                                    <li>
                                        <a href="women.php">
                                            <div class="icon-large"><i class="fa-thin fa-person-dress"></i></div>
                                            Women's Care
                                        </a>
                                    </li>
                                    <li>
                                        <a href="baby.php">
                                            <div class="icon-large"><i class="ri-open-arm-line"></i></i></div>
                                            Baby Care
                                        </a>
                                    </li>
                                    <li>
                                        <a href="mother.php">
                                            <div class="icon-large"><i class="ri-parent-line"></i></i></div>
                                            Mother Care
                                        </a>
                                    </li>
                                    <li>
                                        <a href="personal.php">
                                            <div class="icon-large"><i class="ri-user-2-line"></i></i></div>
                                            Personal Care
                                        </a>
                                    </li>
                                    <li>
                                        <a href="h&h.php">
                                            <div class="icon-large"><i class="ri-dossier-line"></i></i></div>
                                            Herbal & Homeopathy
                                        </a>
                                    </li>
                                    <li>
                                        <a href="drink.php">
                                            <div class="icon-large"><i class="ri-test-tube-line"></i></i></div>
                                            Nutrition & Drinks
                                        </a>
                                    </li>
                                    <li class="has-child Beauty">
                                        <a href="beauty.php">
                                            <div class="icon-large"><i class="ri-bear-smile-line"></i></div>
                                            Beauty, Skin & Hair Care
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="right">
                        <div class="search-box">
                            <form action="" class="search">
                                <span class="icon-large"><i class="risearch-line"></i></span>
                                <input type="search" placeholder="Search for Products">
                                <button type="submit">Search</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   </header>
    <main>
        <div class="slider">
                <div class="container">
                    <div class="wrapper">
                        <div class="myslider swiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="item">
                                        <div class="image object-cover">
                                            <img src="assets/slider/slider1.jpg" alt="">
                                        </div>
                                        <div class="text-content flexcol">
                                            <h4>Cashback</h4>
                                            <h2><span>Cashback offer</span><br><span>Available on Certain Orders</span></h2>
                                            <a href="" class="primary-button">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="item">
                                        <div class="image object-cover">
                                            <img src="assets/slider/slider2.jpg" alt="">
                                        </div>
                                        <div class="text-content flexcol">
                                            <h4>Free Delivary</h4>
                                            <h2><span>First order gets</span><br><span>Free Home Delivery</span></h2>
                                            <a href="" class="primary-button">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="item">
                                        <div class="image object-cover">
                                            <img src="assets/slider/slider3.jpg" alt="">
                                        </div>
                                        <div class="text-content flexcol">
                                            <h4>Offer</h4>
                                            <h2><span>12% Discount</span><br><span>On First Order</span></h2>
                                            <a href="" class="primary-button">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- slider -->
            <div class="brands">
                <div class="container">
                    <div class="wrapper flexitem">
                        <div class="item">
                            <a href="">
                                <img src="assets/brands/asus.png" alt="">
                            </a>
                        </div>
                        <div class="item">
                            <a href="">
                                <img src="assets/brands/dng.png" alt="">
                            </a>
                        </div>
                        <div class="item">
                            <a href="">
                                <img src="assets/brands/hurley.png" alt="">
                            </a>
                        </div>
                        <div class="item">
                            <a href="">
                                <img src="assets/brands/oppo.png" alt="">
                            </a>
                        </div>
                        <div class="item">
                            <a href="">
                                <img src="assets/brands/samsung.png" alt="">
                            </a>
                        </div>
                        <div class="item">
                            <a href="">
                                <img src="assets/brands/zara.png" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <!-- brands-->
        

        <div class="features">
            <div class="container">
                <div class="wrapper">
                    <div class="column">
                        <div class="sectop flexitem">
                            <h2><span class="circle"></span><span>Medicine</span></h2>
                            <div class="second-links">
                                <a href="medicine.php" class="view-all">View all<i class="ri-arrow-right-line"></i></a>
                            </div>
                        </div>
                        <div class="products main flexwrap">
                            <?php  
                                $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT 8") or die('query failed');
                                if(mysqli_num_rows($select_products) > 0){
                                    while($fetch_products = mysqli_fetch_assoc($select_products)){
                            ?>
                            <form action="" method="post">
                            <div class="item">
                                <div class="media ">
                                    <div class="thumbnail object-cover-1">
                                        <a href="#">
                                            <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
                                        </a>
                                    </div>
                                </div>
                                <div class="content">
                                    <h3 class="main-links"><a href="#"><?php echo $fetch_products['name']; ?></a></h3>
                                    
                                    <p style="font-weight: 5px; color:rgb(59, 58, 58); font-size: 12px;"><?php echo $fetch_products['gname']; ?></i></p>
                                    <div class="rrr">
                                        <div class="price">
                                            <span class="current"><?php echo $fetch_products['oprice']; ?> TAKA</span>
                                            <span class="normal mini-text"><?php echo $fetch_products['price']; ?> TAKA</span>
                                        </div>
                                    </div>
                                    <div class="quintity" style="display:flex;">
                                        <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                                        <input type="hidden" name="product_price" value="<?php echo $fetch_products['oprice']; ?>">
                                        <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">    
                                        <input type="number" min="1" name="product_quantity" value="1" style="width: 115px;">
                                        <input type="submit" value="add to cart" name="add_to_cart" class="primary-button mini-button" style="margin-left: 10px;">
                                    </div>
                                </div>
                            </div>
                            </form>
                            <?php
                                    }
                                }else{
                                    echo '<p class="empty">no products added yet!</p>';
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="features">
            <div class="container">
                <div class="wrapper">
                    <div class="column">
                        <div class="sectop flexitem">
                            <h2><span class="circle"></span><span>Devices</span></h2>
                            <div class="second-links">
                                <a href="#" class="view-all">View all<i class="ri-arrow-right-line"></i></a>
                            </div>
                        </div>
                        <div class="products main flexwrap">
                            <?php  
                                $select_device = mysqli_query($conn, "SELECT * FROM `device` LIMIT 8") or die('query failed');
                                if(mysqli_num_rows($select_device) > 0){
                                    while($fetch_device = mysqli_fetch_assoc($select_device)){
                            ?>
                            <form action="" method="post">
                            <div class="item">
                                <div class="media ">
                                    <div class="thumbnail object-cover-1">
                                        <a href="#">
                                            <img src="uploaded_img/<?php echo $fetch_device['image']; ?>" alt="">
                                        </a>
                                    </div>
                                </div>
                                <div class="content">
                                    <h3 class="main-links"><a href="#"><?php echo $fetch_device['name']; ?></a></h3>
                                    <div class="rrr">
                                        <div class="price">
                                            <span class="current"><?php echo $fetch_device['oprice']; ?> TAKA</span>
                                            <span class="normal mini-text"><?php echo $fetch_device['price']; ?> TAKA</span>
                                        </div>
                                    </div>
                                    <div class="quintity" style="display:flex;">
                                        <input type="hidden" name="product_name" value="<?php echo $fetch_device['name']; ?>">
                                        <input type="hidden" name="product_price" value="<?php echo $fetch_device['oprice']; ?>">
                                        <input type="hidden" name="product_image" value="<?php echo $fetch_device['image']; ?>">    
                                        <input type="number" min="1" name="product_quantity" value="1" style="width: 115px;">
                                        <input type="submit" value="add to cart" name="add_to_cart" class="primary-button mini-button" style="margin-left: 10px;">
                                    </div>
                                </div>
                            </div>
                            </form>
                            <?php
                                    }
                                }else{
                                    echo '<p class="empty">no products added yet!</p>';
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="banners">
            <div class="container">
                <div class="wrapper">
                    <div class="column">
                        <div class="banner flexwrap">
                            <div class="row">
                                <div class="item">
                                    <div class="image">
                                        <img src="assets/banner/banner1.jpg" alt="">
                                    </div>
                                    <div class="text-content flexcol">
                                        <h4>Brutal Sale!</h4>
                                        <h3><span>Get the deal in here</span><br>Living Room Chair</h3>
                                        <a href="#" class="primary-button">Shop Now</a>
                                    </div>
                                    <a href="#" class="over-link"></a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="item get-gray">
                                    <div class="image">
                                        <img src="assets/banner/banner2.jpg" alt="">
                                    </div>
                                    <div class="text-content flexcol">
                                        <h4>Brutal Sale!</h4>
                                        <h3><span>Digital Medical Devices in here</span><br>Digital Thermometer Chair</h3>
                                        <a href="#" class="primary-button">Shop Now</a>
                                    </div>
                                    <a href="#" class="over-link"></a>
                                </div>
                            </div>
                        </div>
                        <!-- banners -->

                        <div class="product-categories flexwrap">
                            <div class="row">
                                <div class="item">
                                    <div class="image">
                                        <img src="assets/banner/procat1.jpg" alt="">
                                    </div>
                                    <div class="content mini-links">
                                        <h4>Medicine</h4>
                                        <ul class="flexcol">
                                            <li><a href="#">Capsule</a></li>
                                            <li><a href="#">Suppository</a></li>
                                            <li><a href="#">Inhaler</a></li>
                                            <li><a href="#">Injection</a></li>
                                            <li><a href="#">Teblet</a></li>
                                            <li><a href="#">Syrup</a></li>
                                        </ul>
                                        <div class="second-link">
                                            <a href="#" class="view-all">View all<i class="ri-arrow-right-line"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="item">
                                    <div class="image">
                                        <img src="assets/banner/procat2.jpg" alt="">
                                    </div>
                                    <div class="content mini-links">
                                        <h4>Medical Devices</h4>
                                        <ul class="flexcol">
                                            <li><a href="#">Nebulizer</a></li>
                                            <li><a href="#">Oximeter</a></li>
                                            <li><a href="#">Thermometer</a></li>
                                            <li><a href="#">Glucose Strips</a></li>
                                        </ul>
                                        <div class="second-link">
                                            <a href="#" class="view-all">View all<i class="ri-arrow-right-line"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="item">
                                    <div class="image">
                                        <img src="assets/banner/procat3.jpg" alt="">
                                    </div>
                                    <div class="content mini-links">
                                        <h4>Beauty</h4>
                                        <ul class="flexcol">
                                            <li><a href="#">Makeup</a></li>
                                            <li><a href="#">Skin Care</a></li>
                                            <li><a href="#">Hair Care</a></li>
                                            <li><a href="#">Fragrance</a></li>
                                        </ul>
                                        <div class="second-link">
                                            <a href="#" class="view-all">View all<i class="ri-arrow-right-line"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
<script src="script.js"></script>
<script src="js/script.js"></script>

</body>
</html>
