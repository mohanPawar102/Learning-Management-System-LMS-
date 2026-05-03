<?php
session_start();

require 'db.php';
$stmt = $pdo->prepare("SELECT * FROM students WHERE id=?");
$stmt->execute([$_SESSION['user_id']]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

$userName = $student['name'];
$role = $_SESSION['role'];
$profileImg = !empty($student['image']) ? "uploads/" . $student['image'] : "uploads/default.png";

// Handle Form Submission
$successMsg = $errorMsg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_name = $_POST['student_name'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $course = $_POST['course'];
    $message = $_POST['message'];

    $stmt = $pdo->prepare("INSERT INTO contact_messages (student_name,email,number,course,message,created_at) VALUES (?,?,?,?,?,NOW())");
    if ($stmt->execute([$student_name,$email,$number,$course,$message])) {

        // ---------------- SMS API Integration ---------------- //
        $apiKey = "yinGkrlM9pBC7Pw0zjxagSb5eTqRvIA4DsWu2EJZcV1LKUNdtfaSLIspYRTZcJDEOFHKj8tUxVPXr2bw";  // 🔴 इथे तुझा Fast2SMS चा API Key टाक
        $senderId = "FSTSMS"; 
        $smsMessage = "Dear $student_name, 
                     Thank you for contacting SmartCampus360! 🙏 
                     We have received your query regarding '$course'. 
                    Our team will get back to you soon on $email or this number $number. 
                    - SmartCampus360 Team";

        $fields = array(
            "sender_id" => $senderId,
            "message" => $smsMessage,
            "language" => "english",
            "route" => "v3",
            "numbers" => $number,
        );

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($fields),
            CURLOPT_HTTPHEADER => array(
                "authorization: $apiKey",
                "accept: */*",
                "cache-control: no-cache",
                "content-type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $successMsg = "Message Sent Successfully ✅ (SMS also sent)";
    } else {
        $errorMsg = "Error Sending Message ❌";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact - SmartCampus360</title>
<link rel="stylesheet" href="style.css">
<style>
/* Dashboard style adjustments for contact page */
.contact-section { max-width:700px; margin:50px auto; background:#fff; padding:30px; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.1);}
.contact-section h2 { text-align:center; margin-bottom:20px; color:#27ae60; }
.contact-form input, .contact-form textarea { width:100%; padding:12px; margin-bottom:15px; border:1px solid #ccc; border-radius:8px; font-size:16px; }
.contact-form textarea { resize: vertical; }
.contact-form button { background:#27ae60; color:#fff; border:none; padding:12px 25px; border-radius:8px; cursor:pointer; font-size:16px; transition:0.3s; }
.contact-form button:hover { background:#219150; }
.alert { padding:12px 20px; border-radius:8px; margin-bottom:20px; text-align:center; font-weight:500; }
.alert-success { background:#d4edda; color:#155724; }
.alert-error { background:#f8d7da; color:#721c24; }
</style>
</head>
<body>

<header class="navbar">
  <div class="logo">Smart<span>Campus</span><strong>360</strong></div>
  <nav class="nav-links">
    <a href="student_index.php">Home</a>
    <a href="#course">Courses</a>
    <a href="contact.php">Contact</a>
    <i class="bi bi-search"></i>
    <li class="nav-item mx-2" type="none">
      <a class="nav-link text-white" href="#" onclick="toggleProfile()">
        <img src="<?php echo $profileImg; ?>" alt="profile" style="width:40px;height:40px;border-radius:50%;">
      </a>
    </li>
    <div id="profileSection" style="display:none; position:absolute; right:20px; top:60px; width:300px; background:#fff; padding:15px; border-radius:10px; box-shadow:0 4px 8px rgba(0,0,0,0.2); z-index:9999;">
      <div style="display:flex; align-items:center; margin-bottom:15px;">
        <img src="<?php echo $profileImg; ?>" style="width:50px;height:50px;border-radius:50%; margin-right:10px;">
        <div><strong><?php echo $userName ?></strong><br><small><?php echo $role ?></small></div>
      </div>
      <hr>
      <form method="post" action="update_student.php" enctype="multipart/form-data">
        <label>Name:</label>
        <input type="text" name="name" value="<?php echo $student['name']; ?>" style="width:100%;padding:5px;margin-bottom:10px;border-radius:5px;border:1px solid #ccc;">
        <label>Role:</label>
        <input type="text" value="<?php echo $role; ?>" readonly style="width:100%;padding:5px;margin-bottom:10px;border-radius:5px;border:1px solid #ccc;">
        <button type="submit" style="background:green;color:white;padding:8px;border:none;border-radius:8px;width:100%;margin-bottom:10px;">Update Profile</button>
      </form>
      <button style="background:red;padding:8px;border-radius:8px;border:0;width:100%">
        <a href="logout.php" class="text-decoration-none d-block text-white">Logout</a>
      </button>
    </div>
  </nav>
</header>
<!-- 
<section class="hero">
  <div class="hero-content">
    <h2>Contact & Queries</h2>
    <p>Send us your query and we will get back to you as soon as possible.</p>
  </div>
</section> -->

<section class="contact-section" style="width:500px">
  <h2>Contact With Us</h2>

  <?php if($successMsg): ?>
    <div class="alert alert-success"><?php echo $successMsg; ?></div>
  <?php endif; ?>
  <?php if($errorMsg): ?>
    <div class="alert alert-error"><?php echo $errorMsg; ?></div>
  <?php endif; ?>

  <form action="contact.php" method="POST" class="contact-form" >
      <input type="text" name="student_name" placeholder="Your Name" required>
      <input type="email" name="email" placeholder="Your Email" required>
      <input type="number" name="number" placeholder="Your Mobile-No" required>
      <input type="text" name="course" placeholder="Course Name" required>
      <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
      <button type="submit">Send Message</button>
  </form>
</section>

<footer class="custom-footer">
  <div class="footer-container">
    <div class="footer-brand">
      <div class="logo">Smart<span>Campus</span><strong>360</strong></div>
      <p>Empowering future developers with modern web technologies.</p>
    </div>
    <div class="footer-links">
      <h4>Quick Links</h4>
      <ul>
        <li><a href="student_index.php">Home</a></li>
        <li><a href="student_index.php">Courses</a></li>
        <li><a href="contact.php">Contact</a></li>
      </ul>
    </div>
    <div class="footer-contact">
      <h4>Contact</h4>
      <p><i class="bi bi-telephone-fill"></i> +91 755-832-7748</p>
      <p><i class="bi bi-envelope-fill"></i> smartcampus360@gmail.com</p>
    </div>
  </div>
  <div class="footer-bottom">
    <p>© 2025 SmartCampus360 | Designed by <u>Mohan Pawar</u></p>
  </div>
</footer>

<script>
function toggleProfile() {
  const profile = document.getElementById('profileSection');
  profile.style.display = (profile.style.display === "none" || profile.style.display === "") ? "block" : "none";
}

document.addEventListener("click", function(event){
  const profile = document.getElementById("profileSection");
  const icon = event.target.closest(".nav-item");
  const insidePanel = profile.contains(event.target);
  if(!icon && !insidePanel){ profile.style.display = "none"; }
});
</script>

</body>
</html>
