<?php

//Libraries
require_once("lib/db_connect.php");

    if ($dbi) {
        // SQL query
        $q = "INSERT INTO HLC_MMGramUSERS (username,password) VALUES (?,?)";

        // Array to translate to json
        $rArray = array();

        if ($stmt = $dbi->prepare($q)) {
            //Prepare input
            $user = $_POST['username'];
            $pass = $_POST['password'];
            $stmt->bind_param("ss",$user,$pass);

            // Execute
            $stmt->execute();

            //Output
            $rArray[] = [
                "id"=>$stmt->insert_id,
                "username"=>$user];

            echo json_encode($rArray);

            $stmt->close();
        }   
    }
    //Inform user if connection error
    else {
        echo "Connection Error: " . mysqli_connect_error();
    }
    //Close connection
    mysqli_close($dbi);
?>