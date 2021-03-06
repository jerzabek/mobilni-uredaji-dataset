<?php include 'auth0.php'; ?>
<!DOCTYPE html>
<html lang="en" prefix="schemaorg: https://schema.org/">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Meta data -->
  <meta name="description" content="Otvoreni skup podataka koji opisuje mobilne uređaje">
  <meta name="keywords" content="linked data, open data, phones, dataset, mobilni uređaju, skup podataka">
  <meta name="author" content="Ivan Jeržabek">

  <meta property="og:title" content="Mobilni uređaji dataset" />
  <meta property="og:type" content="schemaorg:Dataset" />

  <title>Mobilni uređaji dataset</title>

  <!-- Styles -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>

<body>
  <?php
  $current_page = HOMEPAGE;

  include 'header.php';
  ?>
  <main>
    <div class="container my-md-5 my-1">
      <h1 class="mb-4" id="skup-otvorenih-podataka-o-mobilnim-ureajima">Skup otvorenih podataka o mobilnim uređajima
      </h1>
      <p><a href="http://creativecommons.org/licenses/by/4.0/"><img src="https://img.shields.io/badge/License-CC%20BY%204.0-lightgrey.svg" alt="CC BY 4.0" /></a></p>
      <p>This work is licensed under a<br /><a href="http://creativecommons.org/licenses/by/4.0/">Creative Commons
          Attribution 4.0 International License</a>.</p>
      <p><a href="http://creativecommons.org/licenses/by/4.0/"><img src="https://i.creativecommons.org/l/by/4.0/88x31.png" alt="CC BY 4.0" /></a></p>
      <h2 class="mb-3" id="podaci-o-skupu">Podaci o skupu:</h2>
      <p><b>Autor:</b> Ivan Jeržabek</p>
      <p><b>Verzija:</b> 1.0</p>
      <p><b>Jezik:</b> engleski</p>

      <h2 class="mb-3" id="preuzimanje">Preuzimanje</h2>
      <p>Skup podataka je dostupan u dva formata:</p>
      <ul>
        <li class="mb-2"><a class="btn btn-success" href="fer_2122_or_mobilni_uredaji.csv"><i class="bi bi-cloud-arrow-down"></i> CSV</a></li>
        <li><a class="btn btn-success" href="fer_2122_or_mobilni_uredaji.json"><i class="bi bi-cloud-arrow-down"></i> JSON</a></li>
      </ul>

      <h2 class="mb-3" id="samostalno-pokretanje">Samostalno pokretanje</h2>
      <p>Unutar repozitorija se nalazi MySQL dump baze podataka. Pomoću nje je moguće uređivati same podatke te kasnije
        mijenjati skup podataka.</p>
      <p>Unutar repozitorija se također nalaze CSV i JSON datoteke koje predstavljaju trenutni sadržaj skupa podataka.
      </p>
      <p>Skripta <code>dump.php</code> generira CSV te JSON reprezentaciju podataka u bazi. U slučaju mijenjanja
        strukture
        baze podataka obavezna je provjera valjanosti skripte.</p>
      <h2 class="mb-3" id="opis-atributa-u-skupu">Opis atributa u skupu</h2>
      <h3 class="mt-4" id="mobitel">Mobitel</h3>
      <table class="table table-hover">
        <thead>
          <tr class="header">
            <th align="left">Naziv</th>
            <th align="left">Opis</th>
            <th align="left">Tip podatka</th>
          </tr>
        </thead>
        <tbody>
          <tr class="odd">
            <td align="left">name</td>
            <td align="left">Naziv mobilnog uređaja</td>
            <td align="left">Tekst (200 znakova)</td>
          </tr>
          <tr class="even">
            <td align="left">release_date</td>
            <td align="left">Datum izlaska uređaja na tržište</td>
            <td align="left">Datum (format yyyy-mm-dd)</td>
          </tr>
          <tr class="odd">
            <td align="left">width</td>
            <td align="left">Širina uređaja u milimetrima</td>
            <td align="left">Decimalni broj</td>
          </tr>
          <tr class="even">
            <td align="left">height</td>
            <td align="left">Visina uređaja u milimetrima</td>
            <td align="left">Decimalni broj</td>
          </tr>
          <tr class="odd">
            <td align="left">thickness</td>
            <td align="left">Debljina uređaja u milimetrima</td>
            <td align="left">Decimalni broj</td>
          </tr>
          <tr class="even">
            <td align="left">screen_size</td>
            <td align="left">Veličina ekrana u inchevima</td>
            <td align="left">Decimalni broj</td>
          </tr>
          <tr class="odd">
            <td align="left">vertical_resolution</td>
            <td align="left">Vertikalna rezolucija ekrana u pikselima</td>
            <td align="left">Broj</td>
          </tr>
          <tr class="even">
            <td align="left">horizontal_resolution</td>
            <td align="left">Horizontalna rezolucija ekrana u pikselima</td>
            <td align="left">Broj</td>
          </tr>
          <tr class="odd">
            <td align="left">charging_port</td>
            <td align="left">Poveznica na tip utora</td>
            <td align="left">ID</td>
          </tr>
          <tr class="even">
            <td align="left">headphone_jack</td>
            <td align="left">Postoji li prikjučak za 3.5mm audio</td>
            <td align="left">Boolean</td>
          </tr>
          <tr class="odd">
            <td align="left">microsd</td>
            <td align="left">Postoji li utor za dodatnu pohranu</td>
            <td align="left">Boolean</td>
          </tr>
          <tr class="even">
            <td align="left">wireless_charging</td>
            <td align="left">Postoji li mogućnost za bežićno punjenje</td>
            <td align="left">Boolean</td>
          </tr>
        </tbody>
      </table>
      <h3 class="mt-4" id="tvrtka">Tvrtka</h3>
      <table class="table table-hover">
        <thead>
          <tr class="header">
            <th align="left">Naziv</th>
            <th align="left">Opis</th>
            <th align="left">Tip podatka</th>
          </tr>
        </thead>
        <tbody>
          <tr class="odd">
            <td align="left">brand</td>
            <td align="left">Naziv tvrtke</td>
            <td align="left">Tekst (200 znakova)</td>
          </tr>
        </tbody>
      </table>
      <h3 class="mt-4" id="procesor">Procesor</h3>
      <table class="table table-hover">
        <thead>
          <tr class="header">
            <th align="left">Naziv</th>
            <th align="left">Opis</th>
            <th align="left">Tip podatka</th>
          </tr>
        </thead>
        <tbody>
          <tr class="odd">
            <td align="left">name</td>
            <td align="left">Naziv procesora</td>
            <td align="left">Tekst (200 znakova)</td>
          </tr>
          <tr class="even">
            <td align="left">cores</td>
            <td align="left">Broj fizičkih jezgri procesora</td>
            <td align="left">Broj (&lt; 127)</td>
          </tr>
          <tr class="odd">
            <td align="left">clock_speed</td>
            <td align="left">Brzina procesora u GHz (gigahertz)</td>
            <td align="left">Decimalni broj</td>
          </tr>
          <tr class="even">
            <td align="left">brand</td>
            <td align="left">Poveznica na tvrtku</td>
            <td align="left">ID</td>
          </tr>
        </tbody>
      </table>
      <h3 class="mt-4" id="kamera">Kamera</h3>
      <table class="table table-hover">
        <thead>
          <tr class="header">
            <th align="left">Naziv</th>
            <th align="left">Opis</th>
            <th align="left">Tip podatka</th>
          </tr>
        </thead>
        <tbody>
          <tr class="odd">
            <td align="left">description</td>
            <td align="left">Kratak opis kamere</td>
            <td align="left">Tekst (100 znakova)</td>
          </tr>
          <tr class="even">
            <td align="left">horizontal_resolution</td>
            <td align="left">Horizontalna rezolucija ekrana u pikselima</td>
            <td align="left">Broj</td>
          </tr>
          <tr class="odd">
            <td align="left">vertical_resolution</td>
            <td align="left">Vertikalna rezolucija ekrana u pikselima</td>
            <td align="left">Broj</td>
          </tr>
          <tr class="even">
            <td align="left">resolution</td>
            <td align="left">Rezolucija kamere u megapikselima</td>
            <td align="left">Broj</td>
          </tr>
          <tr class="odd">
            <td align="left">apature</td>
            <td align="left">Otvorenost kamere</td>
            <td align="left">Tekst (100 znakova)</td>
          </tr>
          <tr class="even">
            <td align="left">position</td>
            <td align="left">Poveznica na lokaciju kamere na uređaju</td>
            <td align="left">ID</td>
          </tr>
        </tbody>
      </table>
      <h3 class="mt-4" id="lokacija-kamere-na-ureaju">Lokacija kamere na uređaju</h3>
      <table class="table table-hover">
        <thead>
          <tr class="header">
            <th align="left">Naziv</th>
            <th align="left">Opis</th>
            <th align="left">Tip podatka</th>
          </tr>
        </thead>
        <tbody>
          <tr class="odd">
            <td align="left">position</td>
            <td align="left">Opis lokacije na uređaju</td>
            <td align="left">Tekst (200 znakova)</td>
          </tr>
        </tbody>
      </table>
      <h3 class="mt-4" id="tip-utora">Tip utora</h3>
      <table class="table table-hover">
        <thead>
          <tr class="header">
            <th align="left">Naziv</th>
            <th align="left">Opis</th>
            <th align="left">Tip podatka</th>
          </tr>
        </thead>
        <tbody>
          <tr class="odd">
            <td align="left">name</td>
            <td align="left">Tip utora</td>
            <td align="left">Tekst (200 znakova)</td>
          </tr>
        </tbody>
      </table>
    </div>
  </main>
</body>

</html>