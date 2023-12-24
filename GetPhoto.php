<?php require_once"connect.php"?>
<form action="GetPhoto.php" method="post">
    <label for="matricule">matricule : </label>
    <input type="text" name="matricule" id="matricule">
    <input type="submit" value="go">
</form>
<?php
    if (!isset($_POST['matricule'])) {
        $matricule = null;
    } else {
        $matricule = $_POST['matricule'];
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
            // You have the picture path
            $picture_path = "$path/$matricule/".$picture;
        }else{
            $picture_path = "#";
            echo"<script>alert('picture not found')</script>";
        }
        if (isset($certificate)) {
            // You have the certificate path
            $certificate_path = "$path/$matricule/".$certificate;
        }else{
            $certificate_path = "#";
            echo"<script>alert('certificate not found')</script>";
        }
    }
    

?>
<img src="<?php echo"$picture_path"?>" alt="">
<img src="<?php echo"$certificate_path"?>" alt="">
