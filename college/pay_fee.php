<?php
require 'db.php';
$student_id = $_GET['sid'] ?? null;

if(!$student_id) die("Student ID required");

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $amount = $_POST['amount'];
    if($amount <= 0) die("Invalid Amount!");

    $stmt = $pdo->prepare("INSERT INTO fee_payments (student_id, amount) VALUES (?,?)");
    $stmt->execute([$student_id,$amount]);

    header("Location: receipt.php?sid=$student_id&amt=$amount");
    exit;
}

// get student info
$st = $pdo->prepare("SELECT * FROM students WHERE id=?");
$st->execute([$student_id]);
$student = $st->fetch();

$total_paid = $pdo->query("SELECT SUM(amount) FROM fee_payments WHERE student_id=$student_id")->fetchColumn();
$remaining = $student['total_fee'] - $total_paid;
?>

<!doctype html>
<html>
<head><title>Pay Fee</title></head>
<body>
  <h2>Pay Fee for <?php echo $student['name']; ?> (ID: <?php echo $student['id']; ?>)</h2>
  <p>Course: <?php echo $student['course']; ?></p>
  <p>Total Fee: <?php echo $student['total_fee']; ?></p>
  <p>Already Paid: <?php echo $total_paid; ?></p>
  <p>Remaining: <?php echo $remaining; ?></p>

  <?php if($remaining > 0): ?>
  <form method="post">
    <label>Pay Amount:</label>
    <input type="number" name="amount" max="<?php echo $remaining; ?>" required>
    <button type="submit">Pay Now</button>
  </form>
  <?php else: ?>
  <p><strong>All fees paid!</strong></p>
  <?php endif; ?>
</body>
</html>
