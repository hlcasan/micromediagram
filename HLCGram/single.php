<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>MicroMediaGram</title>
<style>
img {max-width:100%;}
#showcase {width: 60%; margin:auto; border-radius:1em; overflow:hidden;background:#eee;}
#showcase p {padding-left: 1em;}
.commentBox {border-top: solid 1px white;}
.commentUser {color: green; font-weight: bold; display:inline-block; margin-right: 1em;}
</style>
</head>
<body>
<script>var localUserID = window.sessionStorage.getItem("userID");</script>
<div id="wrapper">
    <h1>MicroMediaGram v1.0</h1>
    <p>You must customize this page and the others for your needs.</p>

    <section>
    <?php if($_GET['user']): ?> 
    		<!-- THIS WILL NEED TO BE TESTED AT CLIENT INSTEAD OF SERVER
    				 BUT IT MEANS THE ALTERNATIVE CODE WILL SHOW IN BROWSER EVERY TIME -->
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

<div id="showcase">
</div>

<!--Add a comment form-->
<?php if($_GET['user']): ?>
<div id="addComment">
		<form name="comment" action="addComment.php" method="get">
		<input type="hidden" name="img" value="<?php echo $_GET['img']; ?>">
		<input type="hidden" name="user" value="<?php echo $_GET['user']; ?>">
		<textarea name="content"></textarea>
		<input type="submit">
		</form>
</div>
<?php endif; ?>


<?php 
// GET THE IMAGE and COMMENTS FROM DB
//Establish connection: host, user, password, database
$dbi = mysqli_connect("localhost","PIApp","","CommIT2018");
//Test connection
if ($dbi) {
		//Run queries
		$rImg = mysqli_query($dbi,"SELECT * FROM HLC_MMGramIMAGES WHERE id = " . $_GET['img']);
		$rCom = mysqli_query($dbi,"SELECT * FROM HLC_MMGramCOMMENTS WHERE image = " . $_GET['img'] . " ORDER BY id DESC");

		//Results arrays to translate to json
		$rImgArray = array();
		$rComArray = array();
		
		//Collect IMAGES
		while ($r = mysqli_fetch_assoc($rImg) ) {
			// We need to translate the user id to a username before storing in the array
			$r['username'] = get_username($r['user']); //User who posted the image
			//From DB to Array
			$rImgArray[] = $r;
		}
		//Collect COMMENTS
		while ($r = mysqli_fetch_assoc($rCom) ) {
			// We need to translate the user id to a username before storing in the array
			$r['username'] = get_username($r['user']); //User who posted the comment
			//From DB to Array
			$rComArray[] = $r;
		}
	
	//Arrays containing the images and comments encoded as json to be used in JS
	$images = json_encode($rImgArray);
	$comments = json_encode($rComArray);
}
//Inform user if error
else {
		echo "Connection Error: " . mysqli_connect_error();
}
//Close connection
mysqli_close($dbi);


//FUNCTIONS
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
// The image and its comments as arrays of json data, translated from the DB
var imgRaw = <?php echo $images ?>;
var comRaw = <?php echo $comments ?>;
</script>
<!--JS HANDLERS FOR JSON DATA-->
<script src="js/singleImgComments.js"></script>

</body>
</html>
