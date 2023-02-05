# Računalne mreže: laboratorijska vježba 4

## Osnovni podaci

**Ime i prezime:** `Agata Vujić`

**Studijska grupa:** `14 h`

**JMBAG:** `0316002560`

## Zadatak 1

Napravite datoteku `index.php` tako da:

* poslužitelj zahtijeva autentifikaciju i vraća statusni kod 401 Unauthorized sa sadržajem zaglavlja WWW-Authenticate i porukom po vašem izboru svim neprijavljenim korisnicima
* kod prijave poslužitelj provjerava korisničko ime i zaporku u popisu korisnika koji učitava iz datoteke `user-data.json` oblika

    ``` json
    [{"username":"filip","password":"teletubbiesfan12345"},{"username":"ana","password":"1ijedansu2"}]
    ```

* zahtjev HTTP metodom POST od strane korisnika admin čija je zaporka vaš JMBAG omogućuje stvaranje novog korisnika navođenjem u zahtjevu varijabli username i password; podaci o novom korisniku spremaju se pritom u datoteku `user-data.json`

Isprobajte cURL-om razvijeni kod.

**Sadržaj datoteke index.php (ISPUNJAVA STUDENT):**

``` php
<?php
$data = "user-data.json";
if (file_exists($data)) {
    $j = file_get_contents($data);
    $users = json_decode($j, true);
} else {
    $users = [];
}
if (isset($_SERVER["PHP_AUTH_USER"]) && isset($_SERVER["PHP_AUTH_PW"])) {
    $user = $_SERVER["PHP_AUTH_USER"];
    $pw = $_SERVER["PHP_AUTH_PW"];

    if ($user == 'admin' && $pw == '0316002560' && $_SERVER["REQUEST_METHOD"] == "POST"){
        $arr1 = [["username" => $_POST["username"], "password" => $_POST["password"]]];
        $j2 = array_merge($users, $arr1);
        $j1 = json_encode($j2, JSON_PRETTY_PRINT);
        echo $j1;
        file_put_contents('user-data.json', $j1);
    }
    else{
        $i=1;
        foreach($users as $pair) {
            if($pair["username"] == $user && $pair["password"] == $pw){
                echo "<p>Pozdrav $user, uspješno ste se prijavili</p>\n";
                $a=1;
                exit;
            }
            else{
                $i=$i+1;
            }
        }
        if ($i >= count($users)/2){
            http_response_code(401);
            header("WWW-Authenticate: Basic realm=\"Tajni laboratorij Odjela za alkemiju\"");
            echo "<p>Korisničko ime ili lozinka su pogresni.</p>\n";
            $i=1;
            exit;
        }
    }
}  
else {
    http_response_code(401);
    header("WWW-Authenticate: Basic realm=\"Tajni laboratorij Odjela za alkemiju\"");
    echo "<p>Niste se prijavili.</p>\n";
}
?>  
```

**Provjera točnosti rada HTTP klijentom (ISPUNJAVA STUDENT):**

