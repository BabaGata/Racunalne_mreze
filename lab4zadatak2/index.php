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