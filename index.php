<html>
<head><title>Blog</title></head>
<body>
<?php
	include "includes/dbInfo.php";
	include "includes/articles.php";
	session_start();

	$conn = new mysqli("localhost",DBUSERNAME,DBPASSWORD,DB); //Esatblish database connection
	$articles = new articles($conn); //Initialised object

	$p = $_GET["p"]; //gets variable for page
	if ($p ==""){
		$p = 1; //If no page specified assume default value 1
	}
	$articlesToShow = $articles->getArticlesFromDb($p); //Retrieves articles for page number
	for ($i = 0;$i<$articlesToShow->num_rows;$i++){ //Runs through the 5 articles
		$articlesToShow->data_seek($i);
		$article = $articlesToShow->fetch_assoc(); //Fetches relavent article
		echo "<h1><a href='post.php?id=".$article["ID"]."'>".$article["Title"]."</a></h1>"; //Title of article
		echo "<h3>By: ".$article["Author"]."</h3>"; //Author of article
		echo "<p>".$article["Content"]."</p>"; //Main content of article
		echo "<P>".$article["Date"]."</p>"; //Date article was created
	}
	if ($articles->newVisible()){ //Displays buttons depending on whether article methods return true
			echo "<a href='index.php?p=".($p-1) ."'>Previous Page</a>";
		}

		if ($articles->oldVisible()){
			echo '<a href="index.php?p='.($p+1) .'">Next Page</a>';
		}

?>
</body>
</html>
