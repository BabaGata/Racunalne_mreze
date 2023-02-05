<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $timeStamp = strval(time());
    mkdir($timeStamp);
    $webroot = getcwd();
    move_uploaded_file($_FILES["popis_poklona"]["tmp_name"], $webroot . "/" . $timeStamp . "/" . $_FILES["popis_poklona"]["name"]);
    http_response_code(201);
}

elseif ($_SERVER["REQUEST_METHOD"] == "PUT" && $_SERVER["REQUEST_URI"] == "/upload") 
{   
    $putdata = file_get_contents('php://input');
    $webroot = getcwd();
    file_put_contents($webroot . "/" . "popis.txt", $putdata);
    http_response_code(201);
}
?>