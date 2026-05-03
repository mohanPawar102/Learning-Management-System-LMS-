<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $student_id = $_POST['student_id'] ?? '';
    $name = $_POST['name'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($student_id) && !empty($name) && !empty($password)) {
        // password hash
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // student_id आधीच आहे का ते check कर
        $stmt = $pdo->prepare("SELECT * FROM students WHERE student_id=?");
        $stmt->execute([$student_id]);
        if ($stmt->fetch()) {
            $error = "⚠️ Student ID आधीच नोंदवले आहे!";
        } else {
            // नवीन student insert
            $stmt = $pdo->prepare("INSERT INTO students (student_id, name, password_hash) VALUES (?, ?, ?)");
            $stmt->execute([$student_id, $name, $passwordHash]);

            header("Location: login.php?success=Registered Successfully, Please Login");
            exit;
        }
    } else {
        $error = "⚠️ सर्व फील्ड भरा!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Registration</title>
  <style>
     body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url("images/background.png") no-repeat center center fixed;
            background-size: cover;
            position: relative;
        }
        
        /* Blur background overlay */
        body::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.3);
            backdrop-filter: blur(8px);
            z-index: 0;
        }


    .container {
      width: 400px;
      background: #fff;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 6px 18px rgba(0,0,0,0.2);
      text-align: center;
      animation: fadeIn 1s ease-in-out;
      z-index: 1;
    }

    @keyframes fadeIn {
      from {opacity: 0; transform: translateY(-20px);}
      to {opacity: 1; transform: translateY(0);}
    }

    h2 {
      color: #2c3e50;
      margin-bottom: 20px;
    }

    label {
      display: block;
      text-align: left;
      font-weight: bold;
      margin-bottom: 5px;
      color: #34495e;
    }

    input[type="text"], input[type="password"] {
      width: 100%;
      padding: 12px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 8px;
      outline: none;
      transition: 0.3s;
    }

    input:focus {
      border-color: #3498db;
      box-shadow: 0 0 5px rgba(52,152,219,0.6);
    }

    button {
      width: 100%;
      background: #3498db;
      color: #fff;
      border: none;
      padding: 12px;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      transition: 0.3s;
    }

    button:hover {
      background: #2980b9;
    }

    .error {
      color: #e74c3c;
      margin-bottom: 15px;
      font-weight: bold;
    }

    p {
      margin-top: 15px;
    }

    a {
      color: #8e44ad;
      font-weight: bold;
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>📝 Student Registration</h2>

    <?php if(!empty($error)) echo "<p class='error'>$error</p>"; ?>

    <form method="POST">
      <label>Student ID:</label>
      <input type="text" name="student_id" placeholder="Enter your ID" required>

      <label>Name:</label>
      <input type="text" name="name" placeholder="Enter your Name" required>

      <label>Password:</label>
      <input type="password" name="password" placeholder="Enter Password" required>

      <button type="submit">Register</button>
    </form>

    <p>Already registered? <a href="login.php">Login</a></p>
  </div>
</body>
</html>
