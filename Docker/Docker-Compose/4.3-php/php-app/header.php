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

<div id="page" class="site page-home">
        <aside class="site-off desktop-hide">
            <div class="off-canvas">
                <div class="canvas-head flexitem">
                    <div class="logo"><a href="home.php"><span class="circle"></span>Me<span class="logocolor">diH</span>elp</a></div>
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
                            <?php
                            	$select_user = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$user_id'") or die('query failed');
                                if(mysqli_num_rows($select_user) > 0){
                                    $fetch_user = mysqli_fetch_assoc($select_user); 
                                };
                            ?>
                                <li><p><span><?php echo $fetch_user['name']; ?><i class="ri-arrow-down-s-line"></i></span></p>
                                <ul>
                                        <li><a href="login.php?logout=<?php echo $user_id; ?>" onclick="return confirm('Are you sure, You want to logout?');">Logout</a></li>
                                        <li><a href="register.php">Register</a></li>
                                    </ul>
                                </li>
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
        </header>
        
        
        <div class="header-nav">
            <div class="container">
                <div class="wrapper flexitem">
                    <a href="#" class="trigger dexktop-hide"><span class="i ri-menu-2-line"></span></a>
                    <div class="lift flexitem">
                        <div class="logo"><a href="home.php"><span class="circle"></span>Me<span class="logocolor">diH</span>elp</a></div>
                        <nav class="mobile-hide">
                            <ul class="flexitem second-links">
                                <li><a href="home.php">Home</a></li>
                                <li class="has-child">
                                    <a href="contact.php">Contact</a>
                                </li>
                                <li class="has-child">
                                    <a href="orders.php">Orders</a>
                                </li>
                                <li><a href="about.php">About</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="right">
                           <ul class="flexitem second-link">
                            <li><a href="cart.php" class="iscart" style="display:flex; justify-content: speach-between;">
                                    <div class="icon-large">
                                          <?php
                                             $select_cart_number = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
                                             $cart_rows_number = mysqli_num_rows($select_cart_number); 
                                          ?>
                                          <i class="ri-shopping-cart-line"></i>
                                          <div class="fly-item">
                                             <span class="item-number"><?php echo $cart_rows_number; ?></span>
                                          </div>
                                    </div>
                                    <div class="icon-text" >
                                          <div class="mini-text">Total</div>
                                    </div>
                                 </a>
                              </li>
                           </ul>
                    </div>
                </div>
            </div>
        </div>
      </div>
