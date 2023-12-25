<?php require_once "connect.php"?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p>Inscription</p>
    <form action="main.php" method="post" enctype="multipart/form-data" accept-charset="utf-8">
        <label for="matricule">matricule : </label>
        <input type="text" name="matricule" id="matricule">
        <label for="picture">picture : </label>
        <input type="file" name="picture" id="picture">
        <label for="certificate">certificate : </label>
        <input type="file" name="certificate" id="certificate">
        <input type="submit" name="button" value="go">
    </form>


    <?php

        /* getting the files */ 
        if(!isset($_POST["matricule"])){
            $matricule = null ;
        }else{
            $matricule = $_POST["matricule"];
        }
        if(!isset($_POST["button"])){
            $button = null ;
        }else{
            $button = $_POST["button"];
        }
        if ($button=="go" && $matricule!=null && $_FILES['picture']!=null && $_FILES['certificate']!=null) {
            /* cheking if the matricule already exist */
            $sql = "SELECT matricule FROM user";
            $q1 = mysqli_query($connect,$sql);	
		    $array_matricule = mysqli_fetch_all($q1,MYSQLI_ASSOC);
            foreach ($array_matricule as $key => $value) {
                if($value['matricule'] == $matricule){
                    
                    echo "<script>alert('Ce matricule existe déja')</script>";
                    
                    exit();
                }
            }
            

            /*                 Folder creation                     */
            $file_path = "./Global/$matricule";
            if(!file_exists($file_path)){
                if(!mkdir("$file_path", 0777)){
                    echo "<script>alert('Echec dans la creation du fichier')</script>";
                    exit();
                }
            }


            /*            INSERTION                 */
            /*             Define uuid              */
            $uuid = rand(10000000, 99999999);


            for ($i=0; $i < 3; $i++) { 
                $uuid = $uuid."-".rand(1000,9999);
            }
            $uuid = $uuid."-".rand(100000000000, 999999999999);
            /* max_size en BIT*/
            $max_size = 500000;
            
            
            
            /*Picture*/
            if( $_FILES['picture']['name'] != "" ) {
                /*Check extention*/
                $ext = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);
                if ($ext == 'jpg' || $ext == 'png') {
                    
                    if ($_FILES['picture']['size'] < $max_size) {
                        $path="$uuid-picture.$ext";
                        $pathto="./Global/$matricule/".$path;
                        if (move_uploaded_file( $_FILES['picture']['tmp_name'],$pathto)) {
                            
                            $picture_fired = true;
                        } else {
                            
                            $picture_fired = false;
                            
                            echo "<script>alert('Could not copy file!')</script>";
                            exit();
                        }
                        
                    } else {
                        
                        echo "<script>alert('The picture size is too big. The picture must be under $max_size bit')</script>";
                        exit();
                    }
            
                }else{
                    echo "<script>alert('wrong extension. We only accept jpg or png')</script>";
                    exit();
                }
            }
            else {
                echo "<script>alert('No picture')</script>";
                exit();
            }



            /*certificate*/
            if( $_FILES['certificate']['name'] != "") {
                /*Check extention*/
                $ext = pathinfo($_FILES['certificate']['name'], PATHINFO_EXTENSION);
                if ($ext == 'jpg' || $ext == 'png') {
                    
                    if ($_FILES['certificate']['size'] < $max_size) {
                        
                        $path="$uuid-certificate.$ext";
                        $pathto="./Global/$matricule/".$path;
                        if (move_uploaded_file( $_FILES['certificate']['tmp_name'],$pathto)) {
                            
                            $certificate_fired = true;
                        } else {
                            
                            $certificate_fired = false;
                            echo "<script>alert('Could not copy file!')</script>";
                            exit();
                        }
                    } else {
                        
                        echo "<script>alert('The certificate size is too big. The certificate must be under $max_size bit')</script>";
                        exit();
                    }
                }else{
                    echo "<script>alert('wrong extension. We only accept jpg or png')</script>";
                    exit();
                }
            }
            else {
                echo "<script>alert('No picture')</script>";
                exit();
            }
            if ($certificate_fired && $picture_fired) {
                /* if the pictures registration are done you will get this variable */
                $process_done = true;
                $sql = "INSERT INTO user(matricule) VALUES('$matricule')";
                $q = mysqli_query($connect, $sql); 
            } else {
                die('Something went wrong in the pictures registration process');
            }
        }
    ?>
</body>
</html>