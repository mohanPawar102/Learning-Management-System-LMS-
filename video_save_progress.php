<?php
session_start();
require 'db.php';

if (!isset($_SESSION['username'])) {
    die("❌ User not logged in");
}

if (!isset($_POST['course']) || !isset($_POST['time'])) {
    die("❌ Error: POST data missing");
}

$username = $_SESSION['username'];
$course = $_POST['course'];
$time = floatval($_POST['time']);

// ✅ Get previous saved time
$stmt = $pdo->prepare("SELECT last_time FROM video_progress WHERE username=? AND course_name=?");
$stmt->execute([$username, $course]);
$existing = $stmt->fetch(PDO::FETCH_ASSOC);

if ($existing) {
    $old_time = floatval($existing['last_time']);

    // ✅ Update only if new time > old time
    if ($time > $old_time) {
        $update = $pdo->prepare("UPDATE video_progress SET last_time=?, updated_at=NOW() WHERE username=? AND course_name=?");
        $update->execute([$time, $username, $course]);
        echo "✅ Updated to $time sec";
    } else {
        echo "⏸ No update (new time smaller)";
    }
} else {
    // ✅ First time entry
    $insert = $pdo->prepare("INSERT INTO video_progress (username, course_name, last_time) VALUES (?, ?, ?)");
    $insert->execute([$username, $course, $time]);
    echo "✅ Saved new record";
}
?>
