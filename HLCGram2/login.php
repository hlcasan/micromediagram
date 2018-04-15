<?php

//Libraries
require_once("lib/db_connect.php");

    if ($dbi) {
        // SQL query
        $q = "SELECT id, username FROM HLC_MMGramUSERS WHERE username = ? AND password = ?";

        // Array to translate to json
        $rArray = array();

        if ($stmt = $dbi->prepare($q)) {
            //Prepare input
            $user = $_POST['username'];
            $pass = $_POST['password'];
            $stmt->bind_param("ss",$user,$pass);

            //Prepare output
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($rId,$rUsername);

            //Collect results
            while($r = $stmt->fetch()) {
                $rArray[] = [
                    "id"=>$rId,
                    "username"=>$rUsername];
            }
            
            //Encode JSON
            echo json_encode($rArray);
            
            $stmt->close();
        }
        else {
            echo "no execute statement";
        }

    }
    else {
        echo "Connection Error: " . mysqli_connect_error();
    }
    mysqli_close($dbi);

?>
