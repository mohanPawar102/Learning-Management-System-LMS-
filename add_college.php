<?php
require 'db.php';

$college_id = "102102";
$password = "college123"; // plain text
$name = "My College";

// hash तयार करा
$hash = password_hash($password, PASSWORD_DEFAULT);

// insert करा
$stmt = $pdo->prepare("INSERT INTO colleges (college_id, password_hash, name) VALUES (?, ?, ?)");
$stmt->execute([$college_id, $hash, $name]);

echo "✅ College inserted successfully!";
