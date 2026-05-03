<?php
session_start(); // session सुरू करणे
include("db.php"); // database connection

if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    // user check query
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($query);

    if($result->num_rows == 1){
        $row = $result->fetch_assoc();
        $role = $row['role']; // student किंवा college

        // ====== इथे add करा ======
        if($role == 'student'){
            $_SESSION['student_id'] = $row['id'];
            $_SESSION['student_role'] = 'student';
            header("Location: student_dashboard.php");
            exit();
        }

        if($role == 'college'){
            $_SESSION['college_id'] = $row['id'];
            $_SESSION['college_role'] = 'college';
            header("Location: college_dashboard.php");
            exit();
        }
        // =========================
    } else {
        echo "Invalid username or password";
    }
}

?>
<!DOCTYPE html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<html>
<head>
    <title>Login Page</title>
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

        .login-box {
            position: relative;
            z-index: 1;
            background: rgba(255,255,255,0.95);
            padding: 35px;
            border-radius: 16px;
            box-shadow: 0px 6px 20px rgba(0,0,0,0.2);
            width: 340px;
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }

        .login-box h2 {
            margin-bottom: 20px;
            color: #222;
        }

        .login-box input, 
        .login-box select {
            width: 92%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 15px;
        }

        .login-box button {
            width: 98%;
            padding: 12px;
            background: #4CAF50;
            border: none;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.3s;
        }

        .login-box button:hover {
            background: #45a049;
            transform: scale(1.03);
        }

        .register-btn {
            margin-top: 14px;
            background: #2196F3;
        }

        .register-btn:hover {
            background: #1976D2;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 8px;
        }
        .success {
            color: green;
            font-size: 14px;
            margin-bottom: 8px;
        }

        /* Simple fade animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Login</h2>
        <?php if(!empty($error)) echo "<p class='error'>$error</p>"; ?>
        <?php if(!empty($success)) echo "<p class='success'>$success</p>"; ?>

        <form method="POST" action="authenticate.php">
            <select name="role" required>
                <option value="student">Student</option>
                <option value="college">College</option>
            </select><br>

            <input type="text" name="userid" placeholder="User ID" required><br>
            <input type="password" name="password" placeholder="Password" required><br>

            <button type="submit">Login</button>
        </form>

        <!-- Registration Button -->
        <form action="registration.php" method="get">
            <button type="submit" class="register-btn">Register as Student</button>
        </form>
    </div>
</body>
</html>
