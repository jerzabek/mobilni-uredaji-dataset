<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Uključi navigaciju">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav w-100">
        <li class="nav-item">
          <a class="nav-link <?php echo $current_page === HOMEPAGE ? "active" : ""; ?>" aria-current="page" href="/">Početna</a>
        </li>
        <li class="nav-item me-auto">
          <a class="nav-link <?php echo $current_page === DATATABLE ? "active" : ""; ?>" aria-current="page" href="/datatable">Filtriraj...</a>
        </li>
        <?php if ($session === null) : ?>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="/login.php">Prijava</a>
          </li>
        <?php else : ?>
          <li class="nav-item">
            <a class="nav-link <?php echo $current_page === PROFILE ? "active" : ""; ?>" aria-current="page" href="/profile">Profil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="/logout">Odjava</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>