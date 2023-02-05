<?php


$vrijeme=time();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $webroot = getcwd();
    mkdir($webroot . "/" . $vrijeme);

    move_uploaded_file($_FILES["datoteka"]["tmp_name"], $webroot . "/" . $vrijeme . "/" . $_FILES["datoteka"]["name"]);
    http_response_code(201);
}
//curl -v -F 'datoteka=@/home/dea/Desktop/pokloni.txt' http://localhost:8000/

if ($_SERVER["REQUEST_METHOD"] == "PUT" && $_SERVER["REQUEST_URI"] == "/upload") {
    $webroot = getcwd();
    mkdir($webroot . "/" . $vrijeme);

    $putdata = file_get_contents('php://input');
    file_put_contents($webroot . "/" . $vrijeme . "/" . "odabrani_naziv.txt", $putdata);
    http_response_code(201);
}
//curl -v -T /home/dea/Desktop/pokloni.txt http://localhost:8000/upload

?>