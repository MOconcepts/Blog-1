<?php
	class articles {
		private $aConn; //Used for database connection for queries
		private $start; //Stores starting article number
		private $finish; //Stores finishing article number

		//Constructor to store connection as field, then gets articles
		function __construct($conn){
			$this->aConn = $conn;
		}

		//Runs a query to get all articles in table and puts results into field object
		public function getArticlesFromDb($page){
			$this->start = (($page-1)*5); //Calculates start and finish values based on page number
			$this->finish = $this->getFinish($start,5);
			$query = "SELECT * FROM Posts ORDER BY `ID` DESC LIMIT $this->start,5"; //Limits results to 5 based on start number
			return $this->aConn->query($query); //Returns all articles
		}

		public function getArticleById($id){
			$query = "SELECT * FROM Posts WHERE `ID` = $id"; //Runs query to select by ID
			$result =$this->aConn->query($query);
			if ($result->num_rows == 0){ //Returns null if no result
				return null;
			} else {
				return $result->fetch_assoc(); //otherwise returns record
			}
		}

		//Returns total number of articles
		public function getTotal(){
			$result = $this->aConn->query("SELECT COUNT(*) AS total FROM Posts"); //Runs SQL Count Function
			$total = $result->fetch_assoc();
			return $total['total']; //Returns total number of articles
		}

		//Calculates a number for when printing articles by ensuring it does not exceed total number
		public function getFinish($start,$count){
			if ($start+$count>$this->getTotal()){
				return $this->getTotal();
			} else {
				return $start +$count;
			}
		}

		//Checks to see whether a page with newer articles is present
		public function newVisible(){
			if ($this->start <= 0){
				return false;
			} else {
				return true;
			}
		}

		//Checks to see whether a page with older articles is present
		public function oldVisible(){
			if ($this->start+5>$this->getTotal()-1){ //is -1 here as $start begins at 0 whereas the total will be starting from 1
				return false;
			} else {
				return true;
			}
		}
		}
?>
