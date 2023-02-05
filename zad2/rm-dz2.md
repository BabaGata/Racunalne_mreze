# Računalne mreže: domaća zadaća 2

## Osnovni podaci

**Ime i prezime:** `Agata Vujić`

**Studijska grupa:** `14h`

**JMBAG:** `0316002560`

## Zadatak 1

Osmislite vlastiti primjer resursa koji reprezentira objekt iz stvarnosti te implementirajte za taj objekt CRUD REST API, odnosno stvaranje, čitanje, osvježavanje i brisanje korištenjem URI-ja i HTTP metoda po uzoru na primjer s vježbi. Iskoristite datoteku za pohranu podataka.

**Opis objekta iz stvarnosti koji će biti reprezentiran i primjer reprezentacije u obliku JSON:**

> Sok
{
      "Id": "sok2",
      "Okus": "Naranca",
      "Udio voca": "100%",
      "created": "2020-12-09T14:50:32+0100",
      "edited": "2020-12-20T21:14:07+0100",
      "url": "http://localhost:8000/sokovi/2"
    }

**Sadržaj datoteke index.php:**

``` php
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
```

**Provjera točnosti rada HTTP klijentom:**

```
$ curl -v http://localhost:8000/sokovi/2
*   Trying 127.0.0.1:8000...
* TCP_NODELAY set
* Connected to localhost (127.0.0.1) port 8000 (#0)
> GET /sokovi/2 HTTP/1.1
> Host: localhost:8000
> User-Agent: curl/7.68.0
> Accept: */*
> 
* Mark bundle as not supporting multiuse
< HTTP/1.1 200 OK
< Host: localhost:8000
< Date: Sun, 12 Dec 2021 21:30:09 GMT
< Connection: close
< X-Powered-By: PHP/7.4.3
< Content-Type: application/json
< 
{"Id":"sok2","Okus":"Naranca","Udio voca":"100%","created":"2020-12-09T14:50:32+0100","edited":"2020-12-20T21:14:07+0100","url":"http:\/\/localhost:8000\/sokovi\/2"}

$ curl -v -X POST -H 'Content-Type: application/json' -d '{"Id": "Sok6", "Okus":"Multivitamin", "Udio voca":"20%"}' http://localhost:8000/sokovi
Note: Unnecessary use of -X or --request, POST is already inferred.
*   Trying 127.0.0.1:8000...
* TCP_NODELAY set
* Connected to localhost (127.0.0.1) port 8000 (#0)
> POST /sokovi HTTP/1.1
> Host: localhost:8000
> User-Agent: curl/7.68.0
> Accept: */*
> Content-Type: application/json
> Content-Length: 56
> 
* upload completely sent off: 56 out of 56 bytes
* Mark bundle as not supporting multiuse
< HTTP/1.1 201 Created
< Host: localhost:8000
< Date: Sun, 12 Dec 2021 21:41:29 GMT
< Connection: close
< X-Powered-By: PHP/7.4.3
< Content-Type: application/json


curl -v -X PUT -H 'Content-Type: application/json' -d '{"Id": "Sok1", "Okus":"Jagoda", "Udio voca":"100%" }' http://localhost:8000/sokovi/1
*   Trying 127.0.0.1:8000...
* TCP_NODELAY set
* Connected to localhost (127.0.0.1) port 8000 (#0)
> PUT /sokovi/1 HTTP/1.1
> Host: localhost:8000
> User-Agent: curl/7.68.0
> Accept: */*
> Content-Type: application/json
> Content-Length: 52
> 
* upload completely sent off: 52 out of 52 bytes
* Mark bundle as not supporting multiuse
< HTTP/1.1 201 Created
< Host: localhost:8000
< Date: Sun, 12 Dec 2021 21:47:10 GMT
< Connection: close
< X-Powered-By: PHP/7.4.3
< Content-Type: application/json
< 
* Closing connection 0

$ curl -v -X DELETE http://localhost:8000/sokovi/1
*   Trying 127.0.0.1:8000...
* TCP_NODELAY set
* Connected to localhost (127.0.0.1) port 8000 (#0)
> DELETE /sokovi/1 HTTP/1.1
> Host: localhost:8000
> User-Agent: curl/7.68.0
> Accept: */*
> 
* Mark bundle as not supporting multiuse
< HTTP/1.1 410 Gone
< Host: localhost:8000
< Date: Sun, 12 Dec 2021 21:50:42 GMT
< Connection: close
< X-Powered-By: PHP/7.4.3
< Content-Type: application/json
< 
* Closing connection 0

```

