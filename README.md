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
Unutar repozitorija se nalazi MySQL dump baze podataka. Pomoću nje je moguće uređivati same podatke te kasnije mijenjati skup podataka.

Unutar repozitorija se također nalaze CSV i JSON datoteke koje predstavljaju trenutni sadržaj skupa podataka.

Skripta `dump.php` generira CSV te JSON reprezentaciju podataka u bazi. U slučaju mijenjanja strukture baze podataka obavezna je provjera valjanosti skripte.

## Opis podataka u skupu
Atributi skupa:

* name - Naziv mobilnog uređaja
* release_date - Datum izlaska uređaja na tržište (format yyyy-mm-dd)
* brand - Naziv tvrtke
* processor - Podaci o procesoru uređaja
  * name - Naziv procesora
  * cores - Broj fizičkih jezgri procesora
  * clock_speed - Brzina procesora u GHz (gigahertz)
  * brand - Proizvođač procesora
* width - Širina uređaja u milimetrima
* height - Visina uređaja u milimetrima
* thickness - Debljina uređaja u milimetrima
* screen_size - Veličina ekrana u inchevima
* vertical_resolution - Vertikalna rezolucija ekrana u pikselima
* horizontal_resolution - Horizontalna rezolucija ekrana u pikselima
* charging_port - Tip priključka za punjenje
* headphone_jack - Postoji li prikjučak za 3.5mm audio
* microsd - Postoji li utor za dodatnu pohranu
* wireless_charging - Postoji li mogućnost za bežićno punjenje
* cameras - Opis kamera na uređaju, ako one postoje
    * description - Kratak opis kamere
    * horizontal_resolution - Horizontalna rezolucija ekrana u pikselima
    * vertical_resolution - Vertikalna rezolucija ekrana u pikselima
    * resolution - Rezolucija kamere u megapikselima
    * apature - Otvorenost kamere
    * position - Lokacija kamere na uređaju