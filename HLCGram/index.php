<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>MicroMediaGram</title>
<style>
img {max-width:10em;}
#gallery {display: flex; flex-wrap:wrap; justify-content:space-between;}
#gallery div {border:solid red 1px;margin:0.5em; padding:1em;}
</style>
</head>
<body>
<!-- CHECK FOR LOCAL STORAGE USER ID -->
<script>var localUserID = window.sessionStorage.getItem("userID");</script>

<div id="wrapper">
    <h1>MicroMediaGram v1.0</h1>
    <p>You must customize this page and the others for your needs.</p>


		<!-- THIS SHOULD BE TESTED AT CLIENT INSTEAD OF SERVER
				 BUT IT MEANS THE ALTERNATIVE CODE WILL SHOW IN BROWSER EVERY TIME -->
    <section>
    <?php if($_GET['user']): ?> 
    		<h2>Welcome back <?php echo get_username($_GET['user']); ?>!</h2>
    		
    		<a href="postImage.php?user=<?php echo $_GET['user']; ?>">Post image</a>
    		
    		<script>
    		//if (!localUserID) {
    			window.sessionStorage.setItem("userID",<?php echo $_GET['user']; ?>);
    			localUserID = window.sessionStorage.getItem("userID");
    		//}
    		</script>
    		
    <?php else: ?>
        <h2>Log in</h2>

        <form name="login" action="login.php" method="post">
        <label>Username <input type="text" name="username"></label>
        <label>Password <input type="password" name="password"></label>
        <input type="submit">
        </form>
    </section>

    <section>
        <h2>Sign in</h2>

        <form name="signin" action="signin.php" method="post">
        <label>Username <input type="text" name="username"></label>
        <label>Password <input type="password" name="password"></label>
        <input type="submit">
        </form>
 		<?php endif; ?>
   </section>
</div>

<div id="gallery">

</div>


<?php 
// THIS IS A GALLERY
// GET THE IMAGES FROM DB
//Establish connection: host, user, password, database
	$dbi = mysqli_connect("localhost","PIApp","","CommIT2018");
	//Test connection
	if ($dbi) {
			//Run query
			$results = mysqli_query($dbi,"SELECT * FROM HLC_MMGramIMAGES ORDER BY id DESC");
			
			// Array to translate to json
			$rArray = array();
			
			//Collect results
			while ($r = mysqli_fetch_assoc($results) ) {
				// We need to translate the user id to a username before storing in the array
				$r['username'] = get_username($r['user']);
				//From DB to Array
				$rArray[] = $r;
			}
		
		//Array containing the images encoded as json to be used in JS
		$images = json_encode($rArray);
}
	//Inform user if error
	else {
			echo "Connection Error: " . mysqli_connect_error();
	}
	//Close connection
	mysqli_close($dbi);



// A simple function to get the username from an id. We use this a lot above.
function get_username($id) {
    $dbi = mysqli_connect("localhost","PIApp","","CommIT2018");
    if ($dbi) {
        $results = mysqli_query($dbi,"SELECT username FROM HLC_MMGramUSERS WHERE id = " . $id);
        while ($r = mysqli_fetch_assoc($results) ) {
            return $r['username'];
        }
    }
    mysqli_close($dbi);
}
?>

<!--GLOBAL JSON VARS-->
<script>
// All the images as an array of json data, translated from the DB
var imgRaw = <?php echo $images ?>;
</script>
<!--JS HANDLERS FOR JSON DATA-->
<script src="js/gallery.js"></script>

</body>
</html>
