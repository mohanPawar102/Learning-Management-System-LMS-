<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}


require 'db.php';
$stmt = $pdo->prepare("SELECT * FROM students WHERE id=?");
$stmt->execute([$_SESSION['user_id']]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

$userName = $student['name'];
$role = $_SESSION['role'];
$profileImg = !empty($student['image']) ? "uploads/" . $student['image'] : "uploads/default.png";


?>
<!DOCTYPE html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SmartCampus360 - Student Dashboard</title>
  <link rel="stylesheet" href="style1.css" />
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   <style>
  
  </style></head>

<body>
  
<i class="fa-solid fa-grip-lines toggle-bar" onclick="toggleMenu()" style="color:white;margin-left:80%;margin-top:20px;font-size:2rem;height:2.2rem; background-color: #f3943b;cursor:pointer;display: none; z-index: 1001;"></i>

  <!-- Header -->
  <header  class="navbar">
    <div class="logo">Smart<span>Campus</span><strong>360</strong></div>
    <nav class="nav-links">
      <a href="student_index.php">Home</a>
      <a href="#course">Courses</a>
      <a href="contact.php">Contact</a>
      <a href="chatbot.php"> <i class="fa-solid fa-magnifying-glass"></i></i></a>
      <li class="nav-item mx-2" type="none">
        <a class="nav-link text-white" href="#" onclick="toggleProfile()">
          <img src="<?php echo $profileImg; ?>" alt="profile" style="width:40px;height:40px;border-radius:50%;">
        </a>
      </li>

      <!-- Profile Section -->
      <div id="profileSection"
        style="display: none; position: absolute; right: 20px; top: 60px; width: 300px; background-color: #fff; padding: 15px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.2); z-index: 9999; margin-top:10px;">
        <div style="display: flex; align-items: center; margin-bottom: 15px;">
          <img src="<?php echo $profileImg; ?>" alt="Profile Picture"
            style="width: 50px; height: 50px; border-radius: 50%; margin-right: 10px;">
          <div>
            <strong><?php echo $userName ?> </strong><br>
            <small><?php echo $role ?></small>
          </div>
        </div>
        <hr>
        <form method="post" action="update_student.php" enctype="multipart/form-data">
          <label>Name:</label>
          <input type="text" name="name" value="<?php echo $student['name']; ?>" style="width:100%;padding:5px;margin-bottom:10px;border-radius:5px;border:1px solid #ccc;">
          <label>Role:</label>
          <input type="text" value="<?php echo $role; ?>" readonly style="width:100%;padding:5px;margin-bottom:10px;border-radius:5px;border:1px solid #ccc;">
          <button type="submit" style="background:green;color:white;padding:8px;border:none;border-radius:8px;width:100%;margin-bottom:10px;">Profile</button>
        </form>
        <button style="background-color:red;padding:8px;border-radius:8px;border:0;width:100%">
          <a href="logout.php" class="text-decoration-none d-block text-white">Logout</a>
        </button>
      </div>
    </nav>

  </header>

  <!-- Main Hero Section -->
  <section class="hero">
    <div class="hero-content">
      <h3>Welcome,<i><?php echo $userName; ?></i>
      <h3> to Web Design & <br>Development Course</h3></h3>
      <p>This is your personalized student dashboard. Access your courses and track progress.</p>
      <a href="#course"><button class="cta-btn">Explore Courses</button></a>
    </div>
<!-- ================== Home Page Img Add ========== -->
    <div class="circle-gallery">
      <div class="circle">
        <img src="image/c.webp" alt="Student 1" />
      </div>
      <div class="circle">
        <img src="image/java.jpg" alt="Student 2" />
      </div>
      <div class="circle">
        <img src="image/html.jpg" alt="Student 3" />
      </div>
      <div class="circle">
        <img src="image/python.png" alt="Student 4" />
      </div>
      <div class="circle">
        <img src="image/javasrcript.jpg" alt="Student 5" />
      </div>
      <div class="circle">
        <img src="image/react.png" alt="Student 6" />
      </div>
      
    </div>
  </section>  
  
  <section class="about-course">
   <h1>World Top Courses</h1>
   <div class="about">
  <div class="about-text">
    <h2> Full Stack Development</h2>
    <p>
     This course is designed to provide in-depth knowledge of both 
      Frontend & Backend technologies. Learn HTML, CSS, JavaScript, 
      React, Node.js, Express, and Database management with hands-on 
      projects.
    </p>
    <ul>
      <li><strong>📅 Duration:</strong> 30 Hours</li>
      <li><strong>💰 Fees:</strong> ₹199</li>
      <li><strong>🏫 Institute:</strong> SmartCampus360</li>
      <li><strong>📜 Certificate:</strong> Complete Full Course And Get Certificate</li>
    </ul>
  </div>
  <div class="about-images" onclick="openCourse('Full Stack Development')">
    <img src="images/webcourse.jpg" alt="Course Image 1">
  </div>
</div>

  <hr>
<div class="about">
  <div class="about-images" onclick="openCourse('cybersecurity')">
    <img src="images/Cybersecurity.jpg" alt="Course Image 1">
  </div>
  <div class="about-text">
    <h2>  Cybersecurity</h2>
    <p>
      Learn how to protect systems, networks, and data from cyber threats.
      Master fundamentals to advanced topics with hands-on labs and real-world case studies.
    </p>
    <ul>
      <li><strong>📅 Duration:</strong> 12 Hours</li>
      <li><strong>💰 Fees:</strong> ₹199</li>
      <li><strong>🏫 Institute:</strong> SmartCampus360</li>
      <li><strong>📜 Certificate:</strong> Complete Full Course And Get Certificate</li>
    </ul>
  </div>
</div>
</div>
</section>

  </section>

  <!-- =============== Courses Section ================== -->

  <section class="courses-div cota" id="course" style="background-color:#494444ff">
    <h2 class="heading">Get Choice of Your Course </h2>
    <div class="container courses">
      <div class="sub-course" onclick="openCourse('c')">
        <img src="image/c.webp" class="course-img" alt="Course Image">
        <div class="rating">
          <span><i class="bi bi-star-fill"></i> 4.9</span>
          <i class="bi bi-play-circle-fill" style="padding-left: 50%;"></i>
        </div>
        <hr>
        <h6 class="c"><b>Learn <u>C</u> Programming<br>Beginners</b></h6>
      </div>

      <div class="sub-course" onclick="openCourse('html')">
        <img src="image/html.jpg" class="course-img" alt="Course Image">
        <div class="rating">
          <span><i class="bi bi-star-fill"></i> 4.5</span>
          <i class="bi bi-play-circle-fill" style="padding-left: 50%;"></i>
        </div>
        <hr>
        <h6 class="c"><b>Learn <u> HTML</u> Programming<br>Beginners</b></h6>
      </div>

      <div class="sub-course" onclick="openCourse('css')">
        <img src="image/css.jpg" class="course-img" alt="Course Image">
        <div class="rating">
          <span><i class="bi bi-star-fill"></i> 4.7</span>
          <i class="bi bi-play-circle-fill" style="padding-left: 50%;"></i>
        </div>
        <hr>
        <h6 class="c"><b>Learn <u>CSS</u> Programming<br>Beginners</b></h6>
      </div>

      <div class="sub-course" onclick="openCourse('javascript')">
        <img src="image/javasrcript.jpg" class="course-img" alt="Course Image">
        <div class="rating">
          <span><i class="bi bi-star-fill"></i> 5</span>
          <i class="bi bi-play-circle-fill" style="padding-left: 50%;"></i>
        </div>
        <hr>
        <h6 class="c"><b>Learn <u>JavaScript</u> Programming<br>Beginners</b></h6>
      </div>

      <div class="sub-course" onclick="openCourse('react')">
        <img src="image/react.png" class="course-img" alt="Course Image">
        <div class="rating">
          <span><i class="bi bi-star-fill"></i> 4.5</span>
          <i class="bi bi-play-circle-fill" style="padding-left: 50%;"></i>
        </div>
        <hr>
        <h6 class="c"><b>Learn <u>REACT</u> Programming<br>Beginners</b></h6>
      </div>

      <div class="sub-course" onclick="openCourse('java')">
        <img src="image/java.jpg" class="course-img" alt="Course Image">
        <div class="rating">
          <span><i class="bi bi-star-fill"></i> 4.5</span>
          <i class="bi bi-play-circle-fill" style="padding-left: 50%;"></i>
        </div>
        <hr>
        <h6 class="c"><b>Learn <u>JAVA</u> Programming<br>Beginners</b></h6>
      </div>

      <div class="sub-course" onclick="openCourse('python')">
        <img src="image/python.png" class="course-img" alt="Course Image">
        <div class="rating">
          <span><i class="bi bi-star-fill"></i> 4.5</span>
          <i class="bi bi-play-circle-fill" style="padding-left: 50%;"></i>
        </div>
        <hr>
        <h6 class="c"><b>Learn <u>PYTHON</u> Programming<br>Beginners</b></h6>
      </div>

      <div class="sub-course" onclick="openCourse('sql')">
        <img src="image/sql.avif" class="course-img" alt="Course Image">
        <div class="rating">
          <span><i class="bi bi-star-fill"></i> 4.5</span>
          <i class="bi bi-play-circle-fill" style="padding-left: 50%;"></i>
        </div>
        <hr>
        <h6 class="c"><b>Learn <u>SQL</u> Programming<br>Beginners</b></h6>
      </div>
    </div>
  </section>

   <section class="companies-section">
    <h2>Our Top Hiring Companies</h2>
    <div class="slider">
      <div class="slide-track">
        <!-- कंपनी कार्ड्स -->
        <div class="card"><img src="https://1000logos.net/wp-content/uploads/2021/04/Microsoft-logo.png" alt="Microsoft"></div>
        <div class="card"><img src="https://1000logos.net/wp-content/uploads/2016/10/Amazon-Logo.png" alt="Amazon"></div>
        <div class="card"><img src="https://1000logos.net/wp-content/uploads/2021/05/Google-logo.png" alt="Google"></div>
        <div class="card"><img src="https://1000logos.net/wp-content/uploads/2016/10/Apple-Logo.png" alt="Apple"></div>
        <div class="card"><img src="https://1000logos.net/wp-content/uploads/2020/08/Infosys-Logo.png" alt="Infosys"></div>
        <div class="card"><img src="https://logo.clearbit.com/tcs.com" alt="TCS"></div>
        <div class="card"><img src="https://logo.clearbit.com/ibm.com" alt="IBM"></div>

        <!-- seamless loop साठी रिपीट -->
        <div class="card"><img src="https://1000logos.net/wp-content/uploads/2021/04/Microsoft-logo.png" alt="Microsoft"></div>
        <div class="card"><img src="https://1000logos.net/wp-content/uploads/2016/10/Amazon-Logo.png" alt="Amazon"></div>
        <div class="card"><img src="https://1000logos.net/wp-content/uploads/2021/05/Google-logo.png" alt="Google"></div>
        <div class="card"><img src="https://1000logos.net/wp-content/uploads/2016/10/Apple-Logo.png" alt="Apple"></div>
        <div class="card"><img src="https://1000logos.net/wp-content/uploads/2020/08/Infosys-Logo.png" alt="Infosys"></div>
        <div class="card"><img src="https://1000logos.net/wp-content/uploads/2020/09/TCS-Logo.png" alt="TCS"></div>
        <div class="card"><img src="https://1000logos.net/wp-content/uploads/2016/10/IBM-Logo.png" alt="IBM"></div>
      </div>
    </div>
  </section>


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
          <li><a href="student_index.php">Home</a></li>
          <li><a href="#course">Courses</a></li>
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
    // Close profile on outside click
    document.addEventListener("click", function (event) {
      const profile = document.getElementById("profileSection");
      const icon = event.target.closest(".nav-item");
      const insidePanel = profile.contains(event.target);

      if (!icon && !insidePanel) {
        profile.style.display = "none";
      }
    });
    function openCourse(lang) {
      window.location.href = `coures_data.php?lang=${lang}`;
    }

    
  </script>
</body>
</html>
