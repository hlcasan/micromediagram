/* Handler for single.php
	Displays the image and the comments.
	Uses imgRaw and comRaw which come json-encoded from the DB.
*/

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
	document.getElementById('showcase').appendChild(imgDIV);
}

//Dump comments in DOM
for (let c = 0; c < comRaw.length; c++) {
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
	document.getElementById('showcase').appendChild(commentsDIV);
}
