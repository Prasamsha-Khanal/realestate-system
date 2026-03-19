<?php  
include 'components/connect.php';

if(!isset($_COOKIE['user_id'])){
    header('location:login.php');
    exit;
}

$user_id = $_COOKIE['user_id'];

// Get user type from cookie
$user_type = isset($_COOKIE['user_type']) ? $_COOKIE['user_type'] : '';

// Only sellers can access this dashboard
if($user_type !== 'seller'){
    header('location:home.php');
    exit;
}

// Fetch from sellers table
$select_user = $conn->prepare("SELECT * FROM `sellers` WHERE id = ? LIMIT 1");
$select_user->execute([$user_id]);
$user = $select_user->fetch(PDO::FETCH_ASSOC);

if(!$user){
    header('location:login.php');
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'components/user_header.php'; ?>

<section class="dashboard">
    <h1 class="heading">Seller Dashboard 🏠</h1>
    <div class="box-container">

        <div class="box">
            <h3>Welcome Back!</h3>
            <p><?= htmlspecialchars($user['name']); ?></p>
            <a href="update.php" class="btn">Update Profile</a>
        </div>

        <div class="box">
            <?php
                $count_properties = $conn->prepare("SELECT * FROM `property` WHERE user_id = ? AND approved = 1");
                $count_properties->execute([$user_id]);
                $total_properties = $count_properties->rowCount();
            ?>
            <h3><?= $total_properties; ?></h3>
            <p>Total Properties Listed</p>
            <a href="my_listings.php" class="btn">View My Listings</a>
        </div>

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

        <div class="box">
            <h1>Post New Property</h1>
            <p>Add a new house, apartment, or land</p>
            <a href="post_property.php" class="btn">Post Property Now</a>
        </div>

    </div>
</section>

<?php include 'components/footer.php'; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="js/script.js"></script>
<?php include 'components/message.php'; ?>
</body>
</html>