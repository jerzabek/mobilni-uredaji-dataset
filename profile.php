<?php
include 'auth0.php';
is_authorized($session, $auth0);

$show_modal = false;

if (!empty($_GET['refresh'])) {
  // We must refresh the files on disk.
  include 'dump.php';
  header("Location: " . APP_PROFILE_PAGE . "?success=1");
  exit;
} else if (!empty($_GET['success'])) {
  $show_modal = true;
}

?>
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

  <title>Filteri - Mobilni uređaji dataset</title>

  <!-- Styles & Scripts-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/air-datepicker@3.0.1/air-datepicker.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/air-datepicker@3.0.1/air-datepicker.min.css">

  <script src="/assets/js/jquery-3.6.0.min.js"></script>

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" />
  <script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>

  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    .search-type-text,
    .search-type-number,
    .search-type-date,
    .search-type-boolean,
    .search-type-select {
      display: none;
    }

    #data tbody tr {
      white-space: nowrap;
    }
  </style>
</head>

<body>
  <?php
  $current_page = PROFILE;

  include 'header.php';
  ?>
  <main>
    <?php if ($show_modal) : ?>
      <div class="modal fade" id="notifModal" tabindex="-1" aria-labelledby="notifModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="notifModalLabel">Preslike uspješno pohranjene!</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Uredu</button>
            </div>
          </div>
        </div>
      </div>
      <button type="button" id="modalToggle" style="display:none" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#notifModal"></button>
      <script>
        (function() {
          document.getElementById("modalToggle").click();
        })();
      </script>
    <?php endif; ?>
    <div class="container my-md-5 my-1">
      <div class="row">
        <div class="col-12 col-sm-4 col-md-2">
          <img src="<?php echo $session->user["picture"]; ?>" alt="Profile picture" class="img-thumbnail">
        </div>
        <div class="col-12 col-sm-8 col-md-10">
          <h1><?php echo $session->user["name"]; ?></h1>
          <p class="text-muted"><?php echo $session->user["nickname"]; ?></p>
        </div>
      </div>
      <hr />
      <h2>Osvježavanje preslike</h2>
      <p>Ova funkcionalnost osvježava CSV i JSON datoteke dataset-a koje korisnik preuzima na početnoj stranici.</p>
      <a href="/profile?refresh=1" class="btn btn-success">Osvježi preslike</a>
    </div>
  </main>
</body>

</html>