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
                                       <i class="ri-close-line ri-xl"></i>
                                 </a>
                              </div>
                              <div class="dpt-menu">
                                 <ul class="second-links">
                                       <li class="has-child Medicine">
                                          <a href="#">
                                             <div class="icon-large"><i class="ri-capsule-fill"></i></div>
                                             Medicine
                                             <div class="icon-small"><i class="ri-arrow-right-s-line"></i></div>
                                          </a>
                                          <div class="mega">
                                             <div class="flexcol">
                                                   <div class="row">
                                                      <ul>
                                                         <li><a href="#">Capsule</a></li>
                                                         <li><a href="#">Cream</a></li>
                                                         <li><a href="#">Tablet</a></li>
                                                         <li><a href="#">Suppository</a></li>
                                                         <li><a href="#">Injection</a></li>
                                                      </ul>
                                                   </div>
                                             </div>
                                             <div class="flexcol">
                                                   <div class="row">
                                                      <ul>
                                                         <li><a href="#">Syrup</a></li>
                                                         <li><a href="#">Powder</a></li>
                                                         <li><a href="#">Inhaler</a></li>
                                                      </ul>
                                                   </div>
                                             </div>
                                          </div>
                                          
                                       </li>
                                       <li class="has-child Devices">
                                          <a href="#">
                                             <div class="icon-large"><i class="ri-thermometer-line"></i></div>
                                             Medical Devices
                                             <div class="icon-small"><i class="ri-arrow-right-s-line"></i></div>
                                          </a>
                                          <div class="mega">
                                             <div class="flexcol">
                                                   <div class="row">
                                                      <ul>
                                                         <li><a href="#">Blood Glucose Meter</a></li>
                                                         <li><a href="#">Blood Pressure Machine</a></li>
                                                         <li><a href="#">Glucose Strips</a></li>
                                                         <li><a href="#">Nebulizer</a></li>
                                                         <li><a href="#">Oximeter</a></li>
                                                      </ul>
                                                   </div>
                                             </div>
                                             <div class="flexcol">
                                                   <div class="row">
                                                      <ul>
                                                         <li><a href="#">Thermometer</a></li>
                                                         <li><a href="#">Sphygmomanometer</a></li>
                                                      </ul>
                                                   </div>
                                             </div>
                                          </div>
                                          
                                       </li>
                                       <li>
                                          <a href="#">
                                             <div class="icon-large"><i class="ri-medicine-bottle-line"></i></div>
                                             Supplements & Vitamins
                                          </a>
                                       </li>
                                       <li>
                                          <a href="#">
                                             <div class="icon-large"><i class="ri-psychotherapy-line"></i></i></div>
                                             Sexual Wellness
                                          </a>
                                       </li>
                                       <li>
                                          <a href="#">
                                             <div class="icon-large"><i class="fa-thin fa-person-dress"></i></div>
                                             Women's Care
                                          </a>
                                       </li>
                                       <li>
                                          <a href="#">
                                             <div class="icon-large"><i class="ri-open-arm-line"></i></i></div>
                                             Baby Care
                                          </a>
                                       </li>
                                       <li>
                                          <a href="#">
                                             <div class="icon-large"><i class="ri-parent-line"></i></i></div>
                                             Mother Care
                                          </a>
                                       </li>
                                       <li>
                                          <a href="#">
                                             <div class="icon-large"><i class="ri-user-2-line"></i></i></div>
                                             Personal Care
                                          </a>
                                       </li>
                                       <li>
                                          <a href="#">
                                             <div class="icon-large"><i class="ri-dossier-line"></i></i></div>
                                             Herbal & Homeopathy
                                          </a>
                                       </li>
                                       <li>
                                          <a href="#">
                                             <div class="icon-large"><i class="ri-test-tube-line"></i></i></div>
                                             Nutrition & Drinks
                                          </a>
                                       </li>
                                       <li class="has-child Beauty">
                                          <a href="#">
                                             <div class="icon-large"><i class="ri-bear-smile-line"></i></div>
                                             Beauty, Skin & Hair Care
                                             <div class="icon-small"><i class="ri-arrow-right-s-line"></i></div>
                                          </a>
                                          <div class="mega">
                                             <div class="flexcol">
                                                   <div class="row">
                                                      <h4><a href="#"></a>Skin Care</h4>
                                                      <ul>
                                                         <li><a href="#">Cream</a></li>
                                                         <li><a href="#">Lotion</a></li>
                                                         <li><a href="#">Suncreen</a></li>
                                                         <li><a href="#">Body-Wash</a></li>
                                                      </ul>
                                                   </div>
                                             </div>
                                             <div class="flexcol">
                                                   <div class="row">
                                                      <ul>
                                                         <li><a href="#">Skin Brightener</a></li>
                                                         <li><a href="#">Foot Cream</a></li>
                                                         <li><a href="#">Body Spray</a></li>
                                                         <li><a href="#">Nail Lacquer</a></li>
                                                         <li><a href="#">Night Cream</a></li>
                                                      </ul>
                                                   </div>
                                             </div>
                                             <div class="flexcol">
                                                   <div class="row">
                                                      <h4><a href="#"> Hair Care</a></h4>
                                                      <ul>
                                                         <li><a href="#">Hair Serum</a></li>
                                                         <li><a href="#">Gel</a></li>
                                                         <li><a href="#">Shampoo</a></li>
                                                         <li><a href="#">Hair Spray</a></li>
                                                      </ul>
                                                   </div>
                                             </div>
                                             <div class="flexcol">
                                                   <div class="row">
                                                      <h4><a href="#">Beauty Care</a></h4>
                                                      <ul>
                                                         <li><a href="#">Eye Cream</a></li>
                                                         <li><a href="#">Spot Cream</a></li>
                                                         <li><a href="#">Face-wash</a></li>
                                                         <li><a href="#">Lip Moisturezer</a></li>
                                                      </ul>
                                                   </div>
                                             </div>
                                          </div>
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
</div>

