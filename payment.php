<?php
session_start();
include 'db.php'; // इथे $pdo आहे

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$student_id = $_SESSION['username'];
$course = $_GET['course_name'] ?? ''; 
$percentage = $_GET['percentage'] ?? '';

if ($course === '') {
    die("Course not selected!");
}

// 1️⃣ आधीपासून payment आहे का ते check कर
$chk = $pdo->prepare("SELECT status FROM payments WHERE username=? AND course_name=?");
$chk->execute([$student_id, $course]);
$row = $chk->fetch(PDO::FETCH_ASSOC);

if ($row && $row['status'] === 'paid') {
    // जर आधीच certificate तयार असेल तर direct certificate.php वर जा
    header("Location: certificate.php?course=" . urlencode($course));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = 199.00;
    $st = "paid";

    // 2️⃣ Payment insert/update
    $up = $pdo->prepare("INSERT INTO payments (username, course_name, amount, status, paid_at)
            VALUES (?,?,?,?,NOW())
            ON DUPLICATE KEY UPDATE status=VALUES(status), paid_at=NOW()");
    $up->execute([$student_id, $course, $amount, $st]);

    // 3️⃣ Certificate फक्त पहिल्यांदा तयार करायचा
    if ($percentage !== '') {
        $chk = $pdo->prepare("SELECT id FROM certificates WHERE username=? AND course_name=?");
        $chk->execute([$student_id, $course]);
        $exist = $chk->fetch(PDO::FETCH_ASSOC);

        if (!$exist) {
            // Unique certificate number
            $cert_number = strtoupper(uniqid("CERT"));

            $cert = $pdo->prepare("
                INSERT INTO certificates (username, course_name, cert_number, percentage, issued_at)
                VALUES (?,?,?,?,NOW())
            ");
            $cert->execute([$student_id, $course, $cert_number, $percentage]);
        }
    }

    // 4️⃣ Payment + Certificate झाल्यावर direct certificate page
    header("Location: certificate.php?course=" . urlencode($course));
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Demo Payment</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f5f5f5;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .payment-box {
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.2);
      width: 400px;
    }
    .payment-box h2 {
      text-align: center;
      color: #333;
    }
    .payment-box input, .payment-box button {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 8px;
    }
    .payment-box button {
      background: #28a745;
      color: #fff;
      font-weight: bold;
      cursor: pointer;
    }
    .payment-box button:hover {
      background: #218838;
    }
    .course-info {
      text-align: center;
      margin-bottom: 15px;
    }
  </style>
</head>
<body>
  <div class="payment-box">
    <h2>Payment Page</h2>
    <div class="course-info">
      <p><strong>Course:</strong> <?php echo htmlspecialchars($course); ?></p>
      <p><strong>Amount:</strong> ₹199</p>
      <?php if ($percentage !== ''): ?>
        <p><strong>Score:</strong> <?php echo htmlspecialchars($percentage); ?>%</p>
      <?php endif; ?>
    </div>
    <form method="POST">
      <input type="text" name="card_name" placeholder="Card Holder Name" required>
      <input type="text" name="card_number" placeholder="Card Number" required maxlength="16">
      <input type="text" name="expiry" placeholder="MM/YY" required>
      <input type="password" name="cvv" placeholder="CVV" required maxlength="3">
      <button type="submit">Pay ₹199</button>
    </form>
  </div>
</body>
</html>
