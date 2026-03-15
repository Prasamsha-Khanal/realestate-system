<?php  
include 'components/connect.php';

// Check if user is logged in
if (!isset($_COOKIE['user_id'])) {
   header('location:login.php');
   exit;
}

$user_id = $_COOKIE['user_id'];

// Fetch user info
$select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ? LIMIT 1");
$select_user->execute([$user_id]);
$user = $select_user->fetch(PDO::FETCH_ASSOC);

if (!$user) {
   header('location:login.php');
   exit;
}

// Important Fix: Your column is 'type', not 'role'
$user_type = $user['type'] ?? 'buyer';

// Only allow sellers to access this dashboard
if ($user_type !== 'seller') {
   header('location:home.php'); // or create a buyer_dashboard.php later
   exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Seller Dashboard</title>

   <!-- Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- Your original CSS - NO CHANGES MADE -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'components/user_header.php'; ?>

<section class="dashboard">

   <h1 class="heading">Seller Dashboard 🏠</h1>

   <div class="box-container">

      <!-- Welcome Box -->
      <div class="box">
         <h3>Welcome Back!</h3>
         <p><?= htmlspecialchars($user['name']); ?></p>
         <a href="update.php" class="btn">Update Profile</a>
      </div>

      <!-- Total Properties Listed by Seller -->
      <div class="box">
         <?php
            $count_properties = $conn->prepare("SELECT * FROM `property` WHERE user_id = ?");
            $count_properties->execute([$user_id]);
            $total_properties = $count_properties->rowCount();
         ?>
         <h3><?= $total_properties; ?></h3>
         <p>Total Properties Listed</p>
         <a href="my_listings.php" class="btn">View My Listings</a>
      </div>

      <!-- Total Requests Received -->
      <div class="box">
         <?php
            $count_requests = $conn->prepare("SELECT * FROM `requests` WHERE receiver = ?");
            $count_requests->execute([$user_id]);
            $total_requests = $count_requests->rowCount();
         ?>
         <h3><?= $total_requests; ?></h3>
         <p>Requests Received</p>
         <a href="requests.php" class="btn">View All Requests</a>
      </div>

      <!-- Pending Requests -->
      <div class="box">
         <?php
            // Count requests received (without status column)
            $count_pending = $conn->prepare("SELECT * FROM `requests` WHERE receiver = ?");
            $count_pending->execute([$user_id]);
            $pending_count = $count_pending->rowCount();
         ?>
         <h3><?= $pending_count; ?></h3>
         <p>All Requests</p>
         <a href="requests.php" class="btn">View All Requests</a>
      </div>

      <!-- Properties Saved by Buyers (How many times your listings were saved) -->
      <!-- <div class="box">
         <?php
            $count_saved = $conn->prepare("
               SELECT COUNT(*) 
               FROM `saved` s 
               INNER JOIN `property` p ON s.property_id = p.id 
               WHERE p.user_id = ?
            ");
            $count_saved->execute([$user_id]);
            $saved_count = $count_saved->fetchColumn();
         ?>
         <h3><?= $saved_count; ?></h3>
         <p>Your Properties Saved by Buyers</p>
         <a href="my_listings.php" class="btn">View Listings</a>
      </div> -->

      <!-- Quick Action: Post New Property -->
      <div class="box">
         <h1>Post New Property</h1>
         <p>Add a new house, apartment, or land</p>
         <a href="post_property.php" class="btn">Post Property Now</a>
      </div>

   </div>

</section>

<?php include 'components/footer.php'; ?>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="js/script.js"></script>
<?php include 'components/message.php'; ?>

</body>
</html>