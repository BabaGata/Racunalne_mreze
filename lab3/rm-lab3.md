# Računalne mreže: laboratorijska vježba 3

## Zadatak 1

Napravite datoteku `index.php` tako da:

* poslužitelj prima datoteke metodom POST i sprema ih pod imenom koji je naveo korisnik,
* poslužitelj prima datoteke metodom PUT i sprema ih pod imenom po vašem izboru.

U oba slučaja datoteke se spremaju u poddirektorij radnog direktorija web poslužitelja čije je ime broj sekundi koje su prošle od 1. siječnja 1970. do sadašnjeg trenutka. (**Uputa:** proučite funkciju `time()`, [dokumentacija](https://www.php.net/manual/en/function.time.php).)

Omogućite brisanje datoteka metodom DELETE, ali tako da zaštite datoteku `index.php` od brisanja.

Isprobajte cURL-om razvijeni kod.

**Sadržaj datoteke index.php (ISPUNJAVA STUDENT):**

``` php

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

``` php

```

**Provjera točnosti rada HTTP klijentom (ISPUNJAVA STUDENT):**

``` shell

```
