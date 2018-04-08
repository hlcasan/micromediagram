<?php
	//Establish connection: host, user, password, database
	$dbi = new mysqli("localhost","PIApp","","CommIT2018");

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	$tbl = "HLC_MMGramCOMMENTS";//change table name as required
	$userArray = array();
	$imgArray = array();
	$contentArray = array();
	$insertedRows = 0;
	
	//create arrays for images and captions
	foreach($_REQUEST as $key => $value){
	  if(preg_match("/^user/", $key)){
	  	$userArray[]= $value;
	  }else if(preg_match("/^img/", $key)){
	  	$imgArray[]= $value;
	  }else if(preg_match("/^content/", $key)){
	  	$value = htmlentities($value,ENT_QUOTES);
	  	$contentArray[]= $value;
	  }
	}

	for($i=0;$i<count($imgArray);$i++){
		//echo($userArray[$i].','.$imgArray[$i].','.$contentArray[$i]);
		$query = "INSERT INTO $tbl (user, image, content) VALUES (?,?,?)";

		//prepare statement, execute, store_result
		if($insertStmt = $dbi->prepare($query)){
			//update bind parameter types & variables as required
			//s=string, i=integer, d=double, b=blob
			$insertStmt->bind_param("iis", $userArray[$i], $imgArray[$i], $contentArray[$i]);
			$insertStmt->execute();
			//$insertedArray = $insertStmt->insert_id;
			$insertedRows += $insertStmt->affected_rows;
		}
		
	echo($insertedRows);
		$insertStmt->close();
		$dbi->close();
		
	}

// Return to main page
header("Location: single.php?img=".$_GET['img']."&user=".$_GET['user']);

?>