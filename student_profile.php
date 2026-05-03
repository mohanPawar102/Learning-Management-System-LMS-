<?php
session_start();
require 'db.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role']!=='student') {
  header("Location: login.php");
  exit;
}

// Get student info
$stmt = $pdo->prepare("SELECT * FROM students WHERE id=?");
$stmt->execute([$_SESSION['user_id']]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Profile</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f5f6fa;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 600px;
      margin: 50px auto;
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      text-align: center;
    }

    h2 {
      color: #2c3e50;
      margin-bottom: 20px;
    }

    img {
      border-radius: 50%;
      margin-bottom: 15px;
      border: 3px solid #3498db;
    }

    label {
      display: block;
      text-align: left;
      margin: 10px 0 5px;
      font-weight: bold;
      color: #34495e;
    }

    input[type="text"], input[type="file"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    button {
      background: #3498db;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 6px;
      cursor: pointer;
      transition: 0.3s;
      font-size: 16px;
    }

    button:hover {
      background: #2980b9;
    }

    a {
      display: inline-block;
      margin-top: 15px;
      color: #e74c3c;
      text-decoration: none;
      font-weight: bold;
    }

    a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Welcome, <?php echo htmlspecialchars($student['name']); ?></h2>
    
    <?php if($student['image']): ?>
      <img src="uploads/<?php echo htmlspecialchars($student['image']); ?>" width="120" height="120">
    <?php else: ?>
      <p><i>No Image Uploaded</i></p>
    <?php endif; ?>

    <form method="post" action="update_student.php" enctype="multipart/form-data">
      <label>Name:</label>
      <input type="text" name="name" value="<?php echo htmlspecialchars($student['name']); ?>" required>

      <label>Upload Image:</label>
      <input type="file" name="image">

      <button type="submit">Update Profile</button>
    </form>

    <a href="logout.php">Logout</a>
  </div>
</body>
</html>
