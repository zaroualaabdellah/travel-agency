<div class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 250px; height: 100vh; position: fixed; overflow-y: auto;">
  <a href="index.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-decoration-none">
    <span class="fs-5 fw-semibold">
      <img src="image/images.png">
    </span>
  </a>
  <hr>
  <ul class="nav nav-pills flex-column mb-auto">
    <li class="nav-item">
      <a href="index.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : 'link-dark' ?>">
        🏠 Dashboard
      </a>
    </li>
    <li><a href="pays.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'pays.php' ? 'active' : 'link-dark' ?>">🌍 pays</a></li>
    <li><a href="region.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'region.php' ? 'active' : 'link-dark' ?>">🗺️ Régions</a></li>
    <li><a href="departement.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'departement.php' ? 'active' : 'link-dark' ?>">🏞️ Départements</a></li>
    <li><a href="ville.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'ville.php' ? 'active' : 'link-dark' ?>">🏘️ Villes</a></li>
    <li><a href="client.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'client.php' ? 'active' : 'link-dark' ?>">👤 Clients</a></li>
    <li><a href="reservation.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'reservation.php' ? 'active' : 'link-dark' ?>">📅 Réservations</a></li>
    <li class="nav-item"> <a href="passager.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'passager.php' ? 'active' : 'link-dark' ?>">🧳 Passagers</a> </li>
    <li> <a href="typeautocar.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'typeautocar.php' ? 'active' : 'link-dark' ?>">🚍 Types d'autocar</a> </li>
    <li> <a href="autocar.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'autocar.php' ? 'active' : 'link-dark' ?>">🚌 Autocars</a> </li>
    <li> <a href="emplacement.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'emplacement.php' ? 'active' : 'link-dark' ?>">💺 Emplacements</a> </li>
    <li>
    <a href="hotel.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'hotel.php' ? 'active' : 'link-dark' ?>">🏨 Hôtels</a>
    </li>
    <li>
    <a href="voyage.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'voyage.php' ? 'active' : 'link-dark' ?>">✈️ Voyages</a>
    </li>
    <li>
        <a href="programmation.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'programmation.php' ? 'active' : 'link-dark' ?>">🕒 programmation</a>
        </li>
    <li>
    <a href="pointdepart.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'pointdepart.php' ? 'active' : 'link-dark' ?>">📍 Point de départ</a>
    </li>

    <li><a href="utilisateur.php" class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'utilisateur.php' ? 'active' : 'link-dark' ?>">🔐 Utilisateurs</a></li>
 
  </ul>
  <hr>
  <div>
    <a href="logout.php" class="btn btn-outline-danger btn-sm w-100">🚪 Déconnexion</a>
  </div>
</div>
