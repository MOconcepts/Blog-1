<html>
<head>
<?php
  include "includes/dbInfo.php";
  include "includes/articles.php";
  session_start();
  $conn = new mysqli("localhost",DBUSERNAME,DBPASSWORD,DB); //Esatblish database connection
  $articles = new articles($conn);
  $id = $_GET["id"];

  if ($id == ""){ //Redirect if no ID specified
    header("Location:index.php");
  }

  $article = $articles->getArticleById($id); //Gets article record
  if ($article == null){ //Redirect if article does not exist
    header("Location:index.php");
  }
?>
</head>

<body>
<?php
  echo "<h1>".$article["Title"]."</h1>"; //Title of article
  echo "<h3>By: ".$article["Author"]."</h3>"; //Author of article
  echo "<p>".$article["Content"]."</p>"; //Main content of article
  echo "<P>".$article["Date"]."</p>"; //Date article was created
 ?>

 <a href="" onclick="history.go(-1)">Go Back</a>
</body>
</html>
