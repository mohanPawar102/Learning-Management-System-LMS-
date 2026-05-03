<?php
session_start();
require 'db.php';

$role = $_POST['role'] ?? '';
$userid = $_POST['userid'] ?? '';
$password = $_POST['password'] ?? '';

if($role === 'college') {
    $stmt = $pdo->prepare("SELECT * FROM colleges WHERE college_id=?");
    $stmt->execute([$userid]);
    $college = $stmt->fetch(PDO::FETCH_ASSOC);

    if($college && password_verify($password, $college['password_hash'])) {
        $_SESSION['role'] = 'college';
        $_SESSION['user_id'] = $college['id'];
        $_SESSION['username'] = $college['name'];
        header("Location: college/college_dashboard.php");
        exit;
    } else {
        header("Location: login.php?error=Invalid College Login");
        exit;
    }
}

if($role === 'student') {
    $stmt = $pdo->prepare("SELECT * FROM students WHERE student_id=?");
    $stmt->execute([$userid]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if($student && password_verify($password, $student['password_hash'])) {
        // ✅ बरोबर login
        $_SESSION['role'] = 'student';
        $_SESSION['user_id'] = $student['id'];
        $_SESSION['username'] = $student['name'];
        header("Location: student_index.php");
        exit;
    } else {
        // ❌ invalid
        header("Location: login.php?error=Invalid Student ID or Password");
        exit;
    }
}



?>
