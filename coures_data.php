<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Details</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <lnk href="https://fontawesome.com/icons/link?f=classic&s=solid">
</head>
<style>
  .main {
    width: 100%;
    background-color: white;
    color: black;
    padding: 50px;
  }

  .headding {
    font-size: 50px;
    padding: 20px;
    padding-left: 0px;
  }

  .text {
    padding: 2% 0% 2% 10%;
  }

  .btnW {
    width: 100%;
  }
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

  <section class="main ">
    <h2 id="courseTitle" class="headding"></h2>
    <div id="allText"></div>
    <a href="" class="btn btn-success btnW" id="courseSrc">Full Coures Video Start Now</a>

  </section>

</body>
<script>
  const params = new URLSearchParams(window.location.search);
  const lang = params.get('lang') || 'c';

  document.getElementById('courseSrc').href = `coures_detail.php?lang=${lang}`;

  const courseName = lang.toUpperCase() + " Introduction";
  document.getElementById('courseTitle').innerText = courseName;

  // ===== Theory Data =====
  const theoryData = {
    c: `
           <span class="headding">What is C?</span>
           <p>C is a general-purpose programming language created by Dennis Ritchie at the Bell Laboratories in 1972.
               It is a very popular language, despite being old. The main reason for its popularity is because it is a fundamental language in the field of computer science.</p>
            <span class="headding">Why Learn C?</span>
               <ul class="text">
                <li>It is one of the most popular programming languages in the world</li>
                <li>If you know C, you will have no problem learning other popular programming languages such as Java, Python, C++, C#, etc, as the syntax is similar</li>
                <li>If you know C, you will understand how computer memory works</li>
                <li>C is very fast, compared to other programming languages, like Java and Python</li>
                <li>C is very versatile; it can be used in both applications and technologies</li>
            </ul>
        <div style="background:#f4f4f4; padding:15px; border-radius:8px; margin:20px 0;">
                 <h3>Try It Yourself</h3>
               <textarea id="codeEditor" style="width:100%;height:200px;font-family:monospace;">
           #include <stdio.h>
           int main() {
           printf("Hello World!");
          return 0;
        }
               </textarea>
         </div>
         <span class="headding">Statements</span>
         <p>
         A computer program is a list of "instructions" to be "executed" by a computer.
         </p>
         <p>In a programming language, these programming instructions are called statements.</p>
        <span class="headding">C Variables</span>
        <p>Variables are containers for storing data values, like numbers and characters.</p>
        <p>In C, there are different types of variables (defined with different keywords), for example:</p>
        <ul>
            <li>int - stores integers (whole numbers), without decimals, such as 123 or -123</li>
            <li>float - stores floating point numbers, with decimals, such as 19.99 or -19.99</li>
            <li>char - stores single characters, such as 'a' or 'B'. Characters are surrounded by single quotes</li>
        </ul>

         <div class="headding" style="margin-left:30%;margin-top:5%;color:green;>
         <p class="headding" >Full Course Learn In One Video Now<p>
         <img src="image/downArrow.png" style="margin-left:25%;"/>
        </div>
        
         <div class="about-text" style=" border:1px solid black;border-radius:10px; padding:20px;margin:50px">
    <span class="headding" style="color:blue;margin:0% 0% 5% 30%" >  Certified C Course</span>
    <ul type="none" style="margin:5%;">
      <li><strong>📅 Duration:</strong> 10.32 Hours</li>
      <li><strong>💰 Fees:</strong> ₹199</li>
      <li><strong>🏫 Institute:</strong> SmartCampus360</li>
      <li><strong>📜 Certificate:</strong> Complete Full Course And Get Certificate</li>
    </ul>
  </div>

        `,
    html: `
            <span class="headding">What is HTML?</span>
            <ul class="text">
                <li>HTML stands for Hyper Text Markup Language</li>
                <li>HTML is the standard markup language for creating Web pages</li>
                <li>HTML describes the structure of a Web page</li>
                <li>HTML consists of a series of elements</li>
                <li>HTML elements tell the browser how to display the content</li>
                <li>HTML elements label pieces of content such as "this is a heading", "this is a paragraph", "this is a link", etc.</li>
            </ul>
        <div style="background:#f4f4f4; padding:15px; border-radius:8px; margin:20px 0;">
                 <h3>Try It Yourself</h3>
               <textarea id="codeEditor" style="width:100%;height:200px;font-family:monospace;">
           <!DOCTYPE html>
          <html>
          <head>
          <title>Page Title</title>
         </head>
         <body>

         <h1>My First Heading</h1>
         <p>My first paragraph.</p>

         </body>
         </html>
               </textarea>
         </div>
         <span class="headding">What is an HTML Element?</span>
         <p>
         An HTML element is defined by a start tag, some content, and an end tag:
         </p>
         <div class="headding" style="margin-left:30%;margin-top:5%;color:green;>
         <p class="headding" >Full Course Learn In One Video Now<p>
         <img src="image/downArrow.png" style="margin-left:25%;"/>
        </div>
         <div class="about-text" style=" border:1px solid black;border-radius:10px; padding:20px;margin:50px">
    <span class="headding" style="color:blue;margin:0% 0% 5% 30%" >  Certified HTML Course</span>
    <ul type="none" style="margin:5%;">
      <li><strong>📅 Duration:</strong> 2 Hours</li>
      <li><strong>💰 Fees:</strong> ₹199</li>
      <li><strong>🏫 Institute:</strong> SmartCampus360</li>
      <li><strong>📜 Certificate:</strong> Complete Full Course And Get Certificate</li>
    </ul>
  </div>

        `,
    css: `
            <span class="headding">What is CSS?</span>
            <p>CSS is the language we use to style a Web page.</p>
            <ul class="text">
                <li>CSS stands for Cascading Style Sheets</li>
                <li>CSS describes how HTML elements are to be displayed on screen, paper, or in other media</li>
                <li>CSS saves a lot of work. It can control the layout of multiple web pages all at once</li>
                <li>External stylesheets are stored in CSS files</li>
            </ul>
        <div style="background:#f4f4f4; padding:15px; border-radius:8px; margin:20px 0;">
                 <h3>Why Use CSS?</h3>
               <textarea id="codeEditor" style="width:100%;height:200px;font-family:monospace;">
          <!DOCTYPE html>
<html>
<head>
<style>
body {
  background-color: lightblue;
}

h1 {
  color: white;
  text-align: center;
}

p {
  font-family: verdana;
  font-size: 20px;
}
</style>
</head>
<body>

<h1>My First CSS Example</h1>
<p>This is a paragraph.</p>

</body>
</html>
               </textarea>
         </div>
         <span class="headding">CSS Selectors</span>
         <p>
         CSS selectors are used to "find" (or select) the HTML elements you want to style.
         </p>
         <p>We can divide CSS selectors into five categories:</p>
         <ul>
            <li>Simple selectors (select elements based on name, id, class)</li>
            <li>Combinator selectors (select elements based on a specific relationship between them)</li>
            <li>Pseudo-class selectors (select elements based on a certain state)</li>
            <li>Pseudo-elements selectors (select and style a part of an element)</li>
            <li>Attribute selectors (select elements based on an attribute or attribute value)</li>
        </ul>
         <div class="headding" style="margin-left:30%;margin-top:5%;color:green;>
         <p class="headding" >Full Course Learn In One Video Now<p>
         <img src="image/downArrow.png" style="margin-left:25%;"/>
        </div>
         <div class="about-text" style=" border:1px solid black;border-radius:10px; padding:20px;margin:50px">
    <span class="headding" style="color:blue;margin:0% 0% 5% 30%" >  Certified CSS Course</span>
    <ul type="none" style="margin:5%;">
      <li><strong>📅 Duration:</strong> 2 Hours</li>
      <li><strong>💰 Fees:</strong> ₹199</li>
      <li><strong>🏫 Institute:</strong> SmartCampus360</li>
      <li><strong>📜 Certificate:</strong> Complete Full Course And Get Certificate</li>
    </ul>
  </div>
        `,
    javascript: `
             <span class="headding">What is javascript?</span>
            <ul class="text">
                <li>JavaScript is the programming language of the web.</li>
                <li>It can calculate, manipulate and validate data.</li>
                <li>It can update and change both HTML and CSS.</li>
            </ul>
        <div style="background:#f4f4f4; padding:15px; border-radius:8px; margin:20px 0;">
                 <h3>Try It Yourself</h3>
          <textarea id="codeEditor" style="width:100%;height:200px;font-family:monospace;">
          <!DOCTYPE html>
          <!DOCTYPE html>
          <html>
          <body>
          <h2>What Can JavaScript Do?</h2>
          <p id="demo">JavaScript can change HTML content.</p>
          <button type="button" onclick='document.getElementById("demo").innerHTML = "Hello JavaScript!"'>Click Me!</button>
          </body>
          </html>
         </textarea>
         </div>
         <div class="headding" style="margin-left:30%;margin-top:5%;color:green;>
         <p class="headding" >Full Course Learn In One Video Now<p>
         <img src="image/downArrow.png" style="margin-left:25%;"/>
        </div>
         <div class="about-text" style=" border:1px solid black;border-radius:10px; padding:20px;margin:50px">
    <span class="headding" style="color:blue;margin:0% 0% 5% 30%" >  Certified Javascript Course</span>
    <ul type="none" style="margin:5%;">
      <li><strong>📅 Duration:</strong> 2 Hours</li>
      <li><strong>💰 Fees:</strong> ₹199</li>
      <li><strong>🏫 Institute:</strong> SmartCampus360</li>
      <li><strong>📜 Certificate:</strong> Complete Full Course And Get Certificate</li>
    </ul>
  </div>
        `,
    react: `
              <span class="headding">What is React?</span>
            <ul class="text">
                <li>React is a front-end JavaScript library.</li>
                <li>React was developed by the Facebook Software Engineer Jordan Walke.</li>
                <li>React is also known as React.js or ReactJS.</li>
                <li>React is a tool for building UI components.</li>
            </ul>
        
         </div>
         <div class="headding" style="margin-left:30%;margin-top:5%;color:green;>
         <p class="headding" >Full Course Learn In One Video Now<p>
         <img src="image/downArrow.png" style="margin-left:25%;"/>
        </div>
         <div class="about-text" style=" border:1px solid black;border-radius:10px; padding:20px;margin:50px">
    <span class="headding" style="color:blue;margin:0% 0% 5% 30%" >  Certified React Course</span>
    <ul type="none" style="margin:5%;">
      <li><strong>📅 Duration:</strong> 2 Hours</li>
      <li><strong>💰 Fees:</strong> ₹199</li>
      <li><strong>🏫 Institute:</strong> SmartCampus360</li>
      <li><strong>📜 Certificate:</strong> Complete Full Course And Get Certificate</li>
    </ul>
  </div>
        `,
    java: `
             <span class="headding">What is Java?</span>
            <ul class="text">
            <p>Java is a popular and powerful programming language, created in 1995.</p>
            <p>It is owned by Oracle, and more than 3 billion devices run Java.</p>
            <p>It is used for:</p>
                <li>Mobile applications (specially Android apps)</li>
                <li>Desktop applications</li>
                <li>Web applications</li>
                <li>Web servers and application servers</li>
                <li>Games</li>
                <li>Database connection</li>
                <li>And much, much more!</li>
            </ul>
        <div style="background:#f4f4f4; padding:15px; border-radius:8px; margin:20px 0;">
                 <h3>Java Example</h3>
               <textarea id="codeEditor" style="width:100%;height:200px;font-family:monospace;">
           public class Main {
           public static void main(String[] args) {
           String name = "John";
           System.out.println("Hello " + name);
           }
          }

               </textarea>
         </div>
        
         <div class="headding" style="margin-left:30%;margin-top:5%;color:green;>
         <p class="headding" >Full Course Learn In One Video Now<p>
         <img src="image/downArrow.png" style="margin-left:25%;"/>
        </div>
         <div class="about-text" style=" border:1px solid black;border-radius:10px; padding:20px;margin:50px">
    <span class="headding" style="color:blue;margin:0% 0% 5% 30%" >  Certified Java Course</span>
    <ul type="none" style="margin:5%;">
      <li><strong>📅 Duration:</strong> 2 Hours</li>
      <li><strong>💰 Fees:</strong> ₹199</li>
      <li><strong>🏫 Institute:</strong> SmartCampus360</li>
      <li><strong>📜 Certificate:</strong> Complete Full Course And Get Certificate</li>
    </ul>
  </div>

        `,
    python: `
            <span class="headding">What is Python?</span>
            <ul class="text">
            <p>JPython is a popular programming language. It was created by Guido van Rossum, and released in 1991.</p>
            <p>It is used for:</p>
                <li>web development (server-side),</li>
                <li>software development,</li>
                <li>mathematics,</li>
                <li>system scripting.</li>
            </ul>
        <div style="background:#f4f4f4; padding:15px; border-radius:8px; margin:20px 0;">
                 <h3>Java Example</h3>
               <textarea id="codeEditor" style="width:100%;height:200px;font-family:monospace;">
           print("Hello, World!")
               </textarea>
         </div>
        
         <div class="headding" style="margin-left:30%;margin-top:5%;color:green;>
         <p class="headding" >Full Course Learn In One Video Now<p>
         <img src="image/downArrow.png" style="margin-left:25%;"/>
        </div>
         <div class="about-text" style=" border:1px solid black;border-radius:10px; padding:20px;margin:50px">
    <span class="headding" style="color:blue;margin:0% 0% 5% 30%" >  Certified Python Course</span>
    <ul type="none" style="margin:5%;">
      <li><strong>📅 Duration:</strong> 2 Hours</li>
      <li><strong>💰 Fees:</strong> ₹199</li>
      <li><strong>🏫 Institute:</strong> SmartCampus360</li>
      <li><strong>📜 Certificate:</strong> Complete Full Course And Get Certificate</li>
    </ul>
  </div>

        `,
    sql: `
              <span class="headding">What is MySQL?</span>
            <ul class="text">
                <li>MySQL is a relational database management system</li>
                <li>MySQL is open-source</li>
                <li>MySQL is free</li>
                <li>MySQL is ideal for both small and large applications</li>
                <li>MySQL is very fast, reliable, scalable, and easy to use</li>
                <li>MySQL is cross-platform</li>
                <li>MySQL is compliant with the ANSI SQL standard</li>
                <li>MySQL was first released in 1995</li>
                <li>MySQL is developed, distributed, and supported by Oracle Corporation</li>
                <li>MySQL is named after co-founder Ulf Michael "Monty" Widenius's daughter: My</li>
            </ul>
            <span class="headding">Who Uses MySQL?</span>
            <ul>
                <li>Huge websites like Facebook, Twitter, Airbnb, Booking.com, Uber, GitHub, YouTube, etc.</li>
                <li>Content Management Systems like WordPress, Drupal, Joomla!, Contao, etc.</li>
                <li>A very large number of web developers around the world</li>
            </ul>
        
         <div class="headding" style="margin-left:30%;margin-top:5%;color:green;>
         <p class="headding" >Full Course Learn In One Video Now<p>
         <img src="image/downArrow.png" style="margin-left:25%;"/>
        </div>
         <div class="about-text" style=" border:1px solid black;border-radius:10px; padding:20px;margin:50px">
    <span class="headding" style="color:blue;margin:0% 0% 5% 30%" >  Certified MySQL Course</span>
    <ul type="none" style="margin:5%;">
      <li><strong>📅 Duration:</strong> 2 Hours</li>
      <li><strong>💰 Fees:</strong> ₹199</li>
      <li><strong>🏫 Institute:</strong> SmartCampus360</li>
      <li><strong>📜 Certificate:</strong> Complete Full Course And Get Certificate</li>
    </ul>
  </div>
        `,
  };

  // ===== Show Theory =====
  const container = document.getElementById("allText");
  if (theoryData[lang]) {
    container.innerHTML = theoryData[lang];
  } else {
    container.innerHTML = "<p>No data available for this course.</p>";
  }

</script>

</html>