```
$ curl -v -u maja:hehehe http://localhost:8000/
*   Trying 127.0.0.1:8000...
* TCP_NODELAY set
* Connected to localhost (127.0.0.1) port 8000 (#0)
* Server auth using Basic with user 'maja'
> GET / HTTP/1.1
> Host: localhost:8000
> Authorization: Basic bWFqYTpoZWhlaGU=
> User-Agent: curl/7.68.0
> Accept: */*
> 
* Mark bundle as not supporting multiuse
< HTTP/1.1 401 Unauthorized
< Host: localhost:8000
< Date: Tue, 23 Nov 2021 14:36:27 GMT
< Connection: close
< X-Powered-By: PHP/7.4.3
* Authentication problem. Ignoring this.
< WWW-Authenticate: Basic realm="Tajni laboratorij Odjela za alkemiju"
< Content-type: text/html; charset=UTF-8
< 
<p>Korisničko ime ili lozinka su pogresni.</p>
* Closing connection 0


$ curl -v -u ana:1iedansu2 http://localhost:8000/
*   Trying 127.0.0.1:8000...
* TCP_NODELAY set
* Connected to localhost (127.0.0.1) port 8000 (#0)
* Server auth using Basic with user 'ana'
> GET / HTTP/1.1
> Host: localhost:8000
> Authorization: Basic YW5hOjFpamVkYW5zdTI=
> User-Agent: curl/7.68.0
> Accept: */*
> 
* Mark bundle as not supporting multiuse
< HTTP/1.1 200 OK
< Host: localhost:8000
< Date: Tue, 23 Nov 2021 13:40:04 GMT
< Connection: close
< X-Powered-By: PHP/7.4.3
< Content-type: text/html; charset=UTF-8
< 
<p>Pozdrav ana, uspješno ste se prijavili</p>
* Closing connection 0


$ curl -v -u admin:0316002560 POST -d "username=maja" -d "password=hehehe" http://localhost:8000/
* Could not resolve host: POST
* Closing connection 0
curl: (6) Could not resolve host: POST
*   Trying 127.0.0.1:8000...
* TCP_NODELAY set
* Connected to localhost (127.0.0.1) port 8000 (#1)
* Server auth using Basic with user 'admin'
> POST / HTTP/1.1
> Host: localhost:8000
> Authorization: Basic YWRtaW46MDMxNjAwMjU2MA==
> User-Agent: curl/7.68.0
> Accept: */*
> Content-Length: 29
> Content-Type: application/x-www-form-urlencoded
> 
* upload completely sent off: 29 out of 29 bytes
* Mark bundle as not supporting multiuse
< HTTP/1.1 200 OK
< Host: localhost:8000
< Date: Tue, 23 Nov 2021 13:40:52 GMT
< Connection: close
< X-Powered-By: PHP/7.4.3
< Content-type: text/html; charset=UTF-8
< 
[
    {
        "username": "filip",
        "password": "teletubbiesfan12345"
    },
    {
        "username": "ana",
        "password": "1ijedansu2"
    },
    {
        "username": "maja",
        "password": "hehehe"
    }
* Closing connection 1
] 


$ curl -v -u maja:hehehe http://localhost:8000/
*   Trying 127.0.0.1:8000...
* TCP_NODELAY set
* Connected to localhost (127.0.0.1) port 8000 (#0)
* Server auth using Basic with user 'maja'
> GET / HTTP/1.1
> Host: localhost:8000
> Authorization: Basic bWFqYTpoZWhlaGU=
> User-Agent: curl/7.68.0
> Accept: */*
> 
* Mark bundle as not supporting multiuse
< HTTP/1.1 200 OK
< Host: localhost:8000
< Date: Tue, 23 Nov 2021 13:42:05 GMT
< Connection: close
< X-Powered-By: PHP/7.4.3
< Content-type: text/html; charset=UTF-8
< 
<p>Pozdrav maja, uspješno ste se prijavili</p>
* Closing connection 0
```

## Zadatak 2

Osmislite vlastiti primjer poslužitelja (npr. OPG, teretana, prodaja maskica za mobitel, restoran ili kuglana s grillom) i omogućite da:

* klijent izvodi naručivanje proizvoda po identifikatoru korištenjem URL-a oblika `/naruci/720`, pri čemu se narudžba bilježi u kolačić ako proizvod s danim identifikatorom (ovdje 720) postoji, u protivnom odgovor ima statusni kod 404 Not Found i poruku po vašem izboru
* klijent pristupom URL-u `/narudzba` dobiva informacije o posljednjoj narudžbi, ako postoji zapis o njoj u kolačiću, u protivnom odgovor ima statusni kod 404 Not Found i poruku po vašem izboru

Za identifikatore u popisu prozvoda iskoristite redne brojeve s proizvoljnim početnim brojem, primjerice:

