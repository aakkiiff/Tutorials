<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['order_btn'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $number = $_POST['number'];
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $method = mysqli_real_escape_string($conn, $_POST['method']);
   $address = mysqli_real_escape_string($conn, 'flat no. '. $_POST['flat'].', '. $_POST['street'].', '. $_POST['city'].', '. $_POST['country'].' - '. $_POST['pin_code']);
   $placed_on = date('d-M-Y');

   $cart_total = 0;
   $cart_products[] = '';

   $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   if(mysqli_num_rows($cart_query) > 0){
      while($cart_item = mysqli_fetch_assoc($cart_query)){
         $cart_products[] = $cart_item['name'].' ('.$cart_item['quantity'].') ';
         $sub_total = ($cart_item['price'] * $cart_item['quantity']);
         $cart_total += $sub_total;
      }
   }

   $total_products = implode(', ',$cart_products);

   $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE name = '$name' AND number = '$number' AND email = '$email' AND method = '$method' AND address = '$address' AND total_products = '$total_products' AND total_price = '$cart_total'") or die('query failed');

   if($cart_total == 0){
      $message[] = 'your cart is empty';
   }else{
      if(mysqli_num_rows($order_query) > 0){
         $message[] = 'order already placed!'; 
      }else{
         mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on) VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on')") or die('query failed');
         $message[] = 'order placed successfully!';
         mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
      }
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
</div>
<?php include 'header1.php'; ?>
<main>

            <div class="single-checkout">
                <div class="container">
                    <div class="wrapper">
                        <div class="checkout flexwrap">
                            <div class="item left styled">
                                <h1>Shipping Address</h1>
                                <form action="" method="post">
                                    <p>
                                        <label for="fname">Enter full name <span></span></label>
                                        <input type="text" id="name" name="name" required placeholder="Enter your full name">
                                    </p>
                                    <p>
                                        <label for="address">Present Address<span></span></label>
                                        <input type="text" name="flat" required placeholder="Present Address" required>
                                    </p>
                                    <p>
                                        <label for="address">Street Name<span></span></label>
                                        <input type="text" name="street" required placeholder="Street name">
                                    </p>
                                    <p>
                                        <label for="address">City<span></span></label>
                                        <input type="text" name="city" required placeholder="e.g. Dhaka">
                                    </p>
                                    <p>
                                        <label for="address">Division<span></span></label>
                                        <input type="text" name="state" required placeholder="e.g. Dhaka">
                                    </p>
                                    <p>
                                        <label for="address">Country<span></span></label>
                                        <input type="text" name="country" required placeholder="e.g. Bangladesh">
                                    </p>
                                    <p>
                                        <label for="postal">Zip / Postal Code<span></span></label>
                                        <input type="number" id="postal" min="0" name="pin_code" required>
                                    </p>
                                    <p>
                                        <label for="country">CountryPayment Methods</label>
                                        <select name="method">
                                          <option value="cash on delivery">cash on delivery</option>
                                          <option value="credit card">credit card</option>
                                          <option value="paypal">paypal</option>
                                          <option value="paytm">paytm</option>
                                        </select>
                                    </p>
                                    <p>
                                        <label for="phone">Phone Number<span></span></label>
                                        <input type="number" id="phone" name="number" placeholder="01XXXXXXXXX" required>
                                    </p>
                                    <p>
                                        <label for="email">Email Address <span></span></label>
                                        <input type="email" name="email" id="email" autocomplete="off" placeholder="Email Address" required>
                                    </p>
                                    <input type="submit" value="Place Order" class="primary-button" name="order_btn" style="padding: 15px 35px; color: black; font-size: large; font-weight: bold;">
                                </form>
                            </div>
                            <div class="item right">
                                <h2>Order Summary</h2>
                                <div class="summary-order is_sticky">
                                    <ul class="products mini">
                                    <?php  
                                       $grand_total = 0;
                                       $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
                                       if(mysqli_num_rows($select_cart) > 0){
                                          while($fetch_cart = mysqli_fetch_assoc($select_cart)){
                                             $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
                                             $grand_total += $total_price;
                                    ?>
                                    <li class="item">
                                            <div class="thumbnail object-cover">
                                            <img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" alt="">
                                            </div>
                                            <div class="item-content">
                                                <p><?php echo $fetch_cart['name']; ?></p>
                                                <span class="price">
                                                    <span>x<?php echo $fetch_cart['quantity']; ?></span>
                                                    <span><?php echo $fetch_cart['price']; ?> TAKA</span>
                                                </span>
                                            </div>
                                        </li>
                                    <?php
                                       }
                                    }else{
                                       echo '<p>Your cart is empty</p>';
                                    }
                                    ?>
                                    
                                    <div class="summary-totals">
                                        <ul>
                                          <li>
                                                <span>Total</span>
                                                <strong style="font-size: 100px;"></strong></strong><?php echo $grand_total; ?> TAKA</strong>
                                          </li>
                                        </ul>
                                    </div>
                                    </ul>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/fslightbox/3.3.1/index.js"></script>
<script src="js/script.js"></script>
<script src="script.js"></script>

</body>
</html>