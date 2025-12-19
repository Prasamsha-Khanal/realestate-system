<?php  
include 'components/connect.php';

// Check if user is logged in
if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   header('location:login.php');
   exit;
}

// Fetch user info including role
$select_user = $conn->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
$select_user->execute([$user_id]);
$user = $select_user->fetch(PDO::FETCH_ASSOC);

if(!$user){
    header('location:login.php');
    exit;
}

$role = $user['role']; // buyer or seller
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dashboard</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'components/user_header.php'; ?>

<section class="dashboard">

   <h1 class="heading">Dashboard</h1>

   <div class="box-container">

      <!-- PROFILE (all users) -->
      <div class="box">
         <h3>Welcome!</h3>
         <p><?= htmlspecialchars($user['name']); ?></p>
         <a href="update.php" class="btn">Update Profile</a>
      </div>

      <?php if($role == 'buyer'): ?>
      <!-- BUYER SECTIONS -->
      <div class="box">
         <h3>Filter Search</h3>
         <p>Search your dream property</p>
         <a href="search.php" class="btn">Search Now</a>
      </div>

      <div class="box">
         <?php
            $count_saved = $conn->prepare("SELECT * FROM saved WHERE user_id = ?");
            $count_saved->execute([$user_id]);
         ?>
         <h3><?= $count_saved->rowCount(); ?></h3>
         <p>Properties Saved</p>
         <a href="saved.php" class="btn">View Saved Properties</a>
      </div>

      <div class="box">
         <?php
            $count_requests_sent = $conn->prepare("SELECT * FROM requests WHERE sender = ?");
            $count_requests_sent->execute([$user_id]);
         ?>
         <h3><?= $count_requests_sent->rowCount(); ?></h3>
         <p>Requests Sent</p>
         <a href="sent_requests.php" class="btn">View Sent Requests</a>
      </div>

      <?php elseif($role == 'seller'): ?>
      <!-- SELLER SECTIONS -->
      <div class="box">
         <?php
            $count_properties = $conn->prepare("SELECT * FROM property WHERE user_id = ?");
            $count_properties->execute([$user_id]);
         ?>
         <h3><?= $count_properties->rowCount(); ?></h3>
         <p>Properties Listed</p>
         <a href="my_listings.php" class="btn">View Listings</a>
      </div>

      <div class="box">
         <?php
            $count_requests_received = $conn->prepare("SELECT * FROM requests WHERE receiver = ?");
            $count_requests_received->execute([$user_id]);
         ?>
         <h3><?= $count_requests_received->rowCount(); ?></h3>
         <p>Requests Received</p>
         <a href="requests.php" class="btn">View Requests</a>
      </div>
      <?php endif; ?>

   </div>

</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<?php include 'components/footer.php'; ?>
<script src="js/script.js"></script>
<?php include 'components/message.php'; ?>

</body>
</html>
