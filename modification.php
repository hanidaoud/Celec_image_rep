<?php require_once"connect.php"?>
<form action="modification.php" method="post" enctype="multipart/form-data" accept-charset="utf-8">
    <label for="matricule">matricule : </label>
    <input type="text" name="matricule" id="matricule">
    <label for="picture">picture : </label>
    <input type="file" name="picture" id="picture">
    <label for="certificate">certificate : </label>
    <input type="file" name="certificate" id="certificate">
    <input type="submit" value="go">
</form>
<?php
    if (!isset($_POST['matricule'])) {
        $matricule = null;
        
    } else {
        $matricule = $_POST['matricule'];

        /* Get old photos */
        $path = './Global';
        if(is_dir("$path/$matricule")){
            foreach (new DirectoryIterator("$path/$matricule") as $fileInfo) {
                if($fileInfo->isDot()) continue;
                if (strpos($fileInfo->getFilename(), "certificate.")) {
                    $certificate = $fileInfo->getFilename();
                    
                }elseif(strpos($fileInfo->getFilename(), "picture.")){
                    $picture = $fileInfo->getFilename();
                    
                }
            }
        }
        if (isset($picture)) {
            $picture_path = "$path/$matricule/".$picture;
        }else{
            $picture_path = "#";
        }
        if (isset($certificate)) {
            $certificate_path = "$path/$matricule/".$certificate;
        }else{
            $certificate_path = "#";
            echo"<script>alert('certificate not found')</script>";
        }
    }
    if ($matricule!=null && $_FILES['picture']!=null && $_FILES['certificate']!=null){
        /*            INSERTION                 */
        /*             Define uuid              */
        $uuid = "myuuid";



        /* max_size en BIT*/
        $max_size = 500000;
        
        
        
        /*Picture*/
        if( $_FILES['picture']['name'] != "" ) {
            /*Check extention*/
            $ext = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);
            if ($ext == 'jpg' || $ext == 'png') {
                /* check size */
                if ($_FILES['picture']['size'] < $max_size) {
                    $path="$uuid-picture.$ext";
                    $pathto="./Global/$matricule/".$path;
                    if (move_uploaded_file( $_FILES['picture']['tmp_name'],$pathto)) {
                        if (sizeof(glob("$path/$matricule/*picture.*"))>1) {
                            unlink($picture_path);
                        }  
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
                /* check size */
                if ($_FILES['certificate']['size'] < $max_size) {
                    
                    $path="$uuid-certificate.$ext";
                    $pathto="./Global/$matricule/".$path;
                    if (move_uploaded_file( $_FILES['certificate']['tmp_name'],$pathto)) {
                        if (sizeof(glob("$path/$matricule/*certificate.*"))>1) {
                            unlink($certificate_path);
                        }                        
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
    }
?>