<?php
//upload.php
// *** chmod of 'uploads' to 777 ***
if (isset($_FILES['upload_file'])) {
  if(move_uploaded_file($_FILES['upload_file']['tmp_name'], "../uploads/" . $_FILES['upload_file']['name'])){
      echo $_FILES['upload_file']['name']. " OK";
  } else {
      echo $_FILES['upload_file']['name']. " KO";
  }
  exit;
} else {
  echo "No files uploaded ...";
}

?>