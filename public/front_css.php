<?php
header('Content-Type: text/css');

$dir = "build/";
$files = scandir($dir);

foreach ($files as $file){

    if(strpos($file, 'app') === 0 && strpos($file, ".css")){
        echo file_get_contents($dir.$file);
    }
}