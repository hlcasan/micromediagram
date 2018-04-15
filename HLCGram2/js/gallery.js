/* Handler for the display of images in a gallery
	Displays the selected images.
	Uses the var imgRaw which comes json-translated from the DB through gallery.php.
*/

var gallery = function () {
	
	var php = "gallery.php";
	
	var xhr = new XMLHttpRequest();
	var imgRaw = new Array();

    xhr.open("GET", php, true);
    xhr.onreadystatechange = function() {
        console.log('readyState: ' + xhr.readyState);
        console.log('status: ' + xhr.status);
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Everything ok, get the images
            imgRaw = JSON.parse(xhr.responseText);
			console.log(imgRaw); // handle response.
			
			//Dump images in the DOM
			for (let c in imgRaw) {
				console.log(c);
				
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
				
				//Link to single
				let link = document.createElement('a');
				link.href = "single.html?i="+imgRaw[c].id;
				link.appendChild(img);
				
				//Creator of image
				let imgUser = document.createElement('p');
				imgUser.innerHTML = "User: "+imgRaw[c].username;
				
				//Organize the structure and dump in html
				imgDIV.appendChild(link);
				imgDIV.appendChild(imgUser);
				imgDIV.appendChild(titleP);
				imgDIV.appendChild(captionP);
				document.getElementById('gallery').appendChild(imgDIV);
			}
        }
	};
	xhr.send();
};

