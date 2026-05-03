<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'college'){
    header("Location: login.php?error=Please Login First");
    exit;
}
require 'db.php'; // PDO connection

// Function: Find next available Roll No (reuse cancelled gaps, else max+1)
function getNextRollNo($pdo) {
    $stmt = $pdo->query("SELECT roll_no FROM ofline_students WHERE status!='cancelled' ORDER BY roll_no ASC");
    $used = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $roll = 1;
    foreach ($used as $r) {
        if ($r != $roll) break; 
        $roll++;
    }

    // जर gaps नसेल तर max+1 दे
    if (in_array($roll, $used)) {
        $roll = max($used) + 1;
    }
    return $roll;
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name   = $_POST['name'];
    $mobile = $_POST['mobile'];
    $course = $_POST['course'];
    $total_fee = $_POST['total_fee'];
    $admission_fee = $_POST['admission_fee'];

    if($admission_fee < 5000){
        die("<script>alert('Admission fee minimum ₹5000 compulsory!');window.history.back();</script>");
    }

    // Generate Roll No
    $roll_no = getNextRollNo($pdo);

    // Insert student
    $stmt = $pdo->prepare("INSERT INTO ofline_students 
        (name, mobile, course, total_fee, admission_fee, roll_no, status) 
        VALUES (?,?,?,?,?,?, 'active')");
    $stmt->execute([$name,$mobile,$course,$total_fee,$admission_fee,$roll_no]);
    $student_id = $pdo->lastInsertId();

    // Insert first payment
    $stmt = $pdo->prepare("INSERT INTO fee_payments (student_id, amount, note, created_at) VALUES (?,?,?,NOW())");
    $stmt->execute([$student_id,$admission_fee,"Admission Fee"]);
    $payment_id = $pdo->lastInsertId();

    // Generate unique receipt number
    $receipt_no = "ADM-" . date("Y") . "-" . $student_id . "-" . $payment_id;
    $stmt = $pdo->prepare("UPDATE fee_payments SET receipt_no=? WHERE id=?");
    $stmt->execute([$receipt_no, $payment_id]);

    echo "<script>
        alert('Admission Successful! Roll No: $roll_no');
        window.location='receipt.php?pid=$payment_id';
    </script>";
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>College Admission Form</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styleColleg.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet"> -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
  <!-- <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> -->
  
</head>
<body>
  <!-- Sidebar -->
   <!-- Toggle button (hamburger) -->
   <div class="toggle-btn" id="toggleBtn">
      <i class="fas fa-bars"></i>
     </div>
      <!-- Sidebar -->
     <div class="sidebar" id="sidebar">
       <div class="profile">
        <img src="image/profile.png" alt="Profile Image" id="profileImage" class="img-fluid rounded-circle">
        <h3><?php echo htmlspecialchars($_SESSION['username']); ?></h3>
     <div class="social-links mt-3 text-center">
      <a href="#" class="twitter"><i class="fa-brands fa-twitter"></i></a>
      <a href="https://www.facebook.com/profile.php?id=100040665245825" class="facebook"><i class="fa-brands fa-facebook"></i></a>
      <a href="https://www.instagram.com/_mohan_pawar_102?igshid=YzVkODRmOTdmMw==" class="instagram"><i class="fa-brands fa-instagram"></i></a>
      <a href="#" class="google-plus"><i class="fa-brands fa-skype"></i></a>
    </div>
  </div>

  <nav>
    <a href="college_dashboard.php"><i class="fas fa-home"></i> Home</a>
    <a href="college_dashboard.php"><i class="fas fa-chart-line"></i> Statistics</a>
    <a href="college_dashboard.php"><i class="fas fa-laptop"></i> Online Students</a>
    <a href="college_dashboard.php"><i class="fas fa-school"></i> Offline Students</a>
    <a href="college_dashboard.php"><i class="fas fa-certificate"></i> Certificates</a>
    <a href="admission.php"><i class="fas fa-file-alt"></i> Admission</a>
    <a href="student_message.php"><i class="fas fa-envelope"></i> View Messages</a>
    <!-- <a href="settings.php"><i class="fas fa-cog"></i> Settings</a> -->
  </nav>
</div>

 <!-- Content -->
<div class="content">

  <div class="content-area">
    <div class="admission-container">
      <h2>🎓 College Admission Form</h2>
      <form method="post">
        <div class="mb-3">
          <label class="form-label">Full Name</label>
          <input type="text" name="name" class="form-control" placeholder="Enter student name" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Mobile Number</label>
          <input type="text" name="mobile" class="form-control" placeholder="Enter mobile number" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Select Course</label>
          <select name="course" class="form-select" required>
            <option value="">-- Select Course --</option>
            <option value="C Programming">C Programming</option>
            <option value="HTML & CSS">HTML & CSS</option>
            <option value="JavaScript">JavaScript</option>
            <option value="ReactJS">ReactJS</option>
            <option value="Java">Java</option>
            <option value="Python">Python</option>
            <option value="SQL">SQL</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Total Course Fee</label>
          <input type="number" name="total_fee" class="form-control" placeholder="Enter total fee" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Admission Fee (min ₹5000)</label>
          <input type="number" name="admission_fee" class="form-control" placeholder="Enter admission fee" required>
        </div>
        <button type="submit" class="btn-submit">✅ Submit Admission</button>
      </form>
      <a href="student_list.php" class="btn-list">📋 View Student List</a>
    </div>
  </div>
  
</div>
  <!-- Footer -->
  <footer class="custom-footer">
    <div class="footer-container">
      <div class="footer-brand">
        <div class="logo">Smart<span>Campus</span><strong>360</strong></div>
        <p>Empowering future developers with modern web technologies.</p>
      </div>
      <div class="footer-links">
        <h4>Quick Links</h4>
        <ul>
          <li><a href="college_dashboard.php">Home</a></li>
        </ul>
      </div>
      <div class="footer-contact">
        <h4>Contact</h4>
        <p><i class="bi bi-telephone-fill"></i> +91 755-832-7748</p>
        <p><i class="bi bi-envelope-fill"></i> support@fullstack.com</p>
      </div>
    </div>
    <div class="footer-bottom">
      <p>© 2025 SmartCampus360 | Designed by <u>Mohan Pawar</u></p>
    </div>
  </footer>

</body>
<script>
  const toggleBtn = document.getElementById("toggleBtn");
        const sidebar = document.getElementById("sidebar");

       toggleBtn.addEventListener("click", () => {
       sidebar.classList.toggle("open");
        });
</script>
</html>
