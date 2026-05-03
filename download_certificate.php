<?php
session_start();
include 'db.php';
require 'vendor/autoload.php';

use Dompdf\Dompdf;

$student_id = $_SESSION['username'];
$course = $_GET['course'] ?? '';
$percentage = $_GET['percentage'] ?? '';
$date = date("d M Y");

// Fetch certificate number
$chkCert = $pdo->prepare("SELECT cert_number FROM certificates WHERE username=? AND course_name=?");
$chkCert->execute([$student_id, $course]);
$certRow = $chkCert->fetch(PDO::FETCH_ASSOC);

$cert_number = $certRow['cert_number'] ?? 'N/A';

// HTML same as your certificate page
$html = '
<div style="width:1100px; height:780px; text-align:center; font-family:Georgia, serif; position:relative; background:url(\'image/certificate.jpg\') no-repeat center/cover;">
    <h1>CERTIFICATE <br><span style="font-size:38px;">OF COMPLETION</span></h1>
    <p>This certificate is proudly presented to</p>
    <h2>'.$student_id.'</h2>
    <p>CONGRATULATIONS!</p>
    <h3>For outstanding performance in the <b>'.$course.'</b> course with <b>'.$percentage.'%</b> score.</h3>
    <p>Certificate No: '.$cert_number.'<br>Issued on: '.$date.'</p>
</div>
';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("Certificate_{$student_id}.pdf", ["Attachment" => true]);
exit;
