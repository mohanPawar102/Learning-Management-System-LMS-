<?php
session_start();
include 'db.php'; // ✅ path इथे योग्य ठेवा

if (isset($_SESSION['username']) && isset($_GET['course'])) {
    $username = $_SESSION['username'];
    $course = $_GET['course'];

    // ✅ PDO वापरतोस म्हणून $pdo वापर
    $stmt = $pdo->prepare("SELECT last_time FROM video_progress WHERE username=? AND course_name=?");
    $stmt->execute([$username, $course]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        echo $row['last_time'];
    } else {
        echo 0;
    }
} else {
    echo 0;
}
?>
