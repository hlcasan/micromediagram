<?php 

//Libraries
require_once("lib/db_connect.php");
require_once("lib/get_username.php");

// GET THE IMAGE FROM DB
//Test connection
if ($dbi) {
	// SQL query
	$q = "SELECT id,title,caption,url,user,timestamp FROM HLC_MMGramIMAGES WHERE id = ?";

	// Array to translate to json
	$rArray = array();

	if ($stmt = $dbi->prepare($q)) {
		//Prepare input
		$img = $_POST['i'];
		$stmt->bind_param("i",$img);

		//Prepare output
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($rId,$rTitle,$rCaption,$rUrl,$rUser,$rTime);

		//Collect results
		while($stmt->fetch()) {
			$rArray[] = [
                "id"=>$rId,
                "title"=>$rTitle,
                "caption"=>$rCaption,
                "url"=>$rUrl,
				"user"=>$rUser,
				"timestamp"=>$rTime,
                "username"=>get_username($rUser)];
		}
		
		//Encode JSON
		echo json_encode($rArray);
		
		$stmt->close();        
	}
}
//Inform user if error
else {
		echo "Connection Error: " . mysqli_connect_error();
}
//Close connection
mysqli_close($dbi);

?>