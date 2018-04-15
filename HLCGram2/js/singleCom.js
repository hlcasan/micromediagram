/* Single image Handler to showcase a single image and its comments
	Displays the comments related to the selected image.
	Uses comRaw which come json-encoded from the DB through singleCom.php

	The image is handled by singleImg.js
*/

var singleCom = function () {
	
	var php = "singleCom.php";
	
	var xhr = new XMLHttpRequest();
	var formData = new FormData();
	formData.append("i",qStr.i);
	var comRaw = new Array();

	// Empty to comments box before we start to avoid duplicates
	document.getElementById('commentsBox').innerHTML = "";

    xhr.open("POST", php, true);
    xhr.onreadystatechange = function() {
        console.log('readyState: ' + xhr.readyState);
        console.log('status: ' + xhr.status);
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Everything ok, get the images
            comRaw = JSON.parse(xhr.responseText);
			//console.log("comRaw: "+comRaw); // handle response.
			//console.log(qStr.i); // handle response.

			//Dump comments in the DOM
			for (let c in comRaw) {
				console.log(c);

				let commentsDIV = document.createElement('div');
				commentsDIV.className = "commentBox";
				
				//User
				let commentUser = document.createElement('span');
				commentUser.innerHTML = comRaw[c].username;
				commentUser.className = "commentUser";
				
				//Comment
				let commentP = document.createElement('p');
				commentP.innerHTML = comRaw[c].content;
				commentP.insertBefore(commentUser,commentP.firstChild);
				
				//Time
				let commentT = document.createElement('p');
				commentT.innerHTML = "Posted: "+comRaw[c].timestamp;
				
				commentsDIV.appendChild(commentP);
				commentsDIV.appendChild(commentT);
				document.getElementById('commentsBox').appendChild(commentsDIV);
			}
		}
	};
	xhr.send(formData);
};

