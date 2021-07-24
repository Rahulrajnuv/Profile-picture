<?php
    $db = mysqli_connect("localhost", "root", "","photos");
    //if upload button is clicked...
    if(isset($_POST['upload'])){
        $filename = $_FILES["uploadfile"]["name"];
        $tempname = $_FILES["uploadfile"]["tmp_name"];
        $folder = "image/".basename($filename);

        //GET all the submitted data from the form
        $sql = "INSERT INTO images (filename) VALUES ('$filename')";
        //Execute query
        mysqli_query($db, $sql);

        if(move_uploaded_file($tempname, $folder)){
            //if you want to delete previous all images from database
            $del = mysqli_query($db, "DELETE FROM images WHERE id<(SELECT max(id) FROM images)");
        }else{
            //write your message
        }
    }
    $photo = mysqli_query($db, "SELECT filename FROM images WHERE id=(SELECT max(id) FROM images)");
    $imagedp = mysqli_fetch_array($photo);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Change profile image</title>
</head>
<body>
    <section>
        <div class="box">
            <div class="container">
                <div id="profile">
                    <h3>Update Profile</h3>
                    <img src="<?php echo 'image/' . $imagedp['filename'] ?>"  class="dp">
                    <h6>Profile image</h6>
                </div>
                <form action="index.php" method="POST" enctype="multipart/form-data">
                    <p><input type="file" name="uploadfile" id="upload-btn" class="custom-file-input"></p>
                    <p><input type="submit" name="upload" class="file-upload" value="Upload Image"></p>
                </form>
            </div>
        </div>
    </section>
</body>
</html>