<main>

            <div class="single-checkout">
                <div class="container">
                    <div class="wrapper">
                        <div class="checkout flexwrap">
                            <div class="item left styled">
                                <h1>Shipping Address</h1>
                                <form action="">
                                    <p>
                                        <label for="fname">First Name <span></span></label>
                                        <input type="text" id="fname" required>
                                    </p>
                                    <p>
                                        <label for="lname">Last Name <span></span></label>
                                        <input type="text" id="lname" required>
                                    </p>
                                    <p>
                                        <label for="address">Present Address<span></span></label>
                                        <input type="text" id="address" required>
                                    </p>
                                    <p>
                                        <label for="address">Permanent Address<span></span></label>
                                        <input type="text" id="address" required>
                                    </p>
                                    <p>
                                        <label for="postal">Zip / Postal Code<span></span></label>
                                        <input type="number" id="postal" required>
                                    </p>
                                    <p>
                                        <label for="country">Country</label>
                                                            <select name="country" id="country">
                                                                <option value=""></option>
                                                                <option value="1" selected="selected">Bangladesh</option>
                                                                <option value="2">India</option>
                                                                <option value="3">United States</option>
                                                                <option value="4">Afganistan</option>
                                                                <option value="5">Pakistan</option>
                                                                <option value=""></option>
                                                            </select>
                                    </p>
                                    <p>
                                        <label for="phone">Phone Number<span></span></label>
                                        <input type="number" id="phone" placeholder="01XXXXXXXXX" required>
                                    </p>
                                    <p>
                                        <label for="email">Email Address <span></span></label>
                                        <input type="email" name="email" id="email" autocomplete="off" placeholder="Email Address" required>
                                    </p>
                                    <p>
                                        <label>Order Notes (optional)</label>
                                        <textarea cols="30" rows="10"></textarea>
                                    </p>
                                    <p class="checkset">
                                        <input type="checkbox" id="anaccount">
                                        <label for="anaccount">Create an account ?</label>
                                    </p>

                                </form>
                                <div class="shipping-methods">
                                    <h2>Shipping Methods</h2>
                                    <p class="checkset">
                                        <input type="radio" checked>
                                        <label>$5.00 Flate Rate</label>
                                    </p>
                                </div>
                                <div class="primary-checkout">
                                    <button class="primary-button">Place Order</button>
                                </div>
                            </div>
                            <div class="item right">
                                <h2>Order Summary</h2>
                                <div class="summary-order is_sticky">
                                    <div class="summary-totals">
                                        <ul>
                                            <li>
                                                <span>Subtotal</span>
                                                <span>5,254 TAKA</span>
                                            </li>
                                            <li>
                                                <span>Discount</span>
                                                <span>254 TAKA</span>
                                            </li>
                                            <li>
                                                <span>Shipping: Flat</span>
                                                <span>80 TAKA</span>
                                            </li>
                                            <li>
                                                <span>Total</span>
                                                <strong>5,080 TAKA</strong>
                                            </li>
                                        </ul>
                                    </div>
                                    <ul class="products mini">
                                        <li class="item">
                                            <div class="thumbnail object-cover">
                                                <img src="/assets/products/provair 10.jpg" alt="">
                                            </div>
                                            <div class="item-content">
                                                <p>Povair 10mg</p>
                                                <span class="price">
                                                    <span>480 TAKA</span>
                                                    <span>x 2</span>
                                                </span>
                                            </div>
                                        </li>
                                        <li class="item">
                                            <div class="thumbnail object-cover">
                                                <img src="/assets/products/device4.jpg" alt="">
                                            </div>
                                            <div class="item-content">
                                                <p>Sinocare Blood Sugar Tester</p>
                                                <span class="price">
                                                    <span>950 TAKA</span>
                                                    <span>x 1</span>
                                                </span>
                                            </div>
                                        </li>
                                        <li class="item">
                                            <div class="thumbnail object-cover">
                                                <img src="/assets/products/cef 3.jpg" alt="">
                                            </div>
                                            <div class="item-content">
                                                <p>Cef 3</p>
                                                <span class="price">
                                                    <span>492 TAKA</span>
                                                    <span>x 2</span>
                                                </span>
                                            </div>
                                        </li>
                                        <li class="item">
                                            <div class="thumbnail object-cover">
                                                <img src="/assets/products/vatamin2.jpg" alt="">
                                            </div>
                                            <div class="item-content">
                                                <p>
                                                    Syalox 300 Plus</p>
                                                <span class="price">
                                                    <span>1,180 TAKA</span>
                                                    <span>x 2</span>
                                                </span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

