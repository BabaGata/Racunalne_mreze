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