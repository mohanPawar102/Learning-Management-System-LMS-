<?php
require 'db.php';
$pid = $_GET['pid'];

// Get payment + student info
$stmt = $pdo->prepare("SELECT f.*, s.name, s.course, s.total_fee, s.roll_no 
                       FROM fee_payments f
                       JOIN ofline_students s ON f.student_id=s.id
                       WHERE f.id=?");

$stmt->execute([$pid]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

// Total paid till now
$totalPaidStmt = $pdo->prepare("SELECT SUM(amount) FROM fee_payments WHERE student_id=?");
$totalPaidStmt->execute([$data['student_id']]);
$total_paid = $totalPaidStmt->fetchColumn();

$remaining = $data['total_fee'] - $total_paid;
?>
<!DOCTYPE html>
<html>
<head>
   <title>Admission Receipt</title>
    <link rel="stylesheet" href="styleColleg.css" />
   
</head>
<body>
<div class="receipt">
   <h2>🎓 College Admission Receipt</h2>
   <div class="info"><b>Receipt No:</b> <?= $data['receipt_no'] ?? $data['id'] ?></div>
   <div class="info"><b>Roll No:</b> <?= htmlspecialchars($data['roll_no']) ?></div>
   <div class="info"><b>Student:</b> <?= htmlspecialchars($data['name']) ?></div>
   <div class="info"><b>Course:</b> <?= htmlspecialchars($data['course']) ?></div>
   <div class="info"><b>Paid This Time:</b> ₹<?= $data['amount'] ?></div>
   <div class="info"><b>Date:</b> <?= $data['created_at'] ? date("d-m-Y", strtotime($data['created_at'])) : date("d-m-Y") ?></div>

   <div class="summary">
      <p><b>Total Fees:</b> ₹<?= $data['total_fee'] ?></p>
      <p class="paid"><b>Total Paid:</b> ₹<?= $total_paid ?></p>
      <p class="remaining"><b>Remaining Balance:</b> ₹<?= $remaining ?></p>
   </div>

   <button class="print-btn" onclick="window.print()">🖨 Print Receipt</button>
</div>
</body>
</html>
