<?php
session_start();
require 'db.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role']!=='student') {
  header("Location: login.php");
  exit;
}

$name = $_POST['name'] ?? '';
$imageName = null;

// File upload check
if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $targetDir = "uploads/";
    if(!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true); // create folder if not exists
    }

    $imageName = time() . "_" . basename($_FILES['image']['name']);
    $targetFile = $targetDir . $imageName;

    if(move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
        // file uploaded
    } else {
        die("❌ Image upload failed!");
    }
}

// Update student info
if($imageName) {
    $stmt = $pdo->prepare("UPDATE students SET name=?, image=? WHERE id=?");
    $stmt->execute([$name, $imageName, $_SESSION['user_id']]);
} else {
    $stmt = $pdo->prepare("UPDATE students SET name=? WHERE id=?");
    $stmt->execute([$name, $_SESSION['user_id']]);
}

// Update session
$_SESSION['username'] = $name;

header("Location: student_profile.php?success=1");
exit;
