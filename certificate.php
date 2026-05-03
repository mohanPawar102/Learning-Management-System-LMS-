<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$student_id = $_SESSION['username'];
$course = $_GET['course'] ?? '';
$percentage = $_GET['percentage'] ?? '';
$date = $_GET['issued_at'] ?? '';


if ($course === '') {
    die("Course not selected!");
}

// Check payment status
$chk = $pdo->prepare("SELECT status FROM payments WHERE username=? AND course_name=?");
$chk->execute([$student_id, $course]);
$row = $chk->fetch(PDO::FETCH_ASSOC);

if (!$row || $row['status'] !== 'paid') {
    die("❌ You have not paid for this course.");
}

// Check if certificate already issued
$chkCert = $pdo->prepare("SELECT cert_number, percentage FROM certificates WHERE username=? AND course_name=?");
$chkCert->execute([$student_id, $course]);
$certRow = $chkCert->fetch(PDO::FETCH_ASSOC);

if ($certRow) {
    // Already exists
    $cert_number = $certRow['cert_number'];
    $finalPercentage = $certRow['percentage'];
    $date = $_GET['issued_at'] ?? '';

} else {
    // Generate unique certificate number (eg: CERT2025-XXXXXX)
    $cert_number = "CERT" . date("Y") . "-" . strtoupper(substr(md5(uniqid()), 0, 6));

    // Insert into certificates table
   $ins = $pdo->prepare("INSERT INTO certificates (username, course_name, cert_number, percentage) VALUES (?,?,?,?)");
$ins->execute([$student_id, $course, $cert_number, $percentage]);

    $finalPercentage = $percentage;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Certificate</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background: #f4f4f9;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .certificate {
      margin-top: 150px;
      width: 1100px;
      /* certificate ची actual width */
      height: 780px;
      /* certificate ची actual height */
      background: url("image/certificate.jpg") no-repeat center center;
      background-size: cover;
      /* पूर्ण image cover */
      font-family: 'Times New Roman', serif;
      text-align: center;
      position: relative;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
      padding: 0;
      /* padding काढून टाकलं */
      border: none;
      /* border काढलं */
    }

    .certificate h1 {
      font-size: 62px;
      letter-spacing: 2px;
      color: #f7f4f4ff;
      font-family: Georgia, serif;
      font-weight: bold;
      margin-top: 90px;
    }

    h2 {
      margin-top: -20px;
      font-size: 38px;
      color: #f9f5f5ff;
      font-style: italic;
    }

    h3 {
      font-family: "Playfair Display", serif;
      /* Elegant, handwriting look */
      font-size: 68px;
      /* Big font size */
      font-weight: bold;
      /* Strong weight */
      font-style: italic;
      /* Italic touch */
      color: #2c3e50;
      /* Dark elegant color */
      letter-spacing: 2px;
      /* थोडं space letters मध्ये */
      margin-top: -20px;
      margin-bottom: -10px;
    }

    p {
      text-transform: uppercase;
      /* सर्व capital letters मध्ये */
      letter-spacing: 3px;
      /* अक्षरांमधील space */
      word-spacing: 6px;
      /* शब्दांमधील space */
      font-size: 18px;
      /* font size */
      font-weight: bold;
      /* जाड अक्षरे */
    }

    .percentage {
      font-size: 25px;
      font-weight: bold;
      margin-top: 15px;
    }

    .cert-number {
      position: absolute;
      top: 30px;
      right: 50px;
      font-size: 16px;
      color: #444;
    }

    .para {
      margin-top: 260px;
    }

    .circle {
      display: flex;
      justify-content: center;
      align-items: center;
      margin: -425px auto;
      position: absolute;
      left: 38.5%;
    }

    /* signature sections */
    .signatures {
      position: absolute;
      bottom: 30px;
      width: 100%;
      display: flex;
      justify-content: space-around;
      text-align: center;
      gap: 400px;
    }

    .signatures div {
      font-size: 16px;
      color: #111;
    }

    .signatures img {
      height: 100px;
      margin-left: -20px;
      margin-bottom: -60px;
    }

    @media (max-width: 992px) {
      .circle {
        left: 365px;
      }

    }

    @media print {
      body {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
      }
      .circle {
        left:36%;
      }
    }
  </style>
</head>

<body>
  <div class="certificate">
    <h1>CERTIFICATE <br>
      <h2>OF COMPLETION</h2>
    </h1>
    <div class="para">
      <p>This certificate is proudly presented to</p>
      <h3>
        <?php echo htmlspecialchars($student_id); ?>
      </h3>
      <p style="margin-bottom:-10px">CONGRATULATIONS!</P>
      <h4>This certificate is proudly presented in recognition of outstanding performance ,<br> in the <b
          style="color:green;font-size:20px">
          <?php echo strtoupper(htmlspecialchars($course)); ?> Course
        </b> with a <b style="color:green;font-size:20px"> Scored:
          <?php echo htmlspecialchars($finalPercentage); ?>%
        </b>.”</h4>
      <p class="cert-number"> Certificate No:
        <?php echo $cert_number; ?><br>Issued on:
        <?php echo date("d M Y"); ?>
      </p>


      <div class="circle">
        <svg viewBox="0 0 200 200" width="230" height="220">
          <defs>
            <path id="circlePath" d="M 100, 100
               m -75, 0
               a 75,75 0 1,1 150,0
               a 75,75 0 1,1 -150,0" />
          </defs>
          <text font-size="18" font-family="Georgia" fill="#000306ff" font-weight="bold">
            <textPath href="#circlePath">
              ★ SMARTCAMPUS360 ★
            </textPath>
          </text>
        </svg>
      </div>
      <div class="signatures">
        <div>
          <img src="image/sin.png" />
          <p>____________________</p>
          <p>Mohan Pawar</p>
        </div>
        <div>
          <img src="image/stamp.png" style="width:200px;height:100px" />
          <p>____________________</p>
          <p>Institute</p>
        </div>
      </div>
    </div>
  </div>

</body>

</html>