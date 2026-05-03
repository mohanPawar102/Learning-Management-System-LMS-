<?php
session_start();
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'college'){
    header("Location: login.php?error=Please Login First");
    exit;
}
require 'db.php';

// Fetch statistics
$total_students = $pdo->query("SELECT COUNT(*) FROM students")->fetchColumn() +
                  $pdo->query("SELECT COUNT(*) FROM ofline_students")->fetchColumn();

$online_students = $pdo->query("SELECT COUNT(*) FROM students")->fetchColumn();
$offline_students = $pdo->query("SELECT COUNT(*) FROM ofline_students")->fetchColumn();

$certificates_issued = $pdo->query("SELECT COUNT(DISTINCT username) FROM certificates")->fetchColumn();
$pending_certificates = $online_students - $certificates_issued;
if($pending_certificates < 0) $pending_certificates = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>College Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styleColleg.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet"> -->
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
    <a href="#home"><i class="fas fa-home"></i> Home</a>
    <a href="#stats"><i class="fas fa-chart-line"></i> Statistics</a>
    <a href="#online"><i class="fas fa-laptop"></i> Online Students</a>
    <a href="#offline"><i class="fas fa-school"></i> Offline Students</a>
    <a href="#certificates"><i class="fas fa-certificate"></i> Certificates</a>
    <a href="admission.php"><i class="fas fa-file-alt"></i> Admission</a>
    <a href="student_message.php"><i class="fas fa-envelope"></i> View Messages</a>
    <!-- <a href="settings.php"><i class="fas fa-cog"></i> Settings</a> -->
  </nav>
 </div>


    <!-- Content -->
    <div class="content">
        <!-- Hero -->
        <div id="home" class="hero" >
            <div>
                <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
                <p>Your college dashboard overview</p>
            </div>
        </div>
        
   
        <!-- Statistics -->
        <div id="stats" class="section container">
            <h2>Statistics Overview</h2>
            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <h5>Total Students</h5>
                        <p><?php echo $total_students; ?></p>
                        <div class="progress custom-progress">
                          <div class="progress-bar " 
                            role="progressbar" 
                            style="width: <?php echo $total_students; ?>%;" 
                            aria-valuenow="<?php echo $total_students; ?>" 
                            aria-valuemin="0" 
                            aria-valuemax="100">
                           <?php echo $total_students; ?>%
                          </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <h5>Online Students</h5>
                        <p><?php echo $online_students; ?></p>
                        <div class="progress custom-progress">
                          <div class="progress-bar " 
                            role="progressbar" 
                            style="width: <?php echo $online_students; ?>%;" 
                            aria-valuenow="<?php echo $online_students; ?>" 
                            aria-valuemin="0" 
                            aria-valuemax="100">
                           <?php echo $online_students; ?>%
                          </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <h5>Offline Students</h5>
                        <p><?php echo $offline_students; ?></p>
                        <div class="progress custom-progress">
                          <div class="progress-bar " 
                            role="progressbar" 
                            style="width: <?php echo $offline_students; ?>%;" 
                            aria-valuenow="<?php echo $offline_students; ?>" 
                            aria-valuemin="0" 
                            aria-valuemax="100">
                           <?php echo $offline_students; ?>%
                          </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <h5>Certificates Issued</h5>
                        <p><?php echo $certificates_issued; ?></p>
                        <div class="progress custom-progress">
                          <div class="progress-bar " 
                            role="progressbar" 
                            style="width: <?php echo $certificates_issued; ?>%;" 
                            aria-valuenow="<?php echo $certificates_issued; ?>" 
                            aria-valuemin="0" 
                            aria-valuemax="100">
                           <?php echo $certificates_issued; ?>%
                          </div>
                        </div>
                    </div>
                </div>
            </div>
            <canvas id="studentChart" style="max-width:600px;margin:auto;margin-top:30px;"></canvas>
        </div>

        <!-- Online Students -->
        <div id="online" class="section container">
            <h2>Online Students</h2>
            <div class="card">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <!-- <th>Course</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $pdo->query("SELECT * FROM students LIMIT 10");
                        $i = 1;
                        while($row = $stmt->fetch()){
                            echo "<tr>
                                <td>{$i}</td>
                                <td>".htmlspecialchars($row['name'])."</td>
                            </tr>";
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Offline Students -->
        <div id="offline" class="section container">
            <h2>Offline Students</h2>
            <div class="card">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Roll No</th>
                            <th>Course</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $pdo->query("SELECT * FROM ofline_students LIMIT 10");
                        $i = 1;
                        while($row = $stmt->fetch()){
                            echo "<tr>
                                <td>{$i}</td>
                                <td>".htmlspecialchars($row['name'])."</td>
                                <td>".htmlspecialchars($row['roll_no'])."</td>
                                <td>".htmlspecialchars($row['course'])."</td>
                                <td>".htmlspecialchars($row['status'])."</td>
                            </tr>";
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Certificates Summary -->
        <div id="certificates" class="section container">
            <h2>Certificates Summary</h2>
            <div class="card">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Total Online Students</th>
                            <th>Certificates Issued</th>
                            <th>Pending Certificates</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $online_students; ?></td>
                            <td><?php echo $certificates_issued; ?></td>
                            <td><?php echo $pending_certificates; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
  <!-- Footer -->
  <footer class="custom-footer" >
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


    <!-- Scripts -->
    <script>
        // Chart.js Pie chart
        const ctx = document.getElementById('studentChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Online Students', 'Offline Students'],
                datasets: [{
                    data: [<?php echo $online_students; ?>, <?php echo $offline_students; ?>],
                    backgroundColor: ['#0d6efd', '#6c757d']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Animate sections when they come into view
        document.addEventListener('DOMContentLoaded', function() {
            const sections = document.querySelectorAll('.section');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if(entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, { threshold: 0.1 });

            sections.forEach(section => {
                observer.observe(section);
            });
        });
        

        const toggleBtn = document.getElementById("toggleBtn");
        const sidebar = document.getElementById("sidebar");

       toggleBtn.addEventListener("click", () => {
       sidebar.classList.toggle("open");
        });


    </script>
</body>
</html>
