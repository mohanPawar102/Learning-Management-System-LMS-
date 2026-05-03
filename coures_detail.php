<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>C Course</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<style>
</style>

<body>
  <!-- navbar  -->
  <header class="navbar">
    <div class="logo">Smart<span>Campus</span><strong>360</strong></div>
    <nav class="nav-links">
      <a href="student_index.php">Home</a>
      <a href="contact.php">Contact</a>
      <a href="chatbot.php"> <i class="bi bi-search">AI Search</i></a>
      <li class="nav-item mx-2" type="none">
        <a class="nav-link text-white" href="profile.php"><i class="bi bi-person-circle"></i></a>
      </li>
    </nav>
  </header>

  <!-- course vedio and text-->
  <section class="course-vedio" style="background-color:white;padding:50px;color:black;font-size:25px;border:1px solid black:">
  <div style=" display: flex;
  flex-wrap: wrap; gap: 30px;">
    <div style="width:850px;background-color:#E5E4E2;padding:50px;border-radius:20px;box-shadow: -19px 20px 39px 1px rgba(0,0,0,0.66);
          -webkit-box-shadow: -19px 20px 39px 1px rgba(0,0,0,0.66);
          -moz-box-shadow: -19px 20px 39px 1px rgba(0,0,0,0.66);">
    <h2 id="courseTitle" style="margin-left: 40%;opacity: 0.3;">Course Name</h2>
    <p id="courseDesc" style="margin-left: 25%;padding:30px">Course Description</p>
    <div style="display: flex; width: 100%;">
      
      <video id="courseVideo" style="width: 50%;" controls controlsList="nodownload" oncontextmenu="return false;">
        <source id="videoSrc" src="" type="video/mp4" />
        Your browser does not support the video tag.
      </video>      
      <button id="startTestBtn">Start Test <a href="#textBtn" class="fa-solid fa-angles-down"></a></button>

    </div>
  </div>
  <!-- defin part -->
   <div style="width:250px;background-color:#E5E4E2;padding:50px;border-radius:20px;box-shadow: -1px 20px 39px 1px rgba(0,0,0,0.66);
          -webkit-box-shadow: -1px 20px 39px 1px rgba(0,0,0,0.66);
          -moz-box-shadow: -1px 20px 39px 1px rgba(0,0,0,0.66);">
      <div style="font-size:18px" ><b>Defination :</b><p id="defin"></p><a href="student_index.php"><button class="btn btn-success">More Courses <i class="fa-solid fa-arrow-right"></i></button></a></div>
    </div>

    <!-- qution part -->
    <div style="width:100%">
     <div id="textBtn" class="hidden">
      <h3>Questions Sol</h3>
      <p>And Achieve Your Certificate</p>
      <form id="quizForm"></form>
         <button type="button" class="btn btn-success" style="width: 150px;height:35px; margin:auto;border-radius: 10px;"
                onclick="checkAnswers()"><a href="#certificateBtn" style="font-size:19px;margin:auto;color:black;">Submit</a></button>
      <div id="quizResult"></div>
    </div>
    <button id="certificateBtn" class="hidden" type="button" 
        style="margin-top:20px; background:green; color:white; padding:10px; border-radius:8px; display:none;">
        <a id="payLink" style="color:white; text-decoration:none;">Download Certificate</a>
    </button>
    </div>
    
  </div>
  </section>
  <!-- End vedio section  -->

  

  <!-- Footer -->
  <footer class="custom-footer">
    <div class="footer-container">
      <div class="footer-brand">
        <div class="logo">Smart<span>Campus</span><strong>360</strong></div>
        <p>Empowering future developers with modern web technologies.</p>
      </div>
      <div class="footer-links">
        <h4>Quick Links</h4>
        <ul>
          <li><a href="student_index.php">Home</a></li>
          <li><a href="contact.php">Contact</a></li>
          <li><a href="chatbot.php"> <i class="bi bi-search">AI Search</i></a></li>
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

  <script>
    const params = new URLSearchParams(window.location.search);
    const lang = params.get('lang') || 'c';

    const courseName = lang.toUpperCase() + " Course";
    document.getElementById('courseTitle').innerText = courseName;
    document.getElementById('courseDesc').innerText = `Welcome to the ${lang} programming course. Let's begin!`;
    
    // defin part 
    if(lang == "c"){
    document.getElementById('defin').innerText = `C is a general-purpose, structured, procedural, and high-level programming language developed by Dennis Ritchie in 1972, mainly used for system and application software.`;
    }else if(lang == "html"){
    document.getElementById('defin').innerText = "HTML is the standard markup language used to create and structure web pages using tags and elements.";
    }else if(lang == "css"){
    document.getElementById('defin').innerText = "CSS is a style sheet language used to design and format HTML elements, such as layout, colors, and fonts, on web pages.";
    }else if(lang == "javascript"){
    document.getElementById('defin').innerText = "JavaScript is a lightweight, interpreted programming language that adds interactivity, behavior, and dynamic content to web pages.";
    }else if(lang == "react"){
    document.getElementById('defin').innerText = "React is a JavaScript library developed by Facebook for building fast, dynamic, and component-based user interfaces for web applications.";
    }else if(lang == "java"){
    document.getElementById('defin').innerText = "Java is a class-based, object-oriented programming language that is platform-independent and widely used for enterprise applications, mobile apps, and web applications.";
    }else if(lang == "python"){
    document.getElementById('defin').innerText = "Python is a high-level, interpreted, general-purpose programming language known for its simplicity, readability, and wide range of applications in web, AI, data science, and automation.";
    }else if(lang == "sql"){
    document.getElementById('defin').innerText = "SQL is a standard language used to store, manage, and retrieve data from relational databases.";
    }else if(lang == "Full Stack Development"){
    document.getElementById('defin').innerText = " This course is designed to provide in-depth knowledge of both Frontend & Backend technologies. Learn HTML, CSS, JavaScript,React, Node.js, Express, and Database management with hands-on projects.";
    }else if(lang == "cybersecurity"){
    document.getElementById('defin').innerText = "Learn how to protect systems, networks, and data from cyber threats. Master fundamentals to advanced topics with hands-on labs and real-world case studies.";
    }

    const video = document.getElementById('courseVideo');
    const videoSrc = document.getElementById('videoSrc');
    const startTestBtn = document.getElementById('startTestBtn');
    const testSection = document.getElementById('textBtn');
    const certificateBtn = document.getElementById('certificateBtn');
        
    videoSrc.src = `vedio/${lang}.mp4`;
    video.load();
    // ✅ Show start test button when video ends
    video.addEventListener('ended', () => {
      startTestBtn.style.display = 'inline-block';
    });
   
    // ✅ Show quiz on start test button click
    startTestBtn.addEventListener('click', () => {
      testSection.classList.remove('hidden');
      // certificateBtn.style.display = 'inline-block';
      // startTestBtn.style.display = 'none';
      loadQuiz(lang);
    });

    // Dummy quiz data
    const quizData = {
      c: [
        { question: "What symbol ends a statement in C?", options: [";", ".", "#", ","], answer: ";" },
        { question: "Which function prints output in C?", options: ["printf", "scanf", "print", "cout"], answer: "printf" },
        { question: "Which keyword is used for looping?", options: ["for", "fun", "loop", "iter"], answer: "for" },
        { question: "What is the file extension for C source files?", options: [".c", ".cpp", ".h", ".java"], answer: ".c" },
        { question: "Pointer arithmetic is valid in C?", options: ["Yes", "No"], answer: "Yes" },
        { question: "Which storage class makes variables retain value between calls?", options: ["static", "auto", "register", "extern"], answer: "static" },
        { question: "What does malloc return on failure?", options: ["NULL", "0", "-1", "Error"], answer: "NULL" },
        { question: "Which operator is used for bitwise AND?", options: ["&", "|", "^", "~"], answer: "&" },
        { question: "How do you declare an array of 10 ints?", options: ["int a[10];", "int a;", "array a[10];", "int[10] a;"], answer: "int a[10];" },
        { question: "Which loop executes at least once?", options: ["do-while", "for", "while", "if"], answer: "do-while" },
        { question: "Which directive includes another file?", options: ["#include", "#define", "#ifdef", "#ifndef"], answer: "#include" },
        { question: "Which operator is used for conditional?", options: ["?:", "&&", "||", "!"], answer: "?:" },
        { question: "What keyword is used to free malloced memory?", options: ["free", "delete", "clear", "remove"], answer: "free" },
        { question: "Which function reads formatted input?", options: ["scanf", "gets", "read", "cin"], answer: "scanf" }
      ],

      html: [
        { question: "What does HTML stand for?", options: ["Hyper Text Markup Language", "Home Tool Markup Language", "Hyperlinks and Text Markup Language", "HighText Machine Language"], answer: "Hyper Text Markup Language" },
        { question: "Which input type is used for email?", options: ["email", "text", "mail", "e-input"], answer: "email" },
        { question: "Which attribute specifies an image source?", options: ["src", "href", "link", "file"], answer: "src" },
        { question: "What does <em> tag do?", options: ["Italic text", "Bold text", "Underline text", "Break line"], answer: "Italic text" },
      ],

      css: [
        { question: "What does CSS stand for?", options: ["Cascading Style Sheets", "Computer Style Sheets", "Creative Style System", "Colorful Style Sheets"], answer: "Cascading Style Sheets" },
        { question: "Which property is used to change the background color?", options: ["background-color", "color", "bgcolor", "background"], answer: "background-color" },
        { question: "How do you select an element with id 'header'?", options: ["#header", ".header", "header", "*header"], answer: "#header" },
        { question: "Which CSS property controls text size?", options: ["font-size", "text-size", "font-style", "text-style"], answer: "font-size" },
        { question: "How do you make text bold in CSS?", options: ["font-weight: bold;", "text-style: bold;", "font: bold;", "text-weight: bold;"], answer: "font-weight: bold;" },
        { question: "Which property is used to change font?", options: ["font-family", "font-style", "font-weight", "font"], answer: "font-family" },
        { question: "How do you make a list not display bullets?", options: ["list-style-type: none;", "list: none;", "bullets: none;", "list-style: no-bullet;"], answer: "list-style-type: none;" },
        { question: "Which property adds space inside an element?", options: ["padding", "margin", "border", "spacing"], answer: "padding" },
        { question: "Which property adds space outside an element?", options: ["margin", "padding", "border", "spacing"], answer: "margin" },
        { question: "What is the default position value of an element?", options: ["static", "relative", "absolute", "fixed"], answer: "static" },
        { question: "How do you select all <p> elements?", options: ["p", ".p", "#p", "*p"], answer: "p" },
        { question: "Which property changes the text color?", options: ["color", "text-color", "font-color", "background-color"], answer: "color" },
        { question: "Which unit is relative to the font-size of the root element?", options: ["rem", "em", "px", "%"], answer: "rem" },
        { question: "Which property is used to create a flex container?", options: ["display: flex;", "flex: container;", "container: flex;", "flexbox: true;"], answer: "display: flex;" },
      ],

      javascript: [
        { question: "Which keyword declares a variable in JavaScript?", options: ["var", "int", "let", "Both var and let"], answer: "Both var and let" },
        { question: "How do you write a function in JavaScript?", options: ["function myFunc() {}", "func myFunc() {}", "def myFunc() {}", "function:myFunc() {}"], answer: "function myFunc() {}" },
        { question: "What does === mean?", options: ["Equal value and type", "Assignment", "Equal value", "Not equal"], answer: "Equal value and type" },
        { question: "Which method converts JSON to an object?", options: ["JSON.parse()", "JSON.stringify()", "JSON.toObject()", "JSON.convert()"], answer: "JSON.parse()" },
        { question: "How to create an array?", options: ["[]", "()", "{}", "<>"], answer: "[]" },
        { question: "What is the output of typeof null?", options: ["object", "null", "undefined", "boolean"], answer: "object" },
        { question: "Which keyword is used to handle errors?", options: ["try", "catch", "finally", "try-catch"], answer: "try" },
        { question: "Which method adds an element to the end of an array?", options: ["push()", "pop()", "shift()", "unshift()"], answer: "push()" },
        { question: "How do you declare a constant variable?", options: ["const", "var", "let", "constant"], answer: "const" },
        { question: "Which event occurs when a user clicks on an element?", options: ["onclick", "onmouseover", "onchange", "onkeydown"], answer: "onclick" },
        { question: "How do you create a new object?", options: ["{}", "[]", "new Object()", "Both {} and new Object()"], answer: "Both {} and new Object()" },
        { question: "Which method removes the last element of an array?", options: ["pop()", "push()", "shift()", "unshift()"], answer: "pop()" },
        { question: "What keyword creates a class?", options: ["class", "function", "struct", "object"], answer: "class" }
      ],

      react: [
        { question: "What is React?", options: ["JavaScript library", "Programming language", "Database", "Framework"], answer: "JavaScript library" },
        { question: "Which method is used to render elements to the DOM?", options: ["ReactDOM.render()", "render()", "React.render()", "renderDOM()"], answer: "ReactDOM.render()" },
        { question: "What is JSX?", options: ["JavaScript XML", "Java Syntax Extension", "JSON Syntax", "JavaScript Style"], answer: "JavaScript XML" },
        { question: "How do you create a React component?", options: ["function or class", "object", "array", "string"], answer: "function or class" },
        { question: "What hook is used to manage state?", options: ["useState", "useEffect", "useContext", "useReducer"], answer: "useState" },
        { question: "Which hook runs after render?", options: ["useEffect", "useState", "useContext", "useReducer"], answer: "useEffect" },
        { question: "How do you pass data between components?", options: ["props", "state", "context", "redux"], answer: "props" },
        { question: "Which method updates component state?", options: ["setState()", "getState()", "updateState()", "changeState()"], answer: "setState()" },
        { question: "What does React use to optimize rendering?", options: ["Virtual DOM", "Real DOM", "Shadow DOM", "Light DOM"], answer: "Virtual DOM" },
        { question: "How do you create a React app?", options: ["create-react-app", "react-create-app", "npm react", "npm create-app"], answer: "create-react-app" },
        { question: "What is a key used for in lists?", options: ["Identify elements uniquely", "Style elements", "Order elements", "Group elements"], answer: "Identify elements uniquely" },
        { question: "Which lifecycle method is called after component mounts?", options: ["componentDidMount", "componentWillMount", "componentDidUpdate", "componentWillUpdate"], answer: "componentDidMount" },
        { question: "Which hook provides context API?", options: ["useContext", "useReducer", "useState", "useEffect"], answer: "useContext" },
        { question: "How do you stop propagation of an event?", options: ["event.stopPropagation()", "event.preventDefault()", "event.stop()", "event.cancel()"], answer: "event.stopPropagation()" }
      ],

      java: [
        { question: "What is Java?", options: ["Programming language", "Database", "Operating System", "IDE"], answer: "Programming language" },
        { question: "Which method is the entry point of a Java program?", options: ["main", "start", "init", "run"], answer: "main" },
        { question: "Which keyword is used to create a class?", options: ["class", "struct", "object", "module"], answer: "class" },
        { question: "How do you create an object?", options: ["new keyword", "create keyword", "make keyword", "build keyword"], answer: "new keyword" },
        { question: "What does JVM stand for?", options: ["Java Virtual Machine", "Java Variable Method", "Java Visual Machine", "Java Verified Machine"], answer: "Java Virtual Machine" },
        { question: "Which operator is used for equality check?", options: ["==", "=", "!=", "==="], answer: "==" },
        { question: "Which keyword is used for inheritance?", options: ["extends", "implements", "inherits", "uses"], answer: "extends" },
        { question: "Which exception is thrown when dividing by zero?", options: ["ArithmeticException", "NullPointerException", "IOException", "IllegalArgumentException"], answer: "ArithmeticException" },
        { question: "Which keyword makes a method static?", options: ["static", "final", "const", "public"], answer: "static" },
        { question: "Which collection is ordered and allows duplicates?", options: ["List", "Set", "Map", "Queue"], answer: "List" },
        { question: "Which access modifier allows access within package only?", options: ["default", "public", "private", "protected"], answer: "default" },
        { question: "What does 'final' keyword mean?", options: ["constant", "method can't be overridden", "class can't be subclassed", "All of these"], answer: "All of these" },
        { question: "Which keyword is used to handle exceptions?", options: ["try-catch", "throw", "catch", "handle"], answer: "try-catch" },
        { question: "Which method is called to start a thread?", options: ["start()", "run()", "execute()", "init()"], answer: "start()" },
        { question: "Which package contains the Scanner class?", options: ["java.util", "java.io", "java.lang", "java.net"], answer: "java.util" }
      ],

      python: [
        { question: "Which keyword is used to define a function?", options: ["def", "function", "func", "define"], answer: "def" },
        { question: "How do you declare a variable?", options: ["variable_name = value", "var variable_name = value", "declare variable_name = value", "let variable_name = value"], answer: "variable_name = value" },
        { question: "Which operator is used for exponentiation?", options: ["**", "^", "%", "//"], answer: "**" },
        { question: "How do you start a comment?", options: ["#", "//", "/*", "<!--"], answer: "#" },
        { question: "Which method converts a string to an integer?", options: ["int()", "str()", "float()", "toInt()"], answer: "int()" },
        { question: "How do you import a module?", options: ["import module_name", "include module_name", "require module_name", "using module_name"], answer: "import module_name" },
        { question: "Which loop is used to iterate over items?", options: ["for", "while", "do-while", "loop"], answer: "for" },
        { question: "How do you create a list?", options: ["[]", "{}", "()", "<>"], answer: "[]" },
        { question: "What does 'None' represent?", options: ["null value", "empty string", "zero", "false"], answer: "null value" },
        { question: "How do you handle exceptions?", options: ["try-except", "try-catch", "catch-except", "handle-except"], answer: "try-except" },
        { question: "Which keyword defines a class?", options: ["class", "def", "struct", "object"], answer: "class" },
        { question: "How do you write a multi-line string?", options: ['"""string"""', "'''string'''", "Both A and B", "None"], answer: "Both A and B" },
        { question: "Which built-in function returns the length of an object?", options: ["len()", "length()", "size()", "count()"], answer: "len()" },
        { question: "What does the 'self' keyword represent?", options: ["instance of the class", "class itself", "global object", "function parameter"], answer: "instance of the class" }
      ],

      sql: [
        { question: "What does SQL stand for?", options: ["Structured Query Language", "Simple Query Language", "Structured Question Language", "Stylish Query Language"], answer: "Structured Query Language" },
        { question: "Which command is used to retrieve data?", options: ["SELECT", "GET", "EXTRACT", "PULL"], answer: "SELECT" },
        { question: "How do you select all columns from a table?", options: ["SELECT * FROM table;", "SELECT ALL FROM table;", "SELECT columns FROM table;", "SELECT table.*;"], answer: "SELECT * FROM table;" },
        { question: "Which keyword is used to filter records?", options: ["WHERE", "FILTER", "IF", "HAVING"], answer: "WHERE" },
        { question: "Which command adds new data to a table?", options: ["INSERT INTO", "ADD", "UPDATE", "CREATE"], answer: "INSERT INTO" },
        { question: "How do you delete all records from a table?", options: ["DELETE FROM table;", "DROP TABLE table;", "REMOVE FROM table;", "CLEAR table;"], answer: "DELETE FROM table;" },
        { question: "Which command changes data in a table?", options: ["UPDATE", "MODIFY", "CHANGE", "SET"], answer: "UPDATE" },
        { question: "Which clause is used to sort the result?", options: ["ORDER BY", "SORT BY", "GROUP BY", "ARRANGE BY"], answer: "ORDER BY" },
        { question: "Which keyword groups rows sharing a property?", options: ["GROUP BY", "ORDER BY", "HAVING", "PARTITION BY"], answer: "GROUP BY" },
        { question: "Which operator is used for pattern matching?", options: ["LIKE", "MATCH", "PATTERN", "SEARCH"], answer: "LIKE" },
        { question: "What does JOIN do?", options: ["Combines rows from two tables", "Deletes rows", "Updates rows", "Creates tables"], answer: "Combines rows from two tables" },
        { question: "Which SQL statement creates a new table?", options: ["CREATE TABLE", "NEW TABLE", "MAKE TABLE", "BUILD TABLE"], answer: "CREATE TABLE" },
        { question: "Which clause is used to filter groups?", options: ["HAVING", "WHERE", "FILTER", "GROUP BY"], answer: "HAVING" },
        { question: "How do you rename a column in a query?", options: ["AS", "RENAME", "ALIAS", "CHANGE"], answer: "AS" },
        { question: "What keyword deletes a table?", options: ["DROP TABLE", "DELETE TABLE", "REMOVE TABLE", "CLEAR TABLE"], answer: "DROP TABLE" }
      ]
    };


    // ✅ Dynamically load quiz based on language
    function loadQuiz(language) {
      const quizForm = document.getElementById('quizForm');
      quizForm.innerHTML = ''; // Clear any existing questions

      const data = quizData[language];

      if (!data || data.length === 0) {
        quizForm.innerHTML = "<p>No quiz available for this course.</p>";
        return;
      }

      data.forEach((q, index) => {
        const questionBlock = document.createElement('div');
        questionBlock.innerHTML = `<p><strong>Q${index + 1}:</strong> ${q.question}</p>`;

        q.options.forEach(opt => {
          const inputId = `q${index}_${opt}`;
          questionBlock.innerHTML += `
            <label for="${inputId}">
              <input type="radio" id="${inputId}" name="q${index}" value="${opt}"> ${opt}
            </label><br>`;
        });

        quizForm.appendChild(questionBlock);
      });
    }

    // ✅ Check user answers
    function checkAnswers() {
      const questions = quizData[lang];
      let score = 0;

      questions.forEach((q, i) => {
        const selected = document.querySelector(`input[name="q${i}"]:checked`);
        if (selected && selected.value === q.answer) {
          score++;
        }
      });

      const percentage = Math.round((score / questions.length) * 100);
      const resultBox = document.getElementById('quizResult');
         resultBox.innerHTML = `
         <p><strong>Your Score: ${score} / ${questions.length}</strong></p>
            <p><strong>Percentage: ${percentage}%</strong></p> `;
            
            document.getElementById('payLink').href = "payment.php?course_name=" + encodeURIComponent(lang) + "&percentage=" + encodeURIComponent(percentage);


      // Agar score 6 ya usse zyada ho, toh certificate button dikhayein
      if (score >= 2) {
        document.getElementById('certificateBtn').style.display = 'inline-block';
      } else {
        document.getElementById('certificateBtn').style.display = 'none';
      }
    }



