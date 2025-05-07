<?php
// Database connection
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "bloodbridge";

$conn = new mysqli($servername,$username,$password,$dbname);
if ($conn->connect_error) {
  die("Connection failed: ".$conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // collect & hash
  $full_name = $_POST['full_name'];
  $email     = $_POST['email'];
  $phone     = $_POST['phone'];
  $blood     = $_POST['blood_group'];
  $city      = $_POST['city'];
  $state     = $_POST['state'];
  $pass      = password_hash($_POST['password'], PASSWORD_BCRYPT);

  $stmt = $conn->prepare(
    "INSERT INTO donors (full_name,email,phone,blood_group,city,state,password)
     VALUES (?,?,?,?,?,?,?)"
  );
  $stmt->bind_param("sssssss",$full_name,$email,$phone,$blood,$city,$state,$pass);
  if ($stmt->execute()) {
    header("Location: login.html");
    exit;
  } else {
    echo "Error: ".$stmt->error;
  }
  $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><title>Register – Blood Bridge</title>
</head>
<body>
  <h2>Sign Up</h2>
  <form method="POST" action="">
    <input name="full_name"    placeholder="Full Name"  required><br>
    <input name="email"        placeholder="Email"      required><br>
    <input name="phone"        placeholder="Phone"      required><br>
    <input name="blood_group"  placeholder="Blood Grp"  required><br>
    <input name="city"         placeholder="City"       required><br>
    <input name="state"        placeholder="State"      required><br>
    <input name="password"     type="password" placeholder="Password" required><br>
    <button type="submit">Register</button>
  </form>
</body>
</html>
