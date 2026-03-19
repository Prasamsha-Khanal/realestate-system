<?php  
include 'components/connect.php';

if(!isset($_COOKIE['user_id'])){
    header('location:login.php');
    exit;
}

$user_id = $_COOKIE['user_id'];

// Get user type from cookie
$user_type = isset($_COOKIE['user_type']) ? $_COOKIE['user_type'] : '';

// Only buyers can access this dashboard
if($user_type !== 'buyer'){
    header('location:home.php');
    exit;
}

// Fetch from buyers table
$select_user = $conn->prepare("SELECT * FROM `buyers` WHERE id = ? LIMIT 1");
$select_user->execute([$user_id]);
$user = $select_user->fetch(PDO::FETCH_ASSOC);

if(!$user){
    header('location:login.php');
    exit;
}

// Buyer Statistics
$total_saved = 0;
$total_requests_sent = 0;
$total_purchases = 0;
$spent_amount = 0;

try {
    $count_saved = $conn->prepare("SELECT * FROM `saved` WHERE user_id = ?");
    $count_saved->execute([$user_id]);
    $total_saved = $count_saved->rowCount();
} catch (PDOException $e) {
    $total_saved = 0;
}

try {
    $count_requests_sent = $conn->prepare("SELECT * FROM `requests` WHERE sender = ?");
    $count_requests_sent->execute([$user_id]);
    $total_requests_sent = $count_requests_sent->rowCount();
} catch (PDOException $e) {
    $total_requests_sent = 0;
}

try {
    $count_purchases = $conn->prepare("SELECT COUNT(*) FROM `purchases` WHERE buyer_id = ? AND status = 'completed'");
    $count_purchases->execute([$user_id]);
    $total_purchases = $count_purchases->fetchColumn();
} catch (PDOException $e) {
    $total_purchases = 0;
}

try {
    $total_spent = $conn->prepare("
        SELECT SUM(prop.price) 
        FROM `purchases` p 
        JOIN `property` prop ON p.property_id = prop.id 
        WHERE p.buyer_id = ? AND p.status = 'completed'
    ");
    $total_spent->execute([$user_id]);
    $spent_amount = $total_spent->fetchColumn() ?? 0;
} catch (PDOException $e) {
    $spent_amount = 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'components/user_header.php'; ?>

<section class="dashboard">
    <h1 class="heading">Buyer Dashboard 🏠</h1>
    <div class="box-container">

        <div class="box">
            <h3>Welcome Back!</h3>
            <p><?= htmlspecialchars($user['name']); ?></p>
            <a href="update.php" class="btn">Update Profile</a>
        </div>

        <!-- <div class="box">
            <h3><?= $total_requests_sent; ?></h3>
            <p>Inquiries Sent</p>
            <a href="sent_requests.php" class="btn">View Sent Requests</a>
        </div> -->

        <div class="box">
            <h3><?= $total_purchases; ?></h3>
            <p>Properties Purchased</p>
            <a href="view_purchases.php" class="btn">View Purchases</a>
        </div>

        <div class="box">
            <h3>Rs. <?= number_format($spent_amount); ?></h3>
            <p>Total Investment</p>
            <a href="view_purchases.php" class="btn">View Details</a>
        </div>

        <div class="box">
            <h3>Search Properties</h3>
            <p>Find your dream home</p>
            <a href="search.php" class="btn">Search Now</a>
        </div>

        <div class="box">
            <h3>Browse Listings</h3>
            <p>Explore all available properties</p>
            <a href="listings.php" class="btn">Browse All</a>
        </div>

    </div>
</section>

<?php include 'components/footer.php'; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="js/script.js"></script>
<?php include 'components/message.php'; ?>
</body>
</html>