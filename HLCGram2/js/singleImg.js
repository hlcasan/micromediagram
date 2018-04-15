/* Single image Handler to showcase a single image and its comments
	Displays the selected image.
	Uses imgRaw which come json-encoded from the DB through singleImg.php

	Comments are handled by singleCom.js
*/


var singleImg = function () {
	
	var php = "singleImg.php";
	
	var xhr = new XMLHttpRequest();
	var formData = new FormData();
	formData.append("i",qStr.i);
	var imgRaw = new Array();

    xhr.open("POST", php, true);
    xhr.onreadystatechange = function() {
        console.log('readyState: ' + xhr.readyState);
        console.log('status: ' + xhr.status);
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Everything ok, get the images
            imgRaw = JSON.parse(xhr.responseText);
			//console.log("imgRaw: "+imgRaw); // handle response.
			//console.log(qStr.i); // handle response.
			
			//Dump images in the DOM
			for (let c in imgRaw) {
				console.log(c);

				//Dump image in DOM
				for (let c = 0; c < imgRaw.length; c++) {
					//Container div
					let imgDIV = document.createElement('div');
					
					//Caption
					let captionP = document.createElement('p');
					captionP.innerHTML = "Caption: "+imgRaw[c].caption;
					captionP.className = "cpt";
					
					//Title
					let titleP = document.createElement('p');
					titleP.innerHTML = "Title: "+imgRaw[c].title;
					titleP.className = "ttl";
					
					//The image
					let img = document.createElement('img');
					img.src = imgRaw[c].url;
					
					//Creator of image
					let imgUser = document.createElement('p');
					imgUser.innerHTML = "User: "+imgRaw[c].username;
					
					//Organize the structure and dump in html	
					imgDIV.appendChild(img);
					imgDIV.appendChild(imgUser);
					imgDIV.appendChild(titleP);
					imgDIV.appendChild(captionP);
					document.getElementById('imgBox').appendChild(imgDIV);
				}
			}
		}
	};
	xhr.send(formData);
};

