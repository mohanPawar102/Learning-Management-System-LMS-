<?php
session_start();
include("db.php");

// ✅ Backend part (AJAX request आला का ते तपासा)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['course_name'], $_POST['percentage'])) {
    if (!isset($_SESSION['username'])) {
        die("Not logged in");
    }

    $username   = $_SESSION['username'];
    $courseName = $_POST['course_name'];
    $percentage = $_POST['percentage'];

    // फक्त एकदाच store करायचं असेल तर INSERT पेक्षा UPDATE आधी check कर
    $stmt = $conn->prepare("SELECT id FROM certificates WHERE username=? AND course_name=?");
    $stmt->bind_param("ss", $username, $courseName);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        echo "⚠️ Already stored for this course";
    } else {
        $stmt = $conn->prepare("INSERT INTO certificates (username, course_name, percentage, issued_at, downloaded) VALUES (?, ?, ?, NOW(), 0)");
        $stmt->bind_param("ssi", $username, $courseName, $percentage);
        $stmt->execute();
        echo "✅ Percentage saved successfully";
    }
    exit;
}
?>
