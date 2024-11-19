<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['update_cart'])){
   $cart_id = $_POST['cart_id'];
   $cart_quantity = $_POST['cart_quantity'];
   mysqli_query($conn, "UPDATE `cart` SET quantity = '$cart_quantity' WHERE id = '$cart_id'") or die('query failed');
   $message[] = 'cart quantity updated!';
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$delete_id'") or die('query failed');
   header('location:cart.php');
}

if(isset($_GET['delete_all'])){
   mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   header('location:cart.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>cart</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css">
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
            <div class="single-cart">
                <div class="container">
                    <div class="wrapper">
                        <div class="page-title ">
                            <h1>Shopping Cart <br> </h1>
                        </div>
                        <div class="products one cart">
                            <div class="flexwrap">
                                <form action="" class="form-cart" style=" width: 100%;">
                                    <div class="item">
                                        <table id="cart-table">  
                                            <thead>
                                                <tr>
                                                    <th>Item</th>
                                                    <th>Price</th>
                                                    <th>Qty</th>
                                                    <th>Update</th>
                                                    <th>Subtotal</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                             <?php
                                                $grand_total = 0;
                                                $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
                                                if(mysqli_num_rows($select_cart) > 0){
                                                   while($fetch_cart = mysqli_fetch_assoc($select_cart)){   
                                             ?>
                                            <tbody>
                                            <form action="" method="post">
                                                <tr>
                                                    <td class="flexitem">
                                                        <div class="thumbnail object-cover">
                                                            <a href="#"><img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" alt=""></a>
                                                        </div>
                                                        <div class="content">
                                                            <strong><a href="#"><?php echo $fetch_cart['name']; ?></a></strong>
                                                        </div>
                                                    </td>
                                                    <td><?php echo $fetch_cart['price']; ?> TAKA</td>
                                                    <td>
                                                      <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
                                                      <input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>" style="width:70px; height: 15px; font-size: 13px; font-weight: bold;">
                                                    </td>
                                                    <td>
                                                      <input type="submit" name="update_cart" value="update" class="option-btn" style="width:70px; font-size: 15px; font-weight: bold; padding: 5px; background-color: #453c5c;">
                                                    </td>
                                                    <td><?php echo $sub_total = ($fetch_cart['quantity'] * $fetch_cart['price']); ?> TAKA</td>
                                                    <td><a href="cart.php?delete=<?php echo $fetch_cart['id']; ?>" class="ri-close-line" onclick="return confirm('delete this from cart?');"></a></td>
                                                </tr>
                                            </form>
                                            </tbody>
                                            <?php
                                                $grand_total += $sub_total;
                                                   }
                                                }else{
                                                   echo '<p class="empty">your cart is empty</p>';
                                                }
                                             ?>
                                        </table>
                                    </div>
                                </form>
                                <div class="cart-summary styled" style="width:100%; padding-left:0; padding-top:1.5em;">
                                    <div class="item">
                                        <div class="coupon">
                                            <input type="text" placeholder="Enter Coupon">
                                            <button>Apply</button>
                                        </div>
                                        <div class="cart-total">
                                            <table>
                                                <tbody>
                                                    <tr class="grand-total">
                                                        <th>TOTAL</th>
                                                        <td style="font-size: small;"><strong><?php echo $grand_total; ?> TAKA</strong></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div style="margin: 10px; padding: 10px;">
                                          <a href="checkout.php" class="secondary-button <?php echo ($grand_total > 1)?'':'disabled'; ?>" padding="15px">Checkout</a>
                                          <a href="cart.php?delete_all" class="secondary-button <?php echo ($grand_total > 1)?'':'disabled'; ?>" onclick="return confirm('delete all from cart?');">Delete All</a>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/fslightbox/3.3.1/index.js"></script>
<script src="js/script.js"></script>
<script src="script.js"></script>

</body>
</html>