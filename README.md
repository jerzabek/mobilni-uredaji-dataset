# Skup otvorenih podataka o mobilnim uređajima


[![CC BY 4.0][cc-by-shield]][cc-by]

This work is licensed under a
[Creative Commons Attribution 4.0 International License][cc-by].

[![CC BY 4.0][cc-by-image]][cc-by]

[cc-by]: http://creativecommons.org/licenses/by/4.0/
[cc-by-image]: https://i.creativecommons.org/l/by/4.0/88x31.png
[cc-by-shield]: https://img.shields.io/badge/License-CC%20BY%204.0-lightgrey.svg

## Podaci o skupu:
<b>Autor:</b> Ivan Jeržabek

<b>Verzija:</b> 1.0

<b>Jezik:</b> engleski

## Samostalno pokretanje

### Dump podataka
Unutar repozitorija se nalazi MySQL dump baze podataka. Pomoću nje je moguće uređivati same podatke te kasnije mijenjati skup podataka.

Unutar repozitorija se također nalaze CSV i JSON datoteke koje predstavljaju trenutni sadržaj skupa podataka.

Skripta `dump.php` generira CSV te JSON reprezentaciju podataka u bazi. U slučaju mijenjanja strukture baze podataka obavezna je provjera valjanosti skripte.


### Frontend

Preporuča se korištenje web servera poput NGINX, u kojem slučaju je preporučeno osigurati zabranu pristupa datotekama poput `constants.php` koje sadrže tajne podatke.

Datoteku `constants.php.example` treba preimenovati `constants.php` te prilagoditi varijable unutar datoteke njihovom okruženju. Za autentifikaciju korišten je sustav Auth0 za koji je potrebno osigurati potrebne konfiguracijske ključeve i tajne vrijednosti.

Sve osim mape *api* je potrebno za rad frontend sučelja.

Konačno potrebno je instalirati potrebne ovisnosti naredbom:

```
composer install
```

### Backend

API sustav je izgrađen u jeziku Python koristeći Flask biblioteku. Prije pokretanja bitno je preimenovati datoteku `or_api.cfg.example` u `or_api.cfg` te prilagoditi vrijednosti varijabli njihovom okruženju.

Preporuča se pokretanje korištenjem Gunicorn okvira naredbom:

```
gunicorn --config gunicorn_config.py
```

API sučelje je dokumentirano OpenAPI specifikacijom, koju je moguće istražiti kroz [SwaggerUI sučelje na ovoj poveznici](https://or.jarza.cc/docs).
## Opis atributa u skupu

### Mobitel

| Naziv | Opis | Tip podatka |
| --- | --- | --- |
| name | Naziv mobilnog uređaja| Tekst (200 znakova) |
| release_date | Datum izlaska uređaja na tržište | Datum (format yyyy-mm-dd) |
| width | Širina uređaja u milimetrima | Decimalni broj |
| height | Visina uređaja u milimetrima | Decimalni broj |
| thickness | Debljina uređaja u milimetrima | Decimalni broj |
| screen_size | Veličina ekrana u inchevima | Decimalni broj |
| vertical_resolution | Vertikalna rezolucija ekrana u pikselima | Broj |
| horizontal_resolution | Horizontalna rezolucija ekrana u pikselima | Broj |
| charging_port | Poveznica na tip utora | ID |
| headphone_jack | Postoji li prikjučak za 3.5mm audio | Boolean |
| microsd | Postoji li utor za dodatnu pohranu | Boolean |
| wireless_charging | Postoji li mogućnost za bežićno punjenje | Boolean |

### Tvrtka

| Naziv | Opis | Tip podatka |
| --- | --- | --- |
| brand | Naziv tvrtke | Tekst (200 znakova) |

### Procesor

| Naziv | Opis | Tip podatka |
| --- | --- | --- |
| name | Naziv procesora | Tekst (200 znakova) |
| cores | Broj fizičkih jezgri procesora | Broj (< 127) |
| clock_speed | Brzina procesora u GHz (gigahertz) | Decimalni broj |
| brand | Poveznica na tvrtku | ID |

### Kamera

| Naziv | Opis | Tip podatka |
| --- | --- | --- |
| description | Kratak opis kamere | Tekst (100 znakova) |
| horizontal_resolution | Horizontalna rezolucija ekrana u pikselima | Broj |
| vertical_resolution | Vertikalna rezolucija ekrana u pikselima | Broj |
| resolution | Rezolucija kamere u megapikselima | Broj |
| apature | Otvorenost kamere | Tekst (100 znakova) |
| position | Poveznica na lokaciju kamere na uređaju | ID |

### Lokacija kamere na uređaju

| Naziv | Opis | Tip podatka |
| --- | --- | --- |
| position | Opis lokacije na uređaju | Tekst (200 znakova) |

### Tip utora

| Naziv | Opis | Tip podatka |
| --- | --- | --- |
| name | Tip utora | Tekst (200 znakova) |