<?php 
// THIS IS A GALLERY

//Libraries
require_once("lib/db_connect.php");
require_once("lib/get_username.php");

// GET THE IMAGES FROM DB
if ($dbi) {
    // SQL query
    $q = "SELECT id,title,caption,url,user FROM HLC_MMGramIMAGES ORDER BY id DESC";

    // Array to translate to json
    $rArray = array();

    if ($stmt = $dbi->prepare($q)) {
        //Prepare output
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($rId,$rTitle,$rCaption,$rUrl,$rUser);

        //Collect results
        while($stmt->fetch()) {
            $rArray[] = [
                "id"=>$rId,
                "title"=>$rTitle,
                "caption"=>$rCaption,
                "url"=>$rUrl,
                "user"=>$rUser,
                "username"=>get_username($rUser)];
        }
        
        //Encode JSON
        echo json_encode($rArray);
        
        $stmt->close();        
    }
    else {
        echo "no execute statement";
    }
}
//Inform user if error
else {
        echo "Connection Error: " . mysqli_connect_error();
}
//Close connection
mysqli_close($dbi);
    
?>