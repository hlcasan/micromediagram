//serialize_data.js
console.log('js/upload.js loaded');

//note that this version has a strange combination of multi & single upload

var uploadform = document.querySelector('#uploadform');
var previewSection = document.querySelector('#previewSection');
//why don't I use photoSRC for consistency??
var fileInput = document.querySelector('#fileInput');
var fileName = '';

//handle file input
fileInput.addEventListener('change', function(){
  let files = this.files;

  for(let i=0; i<files.length; i++){
    console.log(this.files[i]);
    previewImage(this.files[i]); 
    uploadFile(this.files[i]);   
  }
}, false);

var imageType = /image.*/;

function previewImage(file){
  console.log("previewImage: " + file.name, file.size, file.type, file.lastModified);
  fileName = file.name;

}

uploadform.addEventListener('submit', function(event){
  event.preventDefault();
  var formData = new FormData(uploadform);
  //console.log(formData);

  var url = 'app/insert.php';
  var xhr = new XMLHttpRequest();

  xhr.open("POST", url, true);
  xhr.onreadystatechange = function() {
    //console.log('readyState: ' + xhr.readyState);
    //console.log('status: ' + xhr.status);
      if (xhr.readyState == 4 && xhr.status == 200) {
          // Every thing ok, file uploaded
          var json = JSON.parse(xhr.responseText);
          console.log(json); // handle response.
      }
  };
  //since type="file" is not part of FormData, we need to add (append) it manually
  formData.append('photoSRC', fileName);
  //formData.append('photoSRC', fileInput.files[0]);
  xhr.send(formData);

});

//upload images
function uploadFile(file){
  console.log('uploadFile()' + file.name);
  var url = 'app/upload.php';
  var xhr = new XMLHttpRequest();
  var fd = new FormData();
  xhr.open("POST", url, true);
  xhr.onreadystatechange = function() {
    //console.log('readyState: ' + xhr.readyState);
    //console.log('status: ' + xhr.status);
      if (xhr.readyState == 4 && xhr.status == 200) {
          // Every thing ok, file uploaded
          console.log(xhr.responseText); // handle response.
      }
  };
  fd.append("upload_file", file);
  xhr.send(fd);
}