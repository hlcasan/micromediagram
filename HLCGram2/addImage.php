<?php

//Libraries
require_once("lib/db_connect.php");

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	$tbl = "HLC_MMGramIMAGES";//change table name as required
	$userArray = array();
	$srcArray = array();
	$captionArray = array();
	$titleArray = array();
	$insertedRows = 0;
	
	//create arrays for images and captions
	foreach($_REQUEST as $key => $value){
	  if(preg_match("/^user/", $key)){
	  	$userArray[]= $value;
	  }else if(preg_match("/^url/", $key)){
	  	$srcArray[]= $value;
	  }else if(preg_match("/^caption/", $key)){
	  	$captionArray[]= $value;
	  }else if(preg_match("/^title/", $key)){
	  	$titleArray[]= $value;
	  }
	  
	}

	for($i=0;$i<count($srcArray);$i++){
		//echo($userArray[$i].','.$captionArray[$i].','.$srcArray[$i].','.$titleArray[$i]);
		$query = "INSERT INTO HLC_MMGramIMAGES (user, url, caption, title) VALUES (?,?,?,?)";

		//prepare statement, execute, store_result
		if($insertStmt = $dbi->prepare($query)){
			//update bind parameter types & variables as required
			//s=string, i=integer, d=double, b=blob
			$insertStmt->bind_param("isss", $userArray[$i], $srcArray[$i], $captionArray[$i], $titleArray[$i]);
			$insertStmt->execute();
			//$insertedArray = $insertStmt->insert_id;
			$insertedRows += $insertStmt->affected_rows;
		}
		
	echo($insertedRows);
		$insertStmt->close();
		$dbi->close();
		
	}

// Return to main page
header("Location: index.html");

?>