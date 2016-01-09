<html>
<head><title>Blog</title></head>
<body>
<?php
	include "includes/dbInfo.php";
	include "includes/articles.php";
	session_start();

	$conn = new mysqli("localhost",DBUSERNAME,DBPASSWORD,DB);
	$articles = new articles($conn); //Initialised object
	$p = $_GET["p"]; //gets variable for page
	if ($p ==""){
		$p = 1;
	}
	$start = ($p-1)*5; //Converts page number into starting point

	for ($i = $start;$i<$articles->getFinish($start,5);$i++){
		echo "<h1>".$articles->getArticle($i, "Title")."</h1>"; //Title of article
		echo "<h3>By: ".$articles->getArticle($i, "Author")."</h3>"; //Author of article
		echo "<p>".$articles->getArticle($i, "Content")."</p>"; //Main content of article
		echo "<P>".$articles->getArticle($i, "Date")."</p>"; //Date article was created
	}


	if ($articles->newVisible($start)){ //Displays buttons depending on whether article methods return true
			echo "<a href='index.php?p=".($p-1) ."'>Previous Page</a>";
		}

		if ($articles->oldVisible($start,5)){
			echo '<a href="index.php?p='.($p+1) .'">Next Page</a>';
		}
?>
</body>
</html>
