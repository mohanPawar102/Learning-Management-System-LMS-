<?php
session_start(); // ✅ session सुरू करणे

require 'db.php';

$student = null;
$total_paid = 0;
$remaining = 0;
$first_payment_id = 0;

// Search by ID or Name
if (isset($_POST['search'])) {
    $search = $_POST['student_id'];
    $stmt = $pdo->prepare("SELECT * FROM ofline_students WHERE id = ? OR name LIKE ?");
    $stmt->execute([$search, "%$search%"]);
    $student = $stmt->fetch();

    if ($student) {
        $stmt2 = $pdo->prepare("SELECT SUM(amount) FROM fee_payments WHERE student_id = ?");
        $stmt2->execute([$student['id']]);
        $total_paid = $stmt2->fetchColumn() ?: 0;
        $remaining = $student['total_fee'] - $total_paid;

        // Get first payment id for receipt link
        $stmt3 = $pdo->prepare("SELECT id FROM fee_payments WHERE student_id = ? ORDER BY created_at ASC LIMIT 1");
        $stmt3->execute([$student['id']]);
        $first_payment = $stmt3->fetch();
        $first_payment_id = $first_payment ? $first_payment['id'] : 0;
    }
}

// Pay Remaining Fee
if (isset($_POST['pay_fee'])) {
    $sid = $_POST['sid'];
    $amount = $_POST['amount'];

    if ($amount > 0) {
        $stmt = $pdo->prepare("INSERT INTO fee_payments (student_id, amount, note, created_at) VALUES (?,?,?,NOW())");
        $stmt->execute([$sid, $amount, "Installment"]);
        $last_id = $pdo->lastInsertId();

        $receipt_no = "PAY-" . date("Y") . "-" . $sid . "-" . $last_id;
        $stmt = $pdo->prepare("UPDATE fee_payments SET receipt_no = ? WHERE id = ?");
        $stmt->execute([$receipt_no, $last_id]);

        echo "<script>
            alert('Payment Added Successfully!');
            window.open('receipt.php?pid=$last_id', '_blank');
            window.location='student_list.php';
        </script>";
    } else {
        echo "<script>alert('Enter a valid amount!'); window.history.back();</script>";
    }
}

// Cancel Admission
if (isset($_POST['cancel_admission'])) {
    $sid = $_POST['sid'];
    $stmt = $pdo->prepare("UPDATE ofline_students SET status = 'cancelled' WHERE id = ?");
    $stmt->execute([$sid]);

    echo "<script>alert('Admission Cancelled!'); window.location='student_list.php';</script>";
}

// Fetch all students
$all_students = $pdo->query("SELECT * FROM ofline_students ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Student List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="styleColleg.css"/>
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
        <div class="container-fluid p-4">
            <h2 class="mb-4">All Students</h2>

            <!-- Search Form -->
            <form method="post" class="mb-4">
                <div class="input-group">
                    <input type="text" name="student_id" class="form-control" placeholder="Enter Student ID or Name">
                    <button type="submit" name="search" class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
                </div>
            </form>

            <!-- Searched Student -->
            <?php if ($student): ?>
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($student['name']) ?> (ID: <?= $student['id'] ?>)</h5>
                    <p><b>Course:</b> <?= htmlspecialchars($student['course']) ?></p>
                    <p><b>Total Fee:</b> ₹<?= $student['total_fee'] ?></p>
                    <p><b>Total Paid:</b> ₹<?= $total_paid ?></p>
                    <p><b>Remaining Fee:</b> ₹<?= $remaining ?></p>
                    <p><b>Status:</b> <?= htmlspecialchars($student['status']) ?></p>

                    <?php if ($student['status'] == 'active'): ?>
                    <form method="post" class="mt-3">
                        <input type="hidden" name="sid" value="<?= $student['id'] ?>">
                        <div class="mb-3">
                            <label>Pay Remaining Fee</label>
                            <input type="number" name="amount" class="form-control" placeholder="Enter amount">
                        </div>
                        <button type="submit" name="pay_fee" class="btn btn-success"><i class="fas fa-plus-circle"></i> Add Payment</button>
                        <button type="submit" name="cancel_admission" class="btn btn-danger" onclick="return confirm('Cancel this admission?');"><i class="fas fa-times-circle"></i> Cancel Admission</button>
                        <?php if ($first_payment_id): ?>
                        <a href="receipt.php?pid=<?= $first_payment_id ?>" class="btn btn-warning"><i class="fas fa-file-invoice"></i> Admission Receipt</a>
                        <?php endif; ?>
                    </form>
                    <?php else: ?>
                    <p class="text-danger"><b>Admission Cancelled</b></p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- All Students Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Course</th>
                            <th>Total Fee</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($all_students as $row): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['mobile']) ?></td>
                            <td><?= htmlspecialchars($row['course']) ?></td>
                            <td>₹<?= $row['total_fee'] ?></td>
                            <td><?= htmlspecialchars($row['status'] ?? 'active') ?></td>
                            <td>
                                <a href="student_receipts.php?sid=<?= $row['id'] ?>" class="btn btn-info btn-sm"><i class="fas fa-receipt"></i> Receipts</a>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="sid" value="<?= $row['id'] ?>">
                                    <button type="submit" name="cancel_admission" class="btn btn-danger btn-sm" onclick="return confirm('Cancel admission?');"><i class="fas fa-ban"></i> Cancel</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
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











