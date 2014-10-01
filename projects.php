<!DOCTYPE html>
<html>
    <head>
        <title>Paal Wik - About</title>
        <link rel="stylesheet" type="text/css" href="/css/layout.css">
        <link rel="stylesheet" type="text/css" href="/css/prism.css">
        <script src="/script/prism.js" type="text/javascript"></script>
        <meta name="keywords" contents="Paal Wik, Projects, Arduino, HTML, CSS, JavaScript, Python, Resume">
        <meta name="description" content="Paal Wik's place to share projects and interests.">
        <meta name="author" content="Paal Wik">
    </head>
    <body>
        <div class="header">
        <div class="nav-bar">
          <ul>
            <li><a href="home.html">Home</a></li>
            <li><a href="projects.php">Projects</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="contact.html">Contact</a></li>
          </ul>
        </div>
        </div>
      <div class="main-page">
<h1>PROJECTS</h1>

<?php
include 'database.php';
error_reporting(E_ALL);

if (!empty($_POST)) {
  $db = new dbManager();
  $db->post_comment();
}

$db = new dbManager();
$db->print_projects();

?>

</div>
    <div class="footer">Copyright &#169; Paal Roland Wik 2014 | Powered by HTML CSS PHP</div>
</body>
</html>