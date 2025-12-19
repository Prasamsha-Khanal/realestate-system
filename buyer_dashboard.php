<?php
include 'components/connect.php';

// Check if user is logged in
if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   header('location:login.php');
   exit;
}

// Fetch user info
$select_user = $conn->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
$select_user->execute([$user_id]);
$user = $select_user->fetch(PDO::FETCH_ASSOC);

if(!$user){
    header('location:login.php');
    exit;
}
// Count saved properties
$count_saved = $conn->prepare("SELECT * FROM saved WHERE user_id = ?");
$count_saved->execute([$user_id]);
$total_saved = $count_saved->rowCount();

// Count requests sent
$count_sent = $conn->prepare("SELECT * FROM requests WHERE sender = ?");
$count_sent->execute([$user_id]);
$total_sent = $count_sent->rowCount();

// Count requests received
$count_received = $conn->prepare("SELECT * FROM requests WHERE receiver = ?");
$count_received->execute([$user_id]);
$total_received = $count_received->rowCount();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Buyer Dashboard</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'components/user_header.php'; ?>

<section class="dashboard">

   <h1 class="heading">Buyer Dashboard</h1>

   <div class="box-container">

      <!-- PROFILE -->
      <div class="box">
         <h3>Welcome!</h3>
         <p><?= htmlspecialchars($user['name']); ?></p>
         <a href="update.php" class="btn">Update Profile</a>
      </div>

      <!-- SEARCH PROPERTIES -->
      <div class="box">
         <h3>Filter Search</h3>
         <p>Search your dream property</p>
         <a href="search.php" class="btn">Search Now</a>
      </div>

      <!-- SAVED PROPERTIES -->
      <div class="box">
         <?php
            $count_saved = $conn->prepare("SELECT * FROM saved WHERE user_id = ?");
            $count_saved->execute([$user_id]);
         ?>
         <h3><?= $count_saved->rowCount(); ?></h3>
         <p>Properties Saved</p>
         <a href="saved.php" class="btn">View Saved Properties</a>
      </div>

      <!-- REQUESTS SENT -->
      <div class="box">
         <?php
            $count_requests_sent = $conn->prepare("SELECT * FROM requests WHERE sender = ?");
            $count_requests_sent->execute([$user_id]);
         ?>
         <h3><?= $count_requests_sent->rowCount(); ?></h3>
         <p>Requests Sent</p>
         <a href="sent_requests.php" class="btn">View Sent Requests</a>
      </div>

   </div>

</section>

<?php include 'components/footer.php'; ?>
<script src="js/script.js"></script>
<?php include 'components/message.php'; ?>

</body>
</html>
