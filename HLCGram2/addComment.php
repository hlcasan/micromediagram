<?php

//Libraries
require_once("lib/db_connect.php");

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	$tbl = "HLC_MMGramCOMMENTS";//change table name as required
	$userArray = array();
	$imgArray = array();
	$contentArray = array();
	$insertedRows = 0;
	
	//create arrays for comments
	$user = $_POST['u'];
	$img = $_POST['i'];
	$content = htmlentities($_POST['content'],ENT_QUOTES);

	$query = "INSERT INTO $tbl (user, image, content) VALUES (?,?,?)";

	//prepare statement, execute, store_result
	if($insertStmt = $dbi->prepare($query)){
		//update bind parameter types & variables as required
		//s=string, i=integer, d=double, b=blob
		$insertStmt->bind_param("iis", $user, $img, $content);
		$insertStmt->execute();
		//$insertedArray = $insertStmt->insert_id;
		$insertedRows += $insertStmt->affected_rows;
	}
	else {
		echo "Error";
	}
	
	echo($insertedRows);
	$insertStmt->close();
	$dbi->close();

// Return to main page
echo "OK: comment added";

?>