<section class="display-order">

   <?php  
      $grand_total = 0;
      $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
      if(mysqli_num_rows($select_cart) > 0){
         while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total += $total_price;
   ?>
   <p> <?php echo $fetch_cart['name']; ?> <span>(<?php echo '$'.$fetch_cart['price'].'/-'.' x '. $fetch_cart['quantity']; ?>)</span> </p>
   <?php
      }
   }else{
      echo '<p class="empty">your cart is empty</p>';
   }
   ?>
   <div class="grand-total"> grand total : <span>$<?php echo $grand_total; ?>/-</span> </div>

</section>

<section class="checkout">

   <form action="" method="post">
      <h3>place your order</h3>
      <div class="flex">
         <div class="inputBox">
            <span>your name :</span>
            <input type="text" name="name" required placeholder="enter your name">
         </div>
         <div class="inputBox">
            <span>your number :</span>
            <input type="number" name="number" required placeholder="enter your number">
         </div>
         <div class="inputBox">
            <span>your email :</span>
            <input type="email" name="email" required placeholder="enter your email">
         </div>
         <div class="inputBox">
            <span>payment method :</span>
            <select name="method">
               <option value="cash on delivery">cash on delivery</option>
               <option value="credit card">credit card</option>
               <option value="paypal">paypal</option>
               <option value="paytm">paytm</option>
            </select>
         </div>
         <div class="inputBox">
            <span>address line 01 :</span>
            <input type="number" min="0" name="flat" required placeholder="e.g. flat no.">
         </div>
         <div class="inputBox">
            <span>address line 01 :</span>
            <input type="text" name="street" required placeholder="e.g. street name">
         </div>
         <div class="inputBox">
            <span>city :</span>
            <input type="text" name="city" required placeholder="e.g. mumbai">
         </div>
         <div class="inputBox">
            <span>state :</span>
            <input type="text" name="state" required placeholder="e.g. maharashtra">
         </div>
         <div class="inputBox">
            <span>country :</span>
            <input type="text" name="country" required placeholder="e.g. india">
         </div>
         <div class="inputBox">
            <span>pin code :</span>
            <input type="number" min="0" name="pin_code" required placeholder="e.g. 123456">
         </div>
      </div>
      <input type="submit" value="order now" class="btn" name="order_btn">
   </form>

</section>









<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fslightbox/3.3.1/index.js"></script>
<script src="js/script.js"></script>
<script src="script.js"></script>

</body>
</html>