``` php
$proizvodi = [719 => "Tesla Model S", "Južni vjetar 2 DVD"];
// drugi element polja bit će dostupan kao $proizvodi[720]
```

Navedena praksa gdje se mali brojevi izbjegavaju za identifikatore je česta u web aplikacijama jer onemogućuje bugove kod kojih se količina proizvoda koju korisnik navede ili ukupan broj proizvoda u košarici koristi kao identifikator.

Za identifikatore u kolačićima iskoristite slučajne brojeve. Specifično:

* ako je vaš JMBAG neparan, za tu svrhu istkoristite funkciju `rand()` ([dokumentacija](https://www.php.net/manual/en/function.rand.php))
* ako je vaš JMBAG paran, za tu svrhu iskoristite funkciju `mt_rand()` ([dokumentacija](https://www.php.net/manual/en/function.mt-rand.php))

Radi jednostavnosti, ne morate specijalno paziti na situaciju u kojoj se generiranjem slučajnih brojeva dobije identifikator koji već postoji.

Isprobajte cURL-om razvijeni kod.

**Sadržaj datoteke index.php (ISPUNJAVA STUDENT):**

``` php
<?php
$proizvod = [719 => "Zelena Maskica", "Plava Maskica", "Crvena Maskica", "Crna Maskica", "Bijela Maskica"];
$request_headers = getallheaders();
$user_id = $request_headers["Authorization"];

if (isset($_SERVER["PHP_AUTH_USER"]) && isset($_SERVER["PHP_AUTH_PW"])) {
    $user = $_SERVER["PHP_AUTH_USER"];
    $pw = $_SERVER["PHP_AUTH_PW"];
    echo "<p>Pozdrav $user, unijeli ste $pw kao zaporku.</p>\n";

    if ($_SERVER["REQUEST_URI"] == "/naruci/720") {
        if (is_null($proizvod[720])){
            http_response_code(404);
            echo "<p>Proizvod 720 ne postoji.</p>\n";
        }
        else{
            setcookie($user_id, mt_rand(1000, 9999));
            setcookie($_COOKIE[$user_id], 720);
            echo "<p>Narucili ste $proizvod[720].</p>\n";
        }
    }
    else if($_SERVER["REQUEST_URI"] == '/narudzba'){
        if (array_key_exists($_COOKIE[$user_id], $_COOKIE)) {
            $prethodni_kolac = $orders[$_COOKIE[$_COOKIE[$user_id]]];
            echo "<p>Ranije ste naručili " . $prethodni_kolac . ".</p>\n";
        } 
        else {
            http_response_code(404);
            echo "<p>Nemate niti jednu spremljenu narudzbu.</p>\n";
        }
    } 
}
else {
    http_response_code(401);
    header("WWW-Authenticate: Basic realm=\"Tajni laboratorij Odjela za informatiku\"");
    echo "<p>Niste prijavljeni.</p>\n";
}
?>
```

**Provjera točnosti rada HTTP klijentom (ISPUNJAVA STUDENT):**

```
curl -v -u ana:1iedansu2 http://localhost:8000/naruci/720
*   Trying 127.0.0.1:8000...
* TCP_NODELAY set
* Connected to localhost (127.0.0.1) port 8000 (#0)
* Server auth using Basic with user 'ana'
> GET /naruci/720 HTTP/1.1
> Host: localhost:8000
> Authorization: Basic YW5hOjFpZWRhbnN1Mg==
> User-Agent: curl/7.68.0
> Accept: */*
> 
* Mark bundle as not supporting multiuse
< HTTP/1.1 200 OK
< Host: localhost:8000
< Date: Wed, 24 Nov 2021 00:23:15 GMT
< Connection: close
< X-Powered-By: PHP/7.4.3
< Content-type: text/html; charset=UTF-8
< 
<p>Pozdrav ana, unijeli ste 1iedansu2 kao zaporku.</p>
<p>Narucili ste Plava Maskica.</p>
* Closing connection 0

```