let savedTime = 0;

// ====== Get saved time from DB ======
fetch(`video_get_progress.php?course=${encodeURIComponent(lang)}`)
  .then(res => res.text())
  .then(time => {
    savedTime = parseFloat(time) || 0;
    console.log("⏱ Saved time from DB:", savedTime);
  })
  .catch(console.error);

// ====== Apply saved time after metadata loaded ======
video.addEventListener("loadedmetadata", () => {
  if (savedTime > 0 && savedTime < video.duration) {
    video.currentTime = savedTime;
    console.log(`🎬 Resumed at ${savedTime} seconds`);
  }
});

// ====== Prevent skipping beyond saved time ======
video.addEventListener("seeking", () => {
  // जर user ने पुढे जायचा प्रयत्न केला तर परत आण
  if (video.currentTime > savedTime + 5) {
    video.currentTime = savedTime;
    alert("⚠️ You can’t skip ahead! Please continue watching in order.");
  }
});

// ====== Save time every 5 seconds ======
setInterval(() => {
  if (!video.paused && !video.ended) {
    const current = video.currentTime;

    // जर नवीन time जुना time पेक्षा मोठा असेल तेव्हाच update करा
    if (current > savedTime) {
      fetch("video_save_progress.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `course=${encodeURIComponent(lang)}&time=${encodeURIComponent(current)}`
      })
        .then(res => res.text())
        .then(response => {
          console.log("💾 Progress saved:", response);
          savedTime = current; // local variable update करा
        })
        .catch(console.error);
    }
  }
}, 5000);

  </script>

</body>

</html>