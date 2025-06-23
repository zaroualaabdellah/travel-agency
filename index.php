<?php
$pageTitle = "Dashboard";
include('includes/header.php');
include('includes/sidebar.php');

$pdo = new PDO('mysql:host=localhost;dbname=dbtravel;charset=utf8mb4', 'root', '');

$stats = [];
$tables = ['client', 'reservation', 'voyage', 'autocar', 'passager'];
foreach ($tables as $table) {
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM $table");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $stats[$table] = $result['count'];
}
?>

<!-- Main Content -->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="topbar d-flex justify-content-between align-items-center">
    <h4><?php echo $pageTitle; ?></h4>
    <div>
      <span>Welcome, User</span>
      <a href="#" class="btn btn-sm btn-outline-secondary">Logout</a>
    </div>
  </div>

  <div class="content mt-4">
    <div class="row g-3">
      <div class="col-md-3">
        <div class="card text-white bg-primary">
          <div class="card-body">
            <h5 class="card-title">
              <i class="bi bi-people-fill me-2"></i>Clients
            </h5>
            <p class="card-text fs-3"><?= $stats['client'] ?></p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-white bg-success">
          <div class="card-body">
            <h5 class="card-title">
              <i class="bi bi-journal-check me-2"></i>Reservations
            </h5>
            <p class="card-text fs-3"><?= $stats['reservation'] ?></p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-white bg-warning">
          <div class="card-body">
            <h5 class="card-title">
              <i class="bi bi-geo-alt-fill me-2"></i>Voyages
            </h5>
            <p class="card-text fs-3"><?= $stats['voyage'] ?></p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-white bg-danger">
          <div class="card-body">
            <h5 class="card-title">
              <i class="bi bi-bus-front-fill me-2"></i>Autocars
            </h5>
            <p class="card-text fs-3"><?= $stats['autocar'] ?></p>
          </div>
        </div>
      </div>
      <div class="col-md-3 mt-3">
        <div class="card text-white bg-info">
          <div class="card-body">
            <h5 class="card-title">
              <i class="bi bi-person-badge-fill me-2"></i>Passagers
            </h5>
            <p class="card-text fs-3"><?= $stats['passager'] ?></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<?php include('includes/footer.php'); ?>
