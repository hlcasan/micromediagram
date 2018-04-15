/* Handler for the user log in
	Collects creds and calls login.php to validate creds
	Sets the localStorage values for user
*/

var loginForm = document.getElementById("loginF");

loginForm.addEventListener('submit', function(event) {
	event.preventDefault();

	var php = "login.php";

	var xhr = new XMLHttpRequest();
	var formData = new FormData(loginForm);
	var userRaw = new Array();

	console.log(formData);

    xhr.open("POST", php, true);
    xhr.onreadystatechange = function() {
        console.log('readyState: ' + xhr.readyState);
        console.log('status: ' + xhr.status);
        if (xhr.readyState == 4 && xhr.status == 200) {
			// Everything ok, get the user data
			//console.log(xhr.responseText);
			var str = xhr.responseText;
            if (str.match(/^\[/)) { //check that the response is indeed parseable data
				userRaw = JSON.parse(xhr.responseText)
				console.log(userRaw); // handle response.
			
				window.localStorage.setItem('userid',userRaw[0].id);
				window.localStorage.setItem('username',userRaw[0].username);	
				
				//This resets everything in the front end
				resetUI();
			}
			else {
				console.log(xhr.responseText);
				//--> perhaps set a user error notice in the html
			}

        }
	};
	xhr.send(formData);
});

