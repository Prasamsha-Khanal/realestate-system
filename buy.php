<?php  
include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
} else {
   $user_id = '';
   header('location:login.php');
   exit();
}

include 'components/buy_send.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>My Bought Properties</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="listings">
   <h1 class="heading">My Bought Properties</h1>

   <div class="box-container">
      <?php
         try {
            $select_purchases = $conn->prepare("
               SELECT 
                   p.id AS purchase_id,
                   p.created_at,
                   prop.*,
                   u.name AS seller_name,
                   u.id AS seller_user_id
               FROM purchases p 
               JOIN property prop ON p.property_id = prop.id 
               JOIN users u ON prop.user_id = u.id 
               WHERE p.buyer_id = ? 
                 AND p.status = 'completed'
               ORDER BY p.created_at DESC
            ");
            $select_purchases->execute([$user_id]);

            if($select_purchases->rowCount() > 0){
               while($fetch = $select_purchases->fetch(PDO::FETCH_ASSOC)){
                  $property = $fetch;
                  $seller_name = $fetch['seller_name'];
                  $seller_id = $fetch['seller_user_id'];
                  $purchase_date = $fetch['created_at'];

                  // Count images
                  $total_images = 1;
                  for($i = 2; $i <= 5; $i++){
                     if(!empty($property["image_0" . $i])) $total_images++;
                  }
      ?>
      <div class="box">
         <div class="thumb">
            <p class="total-images"><i class="far fa-image"></i><span><?= $total_images; ?></span></p> 
            <img src="uploaded_files/<?= htmlspecialchars($property['image_01']); ?>" alt="property">
            <div class="status-tag" style="background:#27ae60;color:white;padding:5px 10px;border-radius:5px;position:absolute;top:10px;left:10px;font-size:12px;">
               PURCHASED
            </div>
         </div>

         <div class="admin">
            <h3><?= htmlspecialchars(substr($seller_name, 0, 1)); ?></h3>
            <div>
               <p>Seller: <?= htmlspecialchars($seller_name); ?></p>
               <span>Purchased on: <?= date('d M Y', strtotime($purchase_date)); ?></span>
            </div>
         </div>

         <div class="price"><i class="fas fa-nepali-rupee-sign"></i><span><?= number_format($property['price']); ?></span></div>
         <h3 class="name"><?= htmlspecialchars($property['property_name']); ?></h3>
         <p class="location"><i class="fas fa-map-marker-alt"></i><span><?= htmlspecialchars($property['address']); ?></span></p>

         <div class="flex">
            <p><i class="fas fa-house"></i><span><?= htmlspecialchars($property['type']); ?></span></p>
            <p><i class="fas fa-bed"></i><span><?= $property['bhk']; ?> BHK</span></p>
            <p><i class="fas fa-trowel"></i><span><?= htmlspecialchars($property['status']); ?></span></p>
            <p><i class="fas fa-couch"></i><span><?= htmlspecialchars($property['furnished']); ?></span></p>
            <p><i class="fas fa-maximize"></i><span><?= $property['carpet']; ?> sqft</span></p>
         </div>

         <div class="flex-btn">
            <a href="view_property.php?get_id=<?= $property['id']; ?>" class="btn">View Property</a>
            <a href="contact_seller.php?seller_id=<?= $seller_id; ?>&property_id=<?= $property['id']; ?>" class="btn" style="background:#095e82;">Message Seller</a>
         </div>
      </div>
      <?php
               }
            } else {
               echo '<p class="empty">You haven\'t bought any properties yet! <a href="listings.php" style="margin-top:1.5rem;" class="btn">Explore Properties</a></p>';
            }
         } catch(PDOException $e) {
            echo '<p class="empty">Error loading purchases. Please try again later.</p>';
            // Optional: log error for admin
            error_log("Purchase query failed: " . $e->getMessage());
         }
      ?>
   </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<?php include 'components/footer.php'; ?>
<script src="js/script.js"></script>
<?php include 'components/message.php'; ?>

</body>
</html>