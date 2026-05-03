<?php
include 'db.php';

$student_id = $_POST['student_id'];
$course     = $_POST['course'];
$percent    = $_POST['percent'];
$time       = $_POST['time'];

// record आहे का check
$chk = $pdo->prepare("SELECT id FROM student_progress WHERE student_id=? AND course_name=?");
$chk->execute([$student_id, $course]);

if ($chk->rowCount() > 0) {
    // Update
    $upd = $pdo->prepare("UPDATE course_progress 
        SET progress_percent=?, last_watched_time=?, created_at=NOW() 
        WHERE student_id=? AND course_name=?");
    $upd->execute([$percent, $time, $student_id, $course]);
} else {
    // Insert
    $ins = $pdo->prepare("INSERT INTO course_progress 
        (student_id, course_name, progress_percent, last_watched_time, created_at) 
        VALUES (?,?,?,?,NOW())");
    $ins->execute([$student_id, $course, $percent, $time]);
}
?>
<?php
session_start();
if (!isset($_SESSION['username'])) { http_response_code(401); exit("Unauthorized"); }

require_once __DIR__ . "/db.php";

$student = $_SESSION['username'];
$course  = $_POST['course_name'] ?? '';
$time    = (int)($_POST['time'] ?? 0);

if ($course === '') { http_response_code(400); exit("Invalid course"); }

$sql = "INSERT INTO course_progress (student_id, course_name, last_watched_time, created_at)
        VALUES (?,?,?,NOW())
        ON DUPLICATE KEY UPDATE last_watched_time=VALUES(last_watched_time), created_at=NOW()";

$stmt = $pdo->prepare($sql);
$stmt->execute([$student, $course, $time]);

echo "ok";