## Zadatak 2

Iskoristite Siege da izmjerite performanse HTTP poslužitelja kroz 30 sekundi kad se čita:

- 1 resurs
- svi resursi

tako da pritom Siege ima istovremenih:

- 10 korisnika
- 100 korisnika

tako da pritom PHP pokreće:

- 1 proces
- 10 procesa

Isprobajte sve kombinacije navedenih postavki mjerenja.

**Naredbe i izlaz Siegea:**

```
$ PHP_CLI_SERVER_WORKERS=10 php -S localhost:8000 -t zad2
[8071] [Mon Dec 13 13:35:01 2021] PHP 7.4.3 Development Server (http://localhost:8000) started
[8069] [Mon Dec 13 13:35:01 2021] PHP 7.4.3 Development Server (http://localhost:8000) started
[8070] [Mon Dec 13 13:35:01 2021] PHP 7.4.3 Development Server (http://localhost:8000) started
[8073] [Mon Dec 13 13:35:01 2021] PHP 7.4.3 Development Server (http://localhost:8000) started
[8068] [Mon Dec 13 13:35:01 2021] PHP 7.4.3 Development Server (http://localhost:8000) started
[8074] [Mon Dec 13 13:35:01 2021] PHP 7.4.3 Development Server (http://localhost:8000) started
[8072] [Mon Dec 13 13:35:01 2021] PHP 7.4.3 Development Server (http://localhost:8000) started
[8076] [Mon Dec 13 13:35:01 2021] PHP 7.4.3 Development Server (http://localhost:8000) started
[8077] [Mon Dec 13 13:35:01 2021] PHP 7.4.3 Development Server (http://localhost:8000) started
[8075] [Mon Dec 13 13:35:01 2021] PHP 7.4.3 Development Server (http://localhost:8000) started
[8078] [Mon Dec 13 13:35:01 2021] PHP 7.4.3 Development Server (http://localhost:8000) started

$ siege -c 10 -t 30s  http://localhost:8000/
** SIEGE 4.0.4
** Preparing 10 concurrent users for battle.
The server is now under siege...
Lifting the server siege...
Transactions:		       62195 hits
Availability:		      100.00 %
Elapsed time:		       29.08 secs
Data transferred:	        0.00 MB
Response time:		        0.00 secs
Transaction rate:	     2138.76 trans/sec
Throughput:		        0.00 MB/sec
Concurrency:		        9.82
Successful transactions:           0
Failed transactions:	           0
Longest transaction:	        0.32
Shortest transaction:	        0.00
 
 $ siege -c 1 -t 30s  http://localhost:8000/
** SIEGE 4.0.4
** Preparing 1 concurrent users for battle.
The server is now under siege...
Lifting the server siege...
Transactions:		       29910 hits
Availability:		      100.00 %
Elapsed time:		       29.17 secs
Data transferred:	        0.00 MB
Response time:		        0.00 secs
Transaction rate:	     1025.37 trans/sec
Throughput:		        0.00 MB/sec
Concurrency:		        0.91
Successful transactions:           0
Failed transactions:	           0
Longest transaction:	        0.26
Shortest transaction:	        0.00
 
$ siege -c 10 -t 30s  http://localhost:8000/sokovi/1
** SIEGE 4.0.4
** Preparing 10 concurrent users for battle.
The server is now under siege...
Lifting the server siege...
Transactions:		       57024 hits
Availability:		      100.00 %
Elapsed time:		       29.52 secs
Data transferred:	        0.00 MB
Response time:		        0.01 secs
Transaction rate:	     1931.71 trans/sec
Throughput:		        0.00 MB/sec
Concurrency:		        9.82
Successful transactions:           0
Failed transactions:	           0
Longest transaction:	        0.52
Shortest transaction:	        0.00
 
$ siege -c 1 -t 30s  http://localhost:8000/sokovi/1
** SIEGE 4.0.4
** Preparing 1 concurrent users for battle.
The server is now under siege...
Lifting the server siege...
Transactions:		       29172 hits
Availability:		      100.00 %
Elapsed time:		       29.35 secs
Data transferred:	        0.00 MB
Response time:		        0.00 secs
Transaction rate:	      993.94 trans/sec
Throughput:		        0.00 MB/sec
Concurrency:		        0.91
Successful transactions:           0
Failed transactions:	           0
Longest transaction:	        0.22
Shortest transaction:	        0.00
 
$ PHP_CLI_SERVER_WORKERS=1 php -S localhost:8000 -t zad2
number of workers must be larger than 1
[Mon Dec 13 13:41:44 2021] PHP 7.4.3 Development Server (http://localhost:8000) started

$ siege -c 10 -t 30s  http://localhost:8000/
** SIEGE 4.0.4
** Preparing 10 concurrent users for battle.
The server is now under siege...
Lifting the server siege...
Transactions:		       60491 hits
Availability:		      100.00 %
Elapsed time:		       29.53 secs
Data transferred:	        0.00 MB
Response time:		        0.00 secs
Transaction rate:	     2048.46 trans/sec
Throughput:		        0.00 MB/sec
Concurrency:		        9.74
Successful transactions:           0
Failed transactions:	           0
Longest transaction:	        0.40
Shortest transaction:	        0.00
 
$ siege -c 1 -t 30s  http://localhost:8000/
** SIEGE 4.0.4
** Preparing 1 concurrent users for battle.
The server is now under siege...
Lifting the server siege...
Transactions:		       32761 hits
Availability:		      100.00 %
Elapsed time:		       29.99 secs
Data transferred:	        0.00 MB
Response time:		        0.00 secs
Transaction rate:	     1092.40 trans/sec
Throughput:		        0.00 MB/sec
Concurrency:		        0.90
Successful transactions:           0
Failed transactions:	           0
Longest transaction:	        0.09
Shortest transaction:	        0.00
 
$ siege -c 10 -t 30s  http://localhost:8000/sokovi/1
** SIEGE 4.0.4
** Preparing 10 concurrent users for battle.
The server is now under siege...
Lifting the server siege...
Transactions:		       64117 hits
Availability:		      100.00 %
Elapsed time:		       29.38 secs
Data transferred:	        0.00 MB
Response time:		        0.00 secs
Transaction rate:	     2182.33 trans/sec
Throughput:		        0.00 MB/sec
Concurrency:		        9.71
Successful transactions:           0
Failed transactions:	           0
Longest transaction:	        0.40
Shortest transaction:	        0.00
 
$ siege -c 1 -t 30s  http://localhost:8000/sokovi/1
** SIEGE 4.0.4
** Preparing 1 concurrent users for battle.
The server is now under siege...
Lifting the server siege...
Transactions:		       32498 hits
Availability:		      100.00 %
Elapsed time:		       29.68 secs
Data transferred:	        0.00 MB
Response time:		        0.00 secs
Transaction rate:	     1094.95 trans/sec
Throughput:		        0.00 MB/sec
Concurrency:		        0.91
Successful transactions:           0
Failed transactions:	           0
Longest transaction:	        0.10
Shortest transaction:	        0.00
  ```

