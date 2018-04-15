//drop.js
// *** add progress event *** 
console.log('drop.js is loaded');
var fileInput = document.getElementById('fileupload');
var previewSection = document.getElementById('previewSection');

fileInput.addEventListener('change', function () {
  //console.log(file.name, file.size, file.type, file.lastModified);
  let files = this.files;
  for (let i = 0; i < files.length; i++) {
    previewImage(this.files[i]);
    uploadFile(this.files[i]);
  }
}, false);

//display images to upload
var imageType = /image.*/;

function previewImage(file) {
  console.log(file.name, file.size, file.type, file.lastModified);

  //if uploaded file type is NOT an image, throw an error
  if (!file.type.match(imageType)) {
    //add code to catch errors
    throw 'File Type must be an image';
  }
  //create figure and img elements to display image
  let figure = document.createElement('figure');
  //using file.lastModified as id in order to update progress bar (better solution??)
  //'f'+ because you shouldn't start an ID with a number
  let figureID = 'f' + file.lastModified;
  let img = document.createElement('img');
  let figcaption = document.createElement('figcaption')
  let progressBar = document.createElement('progress');
  img.file = file;
  figure.appendChild(img);
  figure.appendChild(figcaption);
  figure.appendChild(progressBar);
  figure.setAttribute('id', figureID);
  previewSection.appendChild(figure);

  // use FileReader to display the image
  // rewrite this to be simpler using let?
  // needs a js closure to keep track of vars?
  var reader = new FileReader();
  reader.onload = (function (aImg) {
    return function (e) {
      aImg.src = e.target.result;
    };
  })(img);
  reader.readAsDataURL(file);

}

//upload images
function uploadFile(file) {
  console.log('uploadFile()' + file.name);
  var url = 'upload.php';
  var xhr = new XMLHttpRequest();
  var fd = new FormData();
  xhr.open('POST', url, true);
  xhr.onreadystatechange = function () {
    console.log('readyState: ' + xhr.readyState);
    console.log('status: ' + xhr.status);
    if (xhr.readyState == 4 && xhr.status == 200) {
      // Every thing ok, file uploaded
      console.log(xhr.responseText); // handle response.

      // HLC: set the url of the image in the form for the database
      document.querySelector('#url').value = "uploads/" + file.name; //HLC
    }
  };
  //get upload progress
  xhr.upload.addEventListener('progress', function (event) {
    if (event.lengthComputable) {
      //this works, but need to figure out how to update progress bars
      console.log('upload progress   ' + file.name + ' / ' + (event.loaded / event.total).toFixed(2));
      let loaded = (event.loaded / event.total).toFixed(2);
      let progressFigcaption = document.querySelector('#f' + file.lastModified + ' figcaption');
      progressFigcaption.innerHTML = loaded;
      let progressBar = document.querySelector('#f' + file.lastModified + ' progress');
      progressBar.value = loaded;
    }
  }, false);

  fd.append('upload_file', file);
  xhr.send(fd);
}
//above is the same as upload.js

// Setup the dnd listeners.
var dropZone = document.getElementById('dropZone');
dropZone.addEventListener('dragover', handleDrag, false);
dropZone.addEventListener('drop', handleDrop, false);

function handleDrag(event) {
  event.stopPropagation();
  event.preventDefault();
  event.dataTransfer.dropEffect = 'copy'; // Explicitly show this is a copy.
}

function handleDrop(event) {
  event.stopPropagation();
  event.preventDefault();

  let files = event.dataTransfer.files; // FileList object.
  console.log('dropped: ' + files.length);
  console.log('file: ' + files[0].name);
  //this is the same as above (lines 9-12?) ... so make into a function??
  for (let i = 0; i < files.length; i++) {
    previewImage(files[i]);
    uploadFile(files[i]);
  }
}