# Računalne mreže: laboratorijska vježba 3

## Zadatak 1

Napravite datoteku `index.php` tako da:

* poslužitelj prima datoteke metodom POST i sprema ih pod imenom koji je naveo korisnik,
* poslužitelj prima datoteke metodom PUT i sprema ih pod imenom po vašem izboru.

U oba slučaja datoteke se spremaju u poddirektorij radnog direktorija web poslužitelja čije je ime broj sekundi koje su prošle od 1. siječnja 1970. do sadašnjeg trenutka. (**Uputa:** proučite funkciju `time()`, [dokumentacija](https://www.php.net/manual/en/function.time.php).)

Omogućite brisanje datoteka metodom DELETE, ali tako da zaštite datoteku `index.php` od brisanja.

Isprobajte cURL-om razvijeni kod.

**Sadržaj datoteke index.php (ISPUNJAVA STUDENT):**

``` 
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



```

**Provjera točnosti rada HTTP klijentom (ISPUNJAVA STUDENT):**

``` shell

```

## Zadatak 2

Osmislite vlastiti primjer poslužitelja (npr. stanje na cestama, vremenska prognoza, web shop) koji vraća informacije po vašoj želji na zadanom jeziku (npr. engleski) i dva dodatna jezika (npr. hrvatski i makedonski).

Napravite datoteku `index.php` tako da od klijenta prihvaća zahtjev koji navodi jezike s kvalitetom razumijevanja i vraća odgovor:

* na jeziku koji najbolje razumije, ako se taj jezik nalazi među podržanim jezicima,
* na zadanom jeziku, ako je klijent naveo `*` s kvalitetom razumijevanja većom od 0,
* sa statusnim kodom 406 Not Acceptable, inače.

Ako klijent navede da prihvaća kodiranje (komprimiranje) sadržaja Gzip-om s kvalitetom većom od 0, poslužitelj sadržaj šalje komprimiran Gzip-om, u protivnom šalje nekomprimiran.

Isprobajte cURL-om razvijeni kod.

``` <?php

$languages = $_SERVER["HTTP_ACCEPT_LANGUAGE"];
$languages_split = explode(",", $languages);
$languages_trimmed = array_map("trim", $languages_split);

$languages_to_quality = [];
foreach ($languages_trimmed as $language_item) 
{
    $language_quality_pair = explode(";", $language_item);
    if (count($language_quality_pair) == 2) 
    {
        $language = $language_quality_pair[0];
        $quality = (float) substr($language_quality_pair[1], 3);
        if (strpos($language_quality_pair[1], '*') && $quality > 0)
        {
            $languages_to_quality[$language]=1.1;
        }
        else
        {
            $languages_to_quality[$language] = $quality;
        }
    }
    else 
    {
        $languages_to_quality[$language_item] = 1.0;
    }
}

arsort($languages_to_quality);

foreach ($languages_to_quality as $language => $quality) {
    if ($language == "hr") {
        header("Content-Language: hr");
        echo "<p>Ovo je hrvatski jezik!</p>\n";
        exit;
    } elseif ($language == "en") {
        header("Content-Language: en");
        echo "<p>This is a english language!</p>\n";
        exit;
    } elseif ($language == "mk") {
        header("Content-Language: mk");
        echo "<p>Ова е Македонец. !</p>\n";
        exit;
    } 
}
http_response_code(406);
echo "<p>Poslani popis jezika nije prihvatljiv.</p>\n";

$encodings = $_SERVER["HTTP_ACCEPT_ENCODING"];
$encodings_split = explode(",", $encodings);
$encodings_trimmed = array_map("trim", $encodings_split);

$contents = "<p>Ovo je čitav sadržaj koji će biti poslan klijentu.</p>\n";
if (in_array("gzip", $encodings_trimmed)) 
{
    header('Content-Encoding: gzip');
    $contents_compressed = gzencode($contents);
    echo $contents_compressed;
}
else if(in_array("identity;q=0", $encodings_trimmed) || in_array("*;q=0", $encodings_trimmed)) 
{
    http_response_code(200);
    echo $contents;
}

```

**Provjera točnosti rada HTTP klijentom (ISPUNJAVA STUDENT):**

``` shell

```