**Rezultati mjerenja:**

| Postavke mjerenja | Transactions | Response time | Transaction rate | Concurrency |
| ----------------- | ------------ | ------------- | ---------------- | ----------- |
| 1 resurs, 10 korisnika, 1 proces | 64117 hits | 0.00 secs | 2182.33 trans/sec | 9.71 |
| 1 resurs, 10 korisnika, 10 procesa | 57024 hits | 0.01 secs | 1931.71 trans/sec | 9.82 |
| 1 resurs, 1 korisnik, 1 proces | 32498 hits | 0.00 secs | 1094.95 trans/sec | 0.91 |
| 1 resurs, 1 korisnik, 10 procesa | 29172 hits | 0.00 secs | 993.94 trans/sec | 0.91 |
| svi resursi, 10 korisnika, 1 proces | 60491 hits | 0.00 secs | 2048.46 trans/sec | 9.74 |
| svi resursi, 10 korisnika, 10 procesa | 62195 hits | 0.00 secs | 2138.76 trans/sec | 9.82 |
| svi resursi, 1 korisnik, 1 proces | 32761 hits | 0.00 secs | 1092.40 trans/sec | 0.90 |
| svi resursi, 1 korisnik, 10 procesa| 29910 hits | 0.00 secs | 1025.37 trans/sec | 0.91|