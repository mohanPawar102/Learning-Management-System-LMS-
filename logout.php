<?php
session_start();
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Logout</title>
  <script>
    window.onload = function() {
      // Browser storage clear करा
      sessionStorage.clear();
      localStorage.clear();

      // current tab ला login page वर redirect
      window.location.replace("login.php");

      // optional: current tab बंद करायचा असल्यास
      // window.open('', '_self').close();
    }
  </script>
</head>
<body>
  <p>Logging out... Please wait...</p>
</body>
</html>
