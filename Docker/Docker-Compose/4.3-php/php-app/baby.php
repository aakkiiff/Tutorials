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
    <div id="page" class="site page-single">
    <header>
        <div class="header-main mobile-hide">
            <div class="container">
                <div class="wrapper flexitem">
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
    <?php include 'header1.php'; ?>

    
    <div class="features">
            <div class="container">
                <div class="wrapper">
                    <div class="column">
                        <div class="sectop flexitem">
                            <h2 style="text-align: center;"><span class="circle" style="text-align: center;"></span><span>Baby Care</span></h2>
                        </div>
                        <div class="products main flexwrap">
                            <?php  
                                $select_baby = mysqli_query($conn, "SELECT * FROM `baby` ") or die('query failed');
                                if(mysqli_num_rows($select_baby) > 0){
                                    while($fetch_baby = mysqli_fetch_assoc($select_baby)){
                            ?>
                            <form action="" method="post">
                            <div class="item">
                                <div class="media ">
                                    <div class="thumbnail object-cover-1">
                                        <a href="#">
                                            <img src="uploaded_img/<?php echo $fetch_baby['image']; ?>" alt="">
                                        </a>
                                    </div>
                                </div>
                                <div class="content">
                                    <h3 class="main-links"><a href="#"><?php echo $fetch_baby['name']; ?></a></h3>
                                    <div class="rrr">
                                        <div class="price">
                                            <span class="current"><?php echo $fetch_baby['oprice']; ?> TAKA</span>
                                            <span class="normal mini-text"><?php echo $fetch_baby['price']; ?> TAKA</span>
                                        </div>
                                    </div>
                                    <div class="quintity" style="display:flex;">
                                        <input type="hidden" name="product_name" value="<?php echo $fetch_baby['name']; ?>">
                                        <input type="hidden" name="product_price" value="<?php echo $fetch_baby['oprice']; ?>">
                                        <input type="hidden" name="product_image" value="<?php echo $fetch_baby['image']; ?>">    
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


<?php include 'footer.php'; ?>
</div>

<!-- custom js file link  -->
<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fslightbox/3.3.1/index.js"></script>
<script src="script.js"></script>
<script src="js/script.js"></script>
</body>
</html>