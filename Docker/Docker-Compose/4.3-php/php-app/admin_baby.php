<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['add_product'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $gname = mysqli_real_escape_string($conn, $_POST['gname']);
   $oprice = $_POST['oprice'];
   $price = $_POST['price'];
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;

   $select_product_name = mysqli_query($conn, "SELECT name FROM `baby` WHERE name = '$name'") or die('query failed');

   if(mysqli_num_rows($select_product_name) > 0){
      $message[] = 'Product name already added';
   }else{
      $add_product_query = mysqli_query($conn, "INSERT INTO `baby`(name, gname, oprice, price, image) VALUES('$name', '$gname', '$oprice', '$price', '$image')") or die('query failed');

      if($add_product_query){
         if($image_size > 20000000){
            $message[] = 'image size is too large';
         }else{
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'Product added Successfully!';
         }
      }else{
         $message[] = 'Product Could not be Added!';
      }
   }
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_image_query = mysqli_query($conn, "SELECT image FROM `baby` WHERE id = '$delete_id'") or die('query failed');
   $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
   unlink('uploaded_img/'.$fetch_delete_image['image']);
   mysqli_query($conn, "DELETE FROM `baby` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_baby.php');
}

if(isset($_POST['update_product'])){

   $update_p_id = $_POST['update_p_id'];
   $update_name = $_POST['update_name'];
   $update_gname = $_POST['update_gname'];
   $update_oprice = $_POST['update_oprice'];
   $update_price = $_POST['update_price'];

   mysqli_query($conn, "UPDATE `baby` SET name = '$update_name', gname = '$update_gname', oprice = '$update_oprice', price = '$update_price' WHERE id = '$update_p_id'") or die('query failed');

   $update_image = $_FILES['update_image']['name'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_folder = 'uploaded_img/'.$update_image;
   $update_old_image = $_POST['update_old_image'];

   if(!empty($update_image)){
      if($update_image_size > 2000000){
         $message[] = 'Image file size is too large';
      }else{
         mysqli_query($conn, "UPDATE `baby` SET image = '$update_image' WHERE id = '$update_p_id'") or die('query failed');
         move_uploaded_file($update_image_tmp_name, $update_folder);
         unlink('uploaded_img/'.$update_old_image);
      }
   }

   header('location:admin_baby.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>
<?php include 'admin_header1.php'; ?>

<!-- product CRUD section starts  -->

<section class="add-products">

      <div style="text-align:center;">
         <?php 
            $select_baby = mysqli_query($conn, "SELECT * FROM `baby`") or die('query failed');
            $number_of_products = mysqli_num_rows($select_baby);
         ?>
         <p style="font-size: 40px; font-weight: bolder; padding-bottom: 10px; color: #333;">Total</p>
         <h1 style="font-size: 30px; padding-bottom: 10px; color: #333;"><?php echo $number_of_products; ?></h1>
      </div>
   <h1 class="title">baby products</h1>

   <form action="" method="post" enctype="multipart/form-data">
      <h3>add product</h3>
      <input type="text" name="name" class="box" placeholder="Enter Product Name" required>
      <input type="text" name="gname" class="box" placeholder="Enter Product Generic Name" style="font-style: italic;">
      <input type="number" min="0" name="oprice" class="box" placeholder="Enter Product Offer Price" required>
      <input type="number" min="0" name="price" class="box" placeholder="Enter Product Price" required>
      <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" required>
      <input type="submit" value="add product" name="add_product" class="btn">
   </form>

</section>

<!-- product CRUD section ends -->

<!-- show products  -->

<section class="show-products">

   <div class="box-container">

      <?php
         $select_baby = mysqli_query($conn, "SELECT * FROM `baby`") or die('query failed');
         if(mysqli_num_rows($select_baby) > 0){
            while($fetch_baby = mysqli_fetch_assoc($select_baby)){
      ?>
      <div class="box">
         <img src="uploaded_img/<?php echo $fetch_baby['image']; ?>" alt="">
         <div class="name"><?php echo $fetch_baby['name']; ?></div>
         <div class="name" style="font-style: italic; font-size:15px; "><?php echo $fetch_baby['gname']; ?></div>
         <div class="price" style=" padding: 0.2rem 0; "><p style=" font-size: 2rem; font-weight: bolder;">Offer Price</p></div>
         <div class="price">BDT <?php echo $fetch_baby['oprice']; ?> TAKA</div>
         <div class="price" style=" padding: 0.2rem 0; "><p style=" font-size: 2rem; font-weight: bolder;">Price</p></div>
         <div class="price">BDT <?php echo $fetch_baby['price']; ?> TAKA</div>
         <a href="admin_baby.php?update=<?php echo $fetch_baby['id']; ?>" class="option-btn">update</a>
         <a href="admin_baby.php?delete=<?php echo $fetch_baby['id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">No products added yet!</p>';
      }
      ?>
   </div>

</section>

<section class="edit-product-form">

   <?php
      if(isset($_GET['update'])){
         $update_id = $_GET['update'];
         $update_query = mysqli_query($conn, "SELECT * FROM `baby` WHERE id = '$update_id'") or die('query failed');
         if(mysqli_num_rows($update_query) > 0){
            while($fetch_update = mysqli_fetch_assoc($update_query)){
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id']; ?>">
      <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['image']; ?>">
      <img src="uploaded_img/<?php echo $fetch_update['image']; ?>" alt="">
      <input type="text" name="update_name" value="<?php echo $fetch_update['name']; ?>" class="box" required placeholder="Enter product name">
      <input type="text" name="update_name" value="<?php echo $fetch_update['gname']; ?>" class="box" required placeholder="Enter product generic name" style="font-style: italic;">
      <input type="number" name="update_oprice" value="<?php echo $fetch_update['oprice']; ?>" min="0" class="box" required placeholder="Enter product offer price">
      <input type="number" name="update_price" value="<?php echo $fetch_update['price']; ?>" min="0" class="box" required placeholder="Enter product price">
      <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
      <input type="submit" value="update" name="update_product" class="btn">
      <input type="reset" value="cancel" id="close-update" class="option-btn">
   </form>
   <?php
         }
      }
      }else{
         echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
      }
   ?>

</section>







<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>