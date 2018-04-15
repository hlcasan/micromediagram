/* Handler to add a comment to a picture
	Calls addComment.php to dump comment in DB
	Refreshes the UI of comment section in single.html
*/

var commentForm = document.getElementById("commentF");

commentForm.addEventListener('submit', function(event) {
	event.preventDefault();

	var php = "addComment.php";

	var xhr = new XMLHttpRequest();
    var formData = new FormData(commentForm);
    formData.append("u",window.localStorage.getItem("userid")); //set the user id from localstorage
    formData.append("i",qStr.i); //set the image id from query string

    xhr.open("POST", php, true);
    xhr.onreadystatechange = function() {
        //console.log('readyState: ' + xhr.readyState);
        //console.log('status: ' + xhr.status);
        if (xhr.readyState == 4 && xhr.status == 200) {
			// Everything ok, get the response
			console.log(xhr.responseText);

            // Call a refresh of the comments list
            singleCom(); 
        }
	};
	xhr.send(formData);
});

