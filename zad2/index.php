<?php

$datoteka = "sokovi.json";
if (file_exists($datoteka)) {
    $j = file_get_contents($datoteka);
    $sokovi= json_decode($j, true);
} else {
    $sokovi = [];
}

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "GET" && $_SERVER["REQUEST_URI"] == "/sokovi") {
    $response_body_array = ["count" => count($sokovi), "results" => array_values($sokovi)];
    $response_body = json_encode($response_body_array);
    echo $response_body;
    echo "\n";
} else if ($_SERVER["REQUEST_METHOD"] == "GET" && preg_match("/^\/sokovi\/[1-9][0-9]*$/", $_SERVER["REQUEST_URI"])) {
    $uri_parts = explode("/", $_SERVER["REQUEST_URI"]);
    $id = $uri_parts[2];

    if (array_key_exists($id, $sokovi)) {
        $response_body_object = $sokovi[$id];
        $response_body = json_encode($response_body_object);
        echo $response_body;
        echo "\n";
    } else {
        http_response_code(404);
    }
} else if ($_SERVER["REQUEST_METHOD"] == "POST" && $_SERVER["REQUEST_URI"] == "/sokovi") {
    if (! array_key_exists("HTTP_CONTENT_TYPE", $_SERVER) || $_SERVER["HTTP_CONTENT_TYPE"] != "application/json") {
        http_response_code(415);
        exit;
    }
    $request_body = file_get_contents("php://input");
    $sokovi = json_decode($request_body, true);
    if ($sokovi != NULL &&
        array_key_exists("Id", $sokovi) && gettype($sokovi["Id"]) == "string" &&
        array_key_exists("Okus", $sokovi) && gettype($sokovi["Okus"]) == "string" &&
        array_key_exists("Udio voca", $sokovi) && gettype($sokovi["Udio voca"]) == "string"){
    $date_time = date(DATE_ISO8601);
        $sokovi[$id] = ["Id" => $sokovi["Id"],
                      "Okus" => $sokovi["Okus"],
                      "Udio voca"=>$sokovi["Udio voca"],
                      "created" => $date_time,
                      "edited" => $date_time];
        $id = array_key_last($sokovi);
        $sokovi[$id]["url"] = "http://localhost:8000/sokovi/" . $id;
        http_response_code(201);
    } else {
        http_response_code(400);
    }
} else if ($_SERVER["REQUEST_METHOD"] == "PUT" && preg_match("/^\/sokovi\/[1-9][0-9]*$/", $_SERVER["REQUEST_URI"])) {
    if (! array_key_exists("HTTP_CONTENT_TYPE", $_SERVER) || $_SERVER["HTTP_CONTENT_TYPE"] != "application/json") {
        http_response_code(415);
        exit;
    }
    $uri_parts = explode("/", $_SERVER["REQUEST_URI"]);
    $id = $uri_parts[2];

    if (! array_key_exists($id, $sokovi)) {
        $request_body = file_get_contents("php://input");
        $sokovi = json_decode($request_body, true);
        if ($sokovi != NULL &&
        array_key_exists("Id", $sokovi) && gettype($sokovi["Id"]) == "string" &&
        array_key_exists("Okus", $sokovi) && gettype($sokovi["Okus"]) == "string" &&
        array_key_exists("Udio voca", $sokovi) && gettype($sokovi["Udio voca"]) == "string"){
        $date_time = date(DATE_ISO8601);
            $sokovi[$id] = ["Id" => $sokovi["Id"],
                      "Okus" => $sokovi["Okus"],
                      "Udio voca"=>$sokovi["Udio voca"],
                      "created" => $date_time,
                      "edited" => $date_time];
        $id = array_key_last($sokovi);
        $sokovi[$id]["url"] = "http://localhost:8000/sokovi/" . $id;
            http_response_code(201);
        } else {
            http_response_code(400);
        }
    } else {
        $request_body = file_get_contents("php://input");
        $sokovi = json_decode($request_body, true);
        if ($sokovi != NULL &&
        array_key_exists("Id", $sokovi) && gettype($sokovi["Id"]) == "string" &&
        array_key_exists("Okus", $sokovi) && gettype($sokovi["Okus"]) == "string" &&
        array_key_exists("Udio voca", $sokovi) && gettype($sokovi["Udio voca"]) == "string"){
        $date_time = date(DATE_ISO8601);
            $sokovi[$id] = ["Id" => $sokovi["Id"],
                      "Okus" => $sokovi["Okus"],
                      "Udio voca"=>$sokovi["Udio voca"],
                      "created" => $date_time,
                      "edited" => $date_time];
            http_response_code(200);
        } else {
            http_response_code(400);
        }
    }
} else if ($_SERVER["REQUEST_METHOD"] == "PATCH" && preg_match("/^\/sokovi/[1-9][0-9]*$/", $_SERVER["REQUEST_URI"])) {
    if (! array_key_exists("HTTP_CONTENT_TYPE", $_SERVER) || $_SERVER["HTTP_CONTENT_TYPE"] != "application/json") {
        http_response_code(415);
        exit;
    }
    $uri_parts = explode("/", $_SERVER["REQUEST_URI"]);
    $id = $uri_parts[2];

    if (array_key_exists($id, $sokovi)) {
        $request_body = file_get_contents("php://input");
        $sokovi = json_decode($request_body, true);
        if ($sokovi != NULL &&
        array_key_exists("Id", $sokovi) && gettype($sokovi["Id"]) == "string" ||
        array_key_exists("Okus", $sokovi) && gettype($sokovi["Okus"]) == "string" ||
        array_key_exists("Udio voca", $sokovi) && gettype($sokovi["Udio voca"]) == "string") {
        if (array_key_exists("Id", $sokovi)) {
                $sokovi[$id]["Id"] = $sokovi["Id"];
        }
        if (array_key_exists("Okus", $sokovi)) {
                $sokovi[$id]["Okus"] = $sokovi["Okus"];
        }
        if (array_key_exists("Udio voca", $sokovi)) {
                $sokovi[$id]["Udio voca"] = $sokovi["Udio voca"];
        }
        $date_time = date(DATE_ISO8601);
            $sokovi[$id]["edited"] = $date_time;
            http_response_code(200);
        } else {
            http_response_code(400);
        }
    } else {
        http_response_code(403);
    }
} else if ($_SERVER["REQUEST_METHOD"] == "DELETE" && preg_match("/^\/sokovi\/[1-9][0-9]*$/", $_SERVER["REQUEST_URI"])) {
    $uri_parts = explode("/", $_SERVER["REQUEST_URI"]);
    $id = $uri_parts[2];

    if (array_key_exists($id, $sokovi)) {
        unset($sokovi[$id]);
        http_response_code(410);
    } else {
        http_response_code(404);
    }
} else {
    http_response_code(400);
}

$j = json_encode($sokovi);
file_put_contents($datoteka, $j);
?>