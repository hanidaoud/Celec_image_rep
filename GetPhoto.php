<?php
    require "GetUUID.php";
?>
<!--   That is just a protocole to try differents matricule     -->
<form action="GetPhoto.php" method="post">
    <label for="matricule">matricule : </label>
    <input type="text" name="matricule" id="matricule">
    <input type="submit" value="go">
</form>
<?php
    // DO a post for the matricule to be initialized
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
            $uuid = getUUID($picture);
            $picture_path = "$path/$matricule/".$picture;
        }else{
            $picture_path = "#";
            echo"<script>alert('picture not found')</script>";
        }
        if (isset($certificate)) {
            $certificate_path = "$path/$matricule/".$certificate;
            $uuid = getUUID($certificate);
        }else{
            $certificate_path = "#";
            echo"<script>alert('certificate not found')</script>";
        }
        if(!isset($uuid)){
            echo"<script>alert('UUID not found')</script>";
        }
    }
    

?>

<?php 
    if (isset($uuid)) {
        echo "<h1>Your uuid is $uuid</h1>";
        $photo_data['photo_uuid'] = $uuid;
        $photo_data['picture_path'] = $picture_path;
        $photo_data['certificate_path'] =$certificate_path;


        /** Your json data */
        $photo_data = json_encode($photo_data, JSON_PRETTY_PRINT);
    }
?>