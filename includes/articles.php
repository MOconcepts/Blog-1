<?php
	class articles {
		private $all; //Used to store all articles
		private $aConn; //Used for database connection for queries
		
		//Constructor to store connection as field, then gets articles
		function __construct($conn){ 
			$this->aConn = $conn;
			$this->getArticlesFromDb();
		}

		//Runs a query to get all articles in table and puts results into field object
		public function getArticlesFromDb(){
			$query = "SELECT * FROM Posts ORDER BY `ID` DESC";
			$this->all = $this->aConn->query($query);
		}
		
		//Will go to a specific point in article list (starts from 0) and will return a field in that record
		public function getArticle($id,$component){
			$this->all->data_seek($id);
			$row = $this->all->fetch_assoc();
			return $row[$component]; 
		}
		
		//Returns total number of articles
		public function getTotal(){
			return $this->all->num_rows;
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
		public function newVisible($start){
			if ($start <= 0){
				return false;
			} else {
				return true;
			}
		}
		
		//Checks to see whether a page with older articles is present
		public function oldVisible($start,$count){				
			if ($start+$count>$this->getTotal()-1){ //is -1 here as $start begins at 0 whereas the total will be starting from 1
				return false;
			} else {
				return true;
			}
		}
		}
?>