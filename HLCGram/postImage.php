<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>MicroMediaGram</title>
<style>
#fileupload{
  visibility: hidden;
}
#dropZone{
	width: 5em;
	min-height: 3em;
	border: solid black 1px;
	background: #eee;
}
#previewSection img {
max-width: 10em;
}
</style>
</head>
<body>
<div id="wrapper">
    <h1>MicroMediaGram v1.0</h1>
    <p>You must customize this page and the others for your needs.</p>

    <section>
        <h2>Post an image</h2>

		<form id="uploadForm" action="addImage.php">
			<!-- This is the drag box, it also contains the preview -->
			<p class="" id="dropZone"></p> 
			
			<label>Image Title: <input type="text" name="title"></label>
			<label>Image Caption: <input type="text" name="caption"></label>

			<!-- This is a hidden field used to upload the picture on the server -->
			<input id="fileupload" type="file" name="file" data-url="uploads/" multiple>
			<!-- This hidden field contains the url that will be stored in the DB -->
			<input type="hidden" name="url" id="url">

			<!-- You will need to put your own parameters here to pass the user -->
			<input type="hidden" name="user" value="<?php echo $_GET['user'] ?>">

			<!-- This is the button to add the picture in the Database -->
			<p><button type="submit" class="post_button">Post</button></p>
		</form>

			<p id="previewSection"></p>

    </section>



</div>


<script src="js/drop.js"></script>
</body>
</html>
