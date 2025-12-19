<?php
include 'components/connect.php';

if(!isset($_COOKIE['user_id']) || $_COOKIE['user_id'] == ''){
    header('Location: login.php');
    exit();
}

$buyer_id = $_COOKIE['user_id'];
$seller_id = isset($_GET['seller_id']) ? $_GET['seller_id'] : '';
$property_id = isset($_GET['property_id']) ? $_GET['property_id'] : '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';

    // Simple validation
    if($subject == '' || $message == ''){
        $warning = "Please fill all fields.";
    } else {
        // optionally fetch buyer info to include name/email/number (if stored in users table)
        $u = $conn->prepare("SELECT name,email,number FROM users WHERE id = ? LIMIT 1");
        $u->execute([$buyer_id]);
        $buyer = $u->fetch(PDO::FETCH_ASSOC);

        $insert = $conn->prepare("INSERT INTO messages (id, name, email, number, message) VALUES (?, ?, ?, ?, ?)");
        $msg_id = uniqid('msg_');

        $full_message = "Regarding property: $property_id\nFrom buyer id: $buyer_id\n\nSubject: $subject\n\n$message";

        if($insert->execute([$msg_id, $buyer['name'] ?? 'Buyer', $buyer['email'] ?? '', $buyer['number'] ?? '', $full_message])){
            $success = "Message sent to seller successfully.";
        } else {
            $warning = "Failed to send message. Try later.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Contact Seller</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'components/user_header.php'; ?>

<div class="container" style="max-width:700px;margin:40px auto;">
   <h2>Contact Seller</h2>
   <?php if(!empty($success)) echo '<p class="success-msg">'.$success.'</p>'; ?>
   <?php if(!empty($warning)) echo '<p class="warning-msg">'.$warning.'</p>'; ?>

   <form method="POST">
      <label>Subject</label>
      <input type="text" name="subject" required>

      <label>Message</label>
      <textarea name="message" rows="6" required></textarea>

      <button type="submit" class="btn">Send Message</button>
   </form>
</div>

<?php include 'components/footer.php'; ?>
</body>
</html>
