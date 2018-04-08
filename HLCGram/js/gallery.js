/* Handler for the display of images in a gallery: index.php, etc.
	Displays the selected images.
	Uses the var imgRaw which comes json-translated from the DB.
*/

//Dump images in the DOM
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
	
	//Link to single
	let link = document.createElement('a');
	link.href = "single.php?img="+imgRaw[c].id+"&user="+localUserID;
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
