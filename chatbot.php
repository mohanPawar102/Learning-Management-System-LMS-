<?php
session_start();
include "config.php";

if (!isset($_SESSION['chat_history'])) {
    $_SESSION['chat_history'] = []; // सुरुवातीला रिकामी history
}

function call_gemini($api_key, $message) {
    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . $api_key;

    $payload = [
        "contents" => [[ "parts" => [[ "text" => $message ]] ]]
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    $result = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);

    if ($err) {
        return "cURL Error: " . $err;
    }

    $data = json_decode($result, true);

    if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
        return $data['candidates'][0]['content']['parts'][0]['text'];
    } else {
        return "Error: Couldn't get response from Gemini API.";
    }
}

// Form submit handle
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userMessage = trim($_POST["message"] ?? "");
    if (!empty($userMessage)) {
        $userMessage = strip_tags($userMessage);
        $botReply = call_gemini($GEMINI_API_KEY, $userMessage);

        // Chat history मध्ये save करा
        $_SESSION['chat_history'][] = ["role" => "user", "text" => $userMessage];
        $_SESSION['chat_history'][] = ["role" => "bot", "text" => $botReply];
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>College Chatbot (Gemini)</title>
    <style>
        .chatbox { width: 98%;height:100%; margin: auto;   }
        .msg { margin: 8px 0; padding: 8px; border-radius: 6px; }
        .user { background: #b6bcbdff; text-align: right;color:black; }
        .bot { background: #c5c9c9ff; text-align: left; color:black;}
        input[type=text] { width: 90%; padding: 15px; border-radius:10px }
        button { margin-top: 10px; padding: 14px; border-radius:10px;width:100px ;background-color:green}
    </style>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
<div class="chatbox">
     <!-- Header -->
  <header class="navbar">
    <div class="logo">Smart<span>Campus</span><strong>360</strong></div>
    <nav class="nav-links">
      <a href="student_index.php">Home</a>
      <a href="#course">Courses</a>
      <a href="contact.php">Contact</a>
  
  </header>

    <div style="height:400px; overflow-y:auto; border:1px solid #ccc; padding:8px; margin-bottom:10px; background-color:white">
        <?php if (!empty($_SESSION['chat_history'])): ?>
            <?php foreach ($_SESSION['chat_history'] as $chat): ?>
                <div class="msg <?= $chat['role'] ?>">
                    <strong><?= ucfirst($chat['role']) ?>:</strong> <?= nl2br(htmlspecialchars($chat['text'])) ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <form method="POST" style="margin-bottom:0%">
        <input type="text" name="message" placeholder="Type your question..." required>
        <button type="submit" id="send">Send</button>
    </form>
</div>
<footer class="custom-footer">
    <div class="footer-container">
      <div class="footer-brand">
        <div class="logo">Smart<span>Campus</span><strong>360</strong></div>
        <p>Empowering future developers with modern web technologies.</p>
      </div>
      <div class="footer-links">
        <h4>Quick Links</h4>
        <ul>
          <li><a href="college_dashboard.php">Home</a></li>
        </ul>
      </div>
      <div class="footer-contact">
        <h4>Contact</h4>
        <p><i class="bi bi-telephone-fill"></i> +91 755-832-7748</p>
        <p><i class="bi bi-envelope-fill"></i> smartcampus360@gmail.com</p>
      </div>
    </div>
    <div class="footer-bottom">
      <p>© 2025 SmartCampus360 | Designed by <u>Mohan Pawar</u></p>
    </div>
  </footer>
</body>


<script>
const sendBtn = document.getElementById('send');
const messageInput = document.querySelector('input[name="message"]');
const chatBox = document.querySelector('div[style*="overflow-y:auto"]'); // तुमच्या chat history div

sendBtn.addEventListener("click", function(e){
    e.preventDefault(); // page reload थांबवणे

    const message = messageInput.value.trim();
    if(!message) return;

    // 1️⃣ User message display
    const userDiv = document.createElement('div');
    userDiv.className = 'msg user';
    userDiv.innerHTML = `<strong>User:</strong> ${message}`;
    chatBox.appendChild(userDiv);
    chatBox.scrollTop = chatBox.scrollHeight; // auto scroll

    // 2️⃣ Send AJAX request
    const formData = new FormData();
    formData.append('message', message);

    fetch('chatbot.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
    .then(responseHTML => {
        // Parse server response to get bot message
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = responseHTML;

        // Extract last bot message
        const botMsg = tempDiv.querySelector('div.msg.bot:last-child');
        if(botMsg){
            chatBox.appendChild(botMsg);
            chatBox.scrollTop = chatBox.scrollHeight; // auto scroll
        }

        messageInput.value = ''; // clear input
        messageInput.focus();
    })
    .catch(err => console.error(err));
});
</script>

</html>
