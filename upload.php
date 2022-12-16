<?php
if (isset($_POST['submit'])) { // checks if the button 'submit' was clicked.
    $file = $_FILES['file'];   // By using the Superglobal $_FILES we get information from the file that was uploaded, such as how big the file is or what type of file it is.  
    // when uploading a file, the file with gives us some information. The variables under are the types of information it gives. I put comments next to them.

    $fileName = $_FILES['file']['name'];            // the file name.
    $fileTmpName = $_FILES['file']['tmp_name'];     // the file's temporary name, the file is first stored temporarily on your pc.
    $fileSize = $_FILES['file']['size'];            // the size of the file
    $fileError = $_FILES['file']['error'];          // an error while uploading
    $fileType = $_FILES['file']['type'];            // the file type

    $fileExt = explode('.', $fileName);             // when uploading a file, for example image.png we want to separate the name of the file and the file extension.
    $fileActualExt = strtolower(end($fileExt));     // some files might have capitalized extensions, so this makes sure that image.PNG will be changed to image.png.

    $allowed = array('jpg', 'jpeg', 'png', 'pdf');  // this array checks for different file types.

    //These if statements are called error handlers, error handlers check if something has an error.

    if (in_array($fileActualExt, $allowed)) { // checks if the type of file is allowed to be uploaded as specified in the array above.
        if ($fileError === 0) {               // checks if the file gave an error during uploading
            if ($fileSize < 5000000) {        // checks if the file is smaller than 5.000.000 bytes, (5.000.000 bytes = 5000kb = 5mb). You can change the value to your liking.
                $fileNameNew = uniqid('', true).".".$fileActualExt; // generates a random file name, this is so files uploaded by other users won't overwrite the original file.
                $fileDestination = 'uploads/'.$fileNameNew;         // the destination of the file to be uploaded, in this case it's the uploads folder.
                move_uploaded_file($fileTmpName, $fileDestination); // the temporary location of the file ($fileTmpName) and where the new location is ($filedDestination).
                header('location: index.php?uploadsuccess');        // sends the user back to the home page with a success message in the url.
            } else {
                echo "Your file is too big!";
            }
        } else {
            echo "There was an error uploading your file!";
        }
    } else {
        echo "You cannot upload files of this type!";
    }
}

// 1 mb = 1000000 bytes
// 1 mb = 1000 kilobytes
