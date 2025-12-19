
<?php
include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
   header('location:login.php');
}

if(isset($_POST['post'])){
    $id = create_unique_id();
   $property_name = $_POST['property_name'];
   $property_name = filter_var($property_name, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $deposite = $_POST['deposite'];
   $deposite = filter_var($deposite, FILTER_SANITIZE_STRING);
   $address = $_POST['address'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $offer = $_POST['offer'];
   $offer = filter_var($offer, FILTER_SANITIZE_STRING);
   $type = $_POST['type'];
   $type = filter_var($type, FILTER_SANITIZE_STRING);
   $status = $_POST['status'];
   $status = filter_var($status, FILTER_SANITIZE_STRING);
   $furnished = $_POST['furnished'];
   $furnished = filter_var($furnished, FILTER_SANITIZE_STRING);
   $bhk = $_POST['bhk'];
   $bhk = filter_var($bhk, FILTER_SANITIZE_STRING);
   $bedroom = $_POST['bedroom'];
   $bedroom = filter_var($bedroom, FILTER_SANITIZE_STRING);
   $bathroom = $_POST['bathroom'];
   $bathroom = filter_var($bathroom, FILTER_SANITIZE_STRING);
   $balcony = $_POST['balcony'];
   $balcony = filter_var($balcony, FILTER_SANITIZE_STRING);
   $carpet = $_POST['carpet'];
   $carpet = filter_var($carpet, FILTER_SANITIZE_STRING); 
   $age = $_POST['age'];
   $age = filter_var($age, FILTER_SANITIZE_STRING);
   $total_floors = $_POST['total_floors'];
   $total_floors = filter_var($total_floors, FILTER_SANITIZE_STRING);
   $room_floor = $_POST['room_floor'];
   $room_floor = filter_var($room_floor, FILTER_SANITIZE_STRING);
   $loan = $_POST['loan'];
   $loan = filter_var($loan, FILTER_SANITIZE_STRING);
   $description = $_POST['description'];
   $description = filter_var($description, FILTER_SANITIZE_STRING);

   if(isset($_POST['lift'])){
      $lift = $_POST['lift'];
      $lift = filter_var($lift, FILTER_SANITIZE_STRING);
   }else{
      $lift = 'no';
   }
   if(isset($_POST['security_guard'])){
      $security_guard = $_POST['security_guard'];
      $security_guard = filter_var($security_guard, FILTER_SANITIZE_STRING);
   }else{
      $security_guard = 'no';
   }
   if(isset($_POST['play_ground'])){
      $play_ground = $_POST['play_ground'];
      $play_ground = filter_var($play_ground, FILTER_SANITIZE_STRING);
   }else{
      $play_ground = 'no';
   }
   if(isset($_POST['garden'])){
      $garden = $_POST['garden'];
      $garden = filter_var($garden, FILTER_SANITIZE_STRING);
   }else{
      $garden = 'no';
   }
   if(isset($_POST['water_supply'])){
      $water_supply = $_POST['water_supply'];
      $water_supply = filter_var($water_supply, FILTER_SANITIZE_STRING);
   }else{
      $water_supply = 'no';
   }
   if(isset($_POST['power_backup'])){
      $power_backup = $_POST['power_backup'];
      $power_backup = filter_var($power_backup, FILTER_SANITIZE_STRING);
   }else{
      $power_backup = 'no';
   }
   if(isset($_POST['parking_area'])){
      $parking_area = $_POST['parking_area'];
      $parking_area = filter_var($parking_area, FILTER_SANITIZE_STRING);
   }else{
      $parking_area = 'no';
   }
   if(isset($_POST['gym'])){
      $gym = $_POST['gym'];
      $gym = filter_var($gym, FILTER_SANITIZE_STRING);
   }else{
      $gym = 'no';
   }
   if(isset($_POST['shopping_mall'])){
      $shopping_mall = $_POST['shopping_mall'];
      $shopping_mall = filter_var($shopping_mall, FILTER_SANITIZE_STRING);
   }else{
      $shopping_mall = 'no';
   }
   if(isset($_POST['hospital'])){
      $hospital = $_POST['hospital'];
      $hospital = filter_var($hospital, FILTER_SANITIZE_STRING);
   }else{
      $hospital = 'no';
   }
   if(isset($_POST['school'])){
      $school = $_POST['school'];
      $school = filter_var($school, FILTER_SANITIZE_STRING);
   }else{
      $school = 'no';
   }
   if(isset($_POST['market_area'])){
      $market_area = $_POST['market_area'];
      $market_area = filter_var($market_area, FILTER_SANITIZE_STRING);
   }else{
      $market_area = 'no';
   }

   $image_02 = $_FILES['image_02']['name'];
   $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING);
   $image_02_ext = pathinfo($image_02, PATHINFO_EXTENSION);
   $rename_image_02 = create_unique_id().'.'.$image_02_ext;
   $image_02_tmp_name = $_FILES['image_02']['tmp_name'];
   $image_02_size = $_FILES['image_02']['size'];
   $image_02_folder = 'uploaded_files/'.$rename_image_02;

   if(!empty($image_02)){
      if($image_02_size > 2000000){
         $warning_msg[] = 'image 02 size is too large!';
      }else{
         move_uploaded_file($image_02_tmp_name, $image_02_folder);
      }
   }else{
      $rename_image_02 = '';
   }

   $image_03 = $_FILES['image_03']['name'];
   $image_03 = filter_var($image_03, FILTER_SANITIZE_STRING);
   $image_03_ext = pathinfo($image_03, PATHINFO_EXTENSION);
   $rename_image_03 = create_unique_id().'.'.$image_03_ext;
   $image_03_tmp_name = $_FILES['image_03']['tmp_name'];
   $image_03_size = $_FILES['image_03']['size'];
   $image_03_folder = 'uploaded_files/'.$rename_image_03;

   if(!empty($image_03)){
      if($image_03_size > 2000000){
         $warning_msg[] = 'image 03 size is too large!';
      }else{
         move_uploaded_file($image_03_tmp_name, $image_03_folder);
      }
   }else{
      $rename_image_03 = '';
   }

   $image_04 = $_FILES['image_04']['name'];
   $image_04 = filter_var($image_04, FILTER_SANITIZE_STRING);
   $image_04_ext = pathinfo($image_04, PATHINFO_EXTENSION);
   $rename_image_04 = create_unique_id().'.'.$image_04_ext;
   $image_04_tmp_name = $_FILES['image_04']['tmp_name'];
   $image_04_size = $_FILES['image_04']['size'];
   $image_04_folder = 'uploaded_files/'.$rename_image_04;

   if(!empty($image_04)){
      if($image_04_size > 2000000){
         $warning_msg[] = 'image 04 size is too large!';
      }else{
         move_uploaded_file($image_04_tmp_name, $image_04_folder);
      }
   }else{
      $rename_image_04 = '';
   }

   $image_05 = $_FILES['image_05']['name'];
   $image_05 = filter_var($image_05, FILTER_SANITIZE_STRING);
   $image_05_ext = pathinfo($image_05, PATHINFO_EXTENSION);
   $rename_image_05 = create_unique_id().'.'.$image_05_ext;
   $image_05_tmp_name = $_FILES['image_05']['tmp_name'];
   $image_05_size = $_FILES['image_05']['size'];
   $image_05_folder = 'uploaded_files/'.$rename_image_05;

   if(!empty($image_05)){
      if($image_05_size > 2000000){
         $warning_msg[] = 'image 05 size is too large!';
      }else{
         move_uploaded_file($image_05_tmp_name, $image_05_folder);
      }
   }else{
      $rename_image_05 = '';
   }

   $image_01 = $_FILES['image_01']['name'];
   $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
   $image_01_ext = pathinfo($image_01, PATHINFO_EXTENSION);
   $rename_image_01 = create_unique_id().'.'.$image_01_ext;
   $image_01_tmp_name = $_FILES['image_01']['tmp_name'];
   $image_01_size = $_FILES['image_01']['size'];
   $image_01_folder = 'uploaded_files/'.$rename_image_01;

   if($image_01_size > 2000000){
      $warning_msg[] = 'image 01 size too large!';
   }else{
      $insert_property = $conn->prepare("INSERT INTO `property`(id, user_id, property_name, address, price, type, offer, status, furnished, bhk, deposite, bedroom, bathroom, balcony, carpet, age, total_floors, room_floor, loan, lift, security_guard, play_ground, garden, water_supply, power_backup, parking_area, gym, shopping_mall, hospital, school, market_area, image_01, image_02, image_03, image_04, image_05, description) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)"); 
      $insert_property->execute([$id, $user_id, $property_name, $address, $price, $type, $offer, $status, $furnished, $bhk, $deposite, $bedroom, $bathroom, $balcony, $carpet, $age, $total_floors, $room_floor, $loan, $lift, $security_guard, $play_ground, $garden, $water_supply, $power_backup, $parking_area, $gym, $shopping_mall, $hospital, $school, $market_area, $rename_image_01, $rename_image_02, $rename_image_03, $rename_image_04, $rename_image_05, $description]);
      move_uploaded_file($image_01_tmp_name, $image_01_folder);
      $success_msg[] = 'property posted successfully!';
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Post Property</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">

   <style>
      .hidden { display: none !important; }
   </style>
</head>
<body>

<?php include 'components/user_header.php'; ?>

<section class="property-form">

<form action="" method="POST" enctype="multipart/form-data">
   <h3>Property Details</h3>

   <div class="flex">
      <div class="box">
         <p>Property name <span>*</span></p>
         <input type="text" name="property_name" required maxlength="50" placeholder="Enter property name" class="input">
      </div>
      <div class="box">
         <p>Property price <span>*</span></p>
         <input type="number" name="price" required min="0" maxlength="10" placeholder="Enter price" class="input">
      </div>
      <div class="box">
         <p>Deposit amount</p>
         <input type="number" name="deposite" min="0" maxlength="10" placeholder="Enter deposit (optional)" class="input">
      </div>
      <div class="box">
         <p>Property address <span>*</span></p>
         <input type="text" name="address" required min="0" maxlength="100" placeholder="Full address" class="input">
      </div>

      <div class="box">
         <p>Offer type <span>*</span></p>
         <select name="offer" required class="input">
            <option value="sale">Sale</option>
            <option value="resale">Resale</option>
            <!-- <option value="rent">Rent</option> -->
         </select>
      </div>

      <div class="box">
         <p>Property type <span>*</span></p>
         <select name="type" id="property_type" required class="input">
            <option value="">-- Select Type --</option>
            <option value="home">Home</option>
            <option value="land">Land</option>
         </select>
      </div>

      <div class="box">
         <p>Property status <span>*</span></p>
         <select name="status" required class="input">
            <option value="ready to move">Ready to move</option>
            <option value="under construction">Under construction</option>
         </select>
      </div>
   </div>

   <!-- ==================== HOME FIELDS (visible only when Home selected) ==================== -->
   <div id="home_fields">
      <div class="flex">
         <div class="box">
            <p>Furnished status</p>
            <select name="furnished" class="input">
               <option value="unfurnished">Unfurnished</option>
               <option value="semi-furnished">Semi-furnished</option>
               <option value="furnished">Furnished</option>
            </select>
         </div>
         <div class="box">
            <p>BHK <span>*</span></p>
            <select name="bhk" class="input">
               <option value="1">1 BHK</option>
               <option value="2">2 BHK</option>
               <option value="3">3 BHK</option>
               <option value="4">4 BHK</option>
               <option value="5">5+ BHK</option>
            </select>
         </div>
         <div class="box">
            <p>Bedrooms</p>
            <input type="number" name="bedroom" min="0" maxlength="10" placeholder="No. of bedrooms" class="input">
         </div>
         <div class="box">
            <p>Bathrooms</p>
            <input type="number" name="bathroom" min="0" maxlength="10" placeholder="No. of bathrooms" class="input">
         </div>
         <div class="box">
            <p>Balconies</p>
            <input type="number" name="balcony" min="0" maxlength="10" placeholder="No. of balconies" class="input">
         </div>
         <div class="box">
            <p>Carpet area (sqft)</p>
            <input type="number" name="carpet" min="0" maxlength="10" placeholder="Carpet area in sqft" class="input">
         </div>
         <div class="box">
            <p>Age of property (years)</p>
            <input type="number" name="age" min="0" maxlength="10" placeholder="How old?" class="input">
         </div>
         <div class="box">
            <p>Total floors in building</p>
            <input type="number" name="total_floors" min="0" maxlength="10" placeholder="Total floors" class="input">
         </div>
         <div class="box">
            <p>Property on floor</p>
            <input type="number" name="room_floor" min="0" maxlength="10" placeholder="e.g. 3rd floor" class="input">
         </div>
      </div>
   </div>

   <!-- ==================== LAND FIELDS (visible only when Land selected) ==================== -->
   <div id="land_fields">
      <div class="flex">
         <div class="box">
            <p>Total area (sqft) <span>*</span></p>
            <input type="number" name="total_arera" min="0" maxlength="10" placeholder="e.g. 1369 sqft" class="input">
         </div>
         <div class="box">
            <p>Road access (ft)</p>
            <input type="text" name="road_access" min="0" maxlength="10" placeholder="e.g. 20 ft pitched road" class="input">
         </div>
         <div class="box">
            <p>Facing direction</p>
            <select name="facing" class="input">
               <option value="East">East</option>
               <option value="West">West</option>
               <option value="North">North</option>
               <option value="South">South</option>
               <option value="North-East">North-East</option>
               <option value="North-West">North-West</option>
               <option value="South-East">South-East</option>
               <option value="South-West">South-West</option>
            </select>
         </div>
         <div class="box">
            <p>Plot shape</p>
            <select name="plot_shape" class="input">
               <option value="Rectangular">Rectangular</option>
               <option value="Square">Square</option>
               <option value="Irregular">Irregular</option>
            </select>
         </div>
         <div class="box">
            <p>Area in Ana (if applicable)</p>
            <input type="number" step="0.1" name="ana" min="0" maxlength="10" placeholder="e.g. 4 Ana" class="input">
         </div>
         <div class="box">
            <p>Ownership type</p>
            <select name="ownership" class="input">
               <option value="Individual">Individual</option>
               <option value="Company">Company</option>
            </select>
         </div>
         <!-- <div class="box">
            <p>Registration status</p>
            <select name="registration" class="input">
               <option value="Ready for immediate transfer">Ready for immediate transfer</option>
               <option value="In process">In process</option>
            </select>
         </div> -->
      </div>
   </div>

   <!-- Common fields -->
   <div class="box">
      <p>Loan available?</p>
      <select name="loan" class="input">
         <option value="available">Available</option>
         <option value="not available">Not available</option>
      </select>
   </div>

   <div class="box">
      <p>Property description <span>*</span></p>
      <textarea name="description" maxlength="2000" cols="30" rows="10" placeholder="Write about the property..." class="input" required></textarea>
   </div>

   <!-- Amenities (common) -->
   <div class="checkbox">
      <p>Amenities (optional)</p>
      <div class="flex">
         <div>
            <label><input type="checkbox" name="play_ground" value="yes"> Play ground</label><br>
            <label><input type="checkbox" name="garden" value="yes"> Garden</label><br>
            <label><input type="checkbox" name="water_supply" value="yes"> Water supply</label><br>
            <label><input type="checkbox" name="power_backup" value="yes"> Power backup</label>
         </div>
         <div>
            <label><input type="checkbox" name="parking_area" value="yes"> Parking area</label><br>
            <label><input type="checkbox" name="hospital" value="yes"> Hospital nearby</label><br>
            <label><input type="checkbox" name="school" value="yes"> School nearby</label><br>
            <label><input type="checkbox" name="market_area" value="yes"> Market nearby</label>
         </div>
      </div>
   </div>

   <!-- Images -->
   <div class="box">
      <p>Main image <span>*</span></p>
      <input type="file" name="image_01" accept="image/*" required class="input">
   </div>
   <div class="flex">
      <div class="box"><p>Image 02</p><input type="file" name="image_02" accept="image/*"></div>
      <div class="box"><p>Image 03</p><input type="file" name="image_03" accept="image/*"></div>
      <div class="box"><p>Image 04</p><input type="file" name="image_04" accept="image/*"></div>
      <div class="box"><p>Image 05</p><input type="file" name="image_05" accept="image/*"></div>
   </div>

   <input type="submit" value="Post Property" name="post" class="btn">
</form>

</section>

<script>
// Show/Hide fields based on property type
document.getElementById('property_type').addEventListener('change', function() {
   const type = this.value;
   document.getElementById('home_fields').classList.add('hidden');
   document.getElementById('land_fields').classList.add('hidden');

   if(type === 'home') {
      document.getElementById('home_fields').classList.remove('hidden');
   } else if(type === 'land') {
      document.getElementById('land_fields').classList.remove('hidden');
   }
});

// Run on page load (in case of edit or validation error)
window.onload = function() {
   const type = document.getElementById('property_type').value;
   if(type === 'home') document.getElementById('home_fields').classList.remove('hidden');
   if(type === 'land') document.getElementById('land_fields').classList.remove('hidden');
};
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<?php include 'components/footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<?php include 'components/message.php'; ?>

</body>
</html>