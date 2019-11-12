<?php
$mysql = new mysqli('localhost','root','','db_1');
$id = $_POST['changeuserid'];
$result = $mysql->query("SELECT * FROM `users` WHERE id='$id'");
$user = $result->fetch_assoc();
$target_dir = "assets/img/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submitphoto"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check == true) {
     //   echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
      //  echo "File is not an image.";
        $uploadOk = 0;
    }
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
 //   echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
 //   echo "Sorry, your file was not uploaded.";
    //header('Location: index.php');

// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $mysql -> query("UPDATE users SET photo='$target_file' WHERE id='$id'");
     //   echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        $mysql->close();
        header('Location: index.php');
    } else {
        echo "Sorry, there was an error uploading your file.";
    }

}