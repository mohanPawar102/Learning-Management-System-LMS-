<?php
session_start();
// DB Connection
$conn = new mysqli("localhost", "root", "", "first");
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// Fetch Messages (correct table name)
$result = $conn->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>College Dashboard - Messages</title>
     <link rel="stylesheet" href="styleColleg.css"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
    
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
<div class="content ">
    <h2>📩 Student Contact Messages</h2>
    <div class="card">
     <table class="table table-striped">
        <tr>
            <th>ID</th>
            <th>Student Name</th>
            <th>Email</th>
            <th>Number</th>
            <th>Course</th>
            <th>Message</th>
            <th>Date</th>
        </tr>
        <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['student_name']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['number']); ?></td>
            <td><?php echo htmlspecialchars($row['course']); ?></td>
            <td><?php echo htmlspecialchars($row['message']); ?></td>
            <td><?php echo $row['created_at']; ?></td>
        </tr>
        <?php } ?>
     </table>
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
        <p><i class="bi bi-envelope-fill"></i> smartcampus360@gmail.com</p>
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
