<?php
  // app/serialize_data.php
  require_once  '../_includes/connect.php';

  //turn off error reporting for production
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

//create an array for JSON
  $jsonResponse = ["file"=>"serialize_upload.php"];

//insert into the db
  $tbl = "photos";//change table name as required
  $titleArray = array();
  $srcArray = array();
  $captionArray = array();
  
  //set userID manually for now
  $userID = "1";
  $insertedRows = 0;
  
  //create arrays for images and captions
  foreach($_REQUEST as $key => $value){
    //echo("$key -> $value");
    //$jsonResponse[$key] = $value;
    if(preg_match("/^photoTitle/", $key)){
      $titleArray[] = $value;
    }else if(preg_match("/^photoSRC/", $key)){
      $srcArray[]= $value;
    }else if(preg_match("/^photoCaption/", $key)){
      $captionArray[]= $value;
    }
  }

  $userID = 1;
  //echo count($captionArray);
  for($i=0;$i<count($captionArray);$i++){
    //echo($captionArray[$i].','.$srcArray[$i]);
    $jsonResponse["userID"] = $userID;
    $jsonResponse["photoTitle"] = $titleArray[$i];
    $jsonResponse["photoSRC"] = $srcArray[$i];
    $jsonResponse["photoCaption"] = $captionArray[$i];

    $query = "INSERT INTO $tbl (userID, photoTitle, photoSRC, photoCaption) VALUES (?,?,?,?)";
    //prepare statement, execute, store_result
    if($insertStmt = $mysqli->prepare($query)){
      //update bind parameter types & variables as required
      //s=string, i=integer, d=double, b=blob
      $insertStmt->bind_param("isss", $userID, $titleArray[$i], $srcArray[$i], $captionArray[$i]);
      $insertStmt->execute();
      $insertedID = $insertStmt->insert_id;
      $insertedRows += $insertStmt->affected_rows;
    }
  }
    $jsonResponse["insertedRows"] = $insertedRows;
    //$insertStmt->close();
    $mysqli->close();

  //encode the array in json and echo back to AJAX call
  echo(json_encode($jsonResponse));

?>