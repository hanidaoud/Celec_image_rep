<?php
    //Function to get the uuid from the fileName
    function getUUID($fileName) {
        $uuid = '';
        $fileContent = explode('-', $fileName);
        for ($i=0; $i < 5; $i++) { 
            $uuid = $uuid.'-'.$fileContent[$i];
            
        }
        $uuid = substr($uuid, 1);
        return $uuid;        
    }
?>