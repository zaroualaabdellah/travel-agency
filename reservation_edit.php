<?php

$pageTitle = "Modifier Réservation";
include('includes/header.php');
include('includes/sidebar.php');

$conn = new mysqli("localhost", "root", "", "dbtravel");
if ($conn->connect_error) die("Erreur: " . $conn->connect_error);

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    header("Location: reservation.php");
    exit;
}

// Fetch clients for dropdown
$clientsRes = $conn->query("SELECT id_client, nom, prenom FROM Client ORDER BY nom, prenom");

// Fetch reservation info
$stmt = $conn->prepare("SELECT * FROM Reservation WHERE id_reservation = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$reservation = $stmt->get_result()->fetch_assoc();
if (!$reservation) {
    header("Location: reservation.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date_reservation = $_POST['date_reservation'] ?? null;
    $assurance_annulation = isset($_POST['assurance_annulation']) ? 1 : 0;
    $chambre_supplementaire = isset($_POST['chambre_supplementaire']) ? 1 : 0;
    $id_client = intval($_POST['id_client']);

    $stmtUpdate = $conn->prepare("UPDATE Reservation SET date_reservation = ?, assurance_annulation = ?, chambre_supplementaire = ?, id_client = ? WHERE id_reservation = ?");
    $stmtUpdate->bind_param("siiii", $date_reservation, $assurance_annulation, $chambre_supplementaire, $id_client, $id);

    if ($stmtUpdate->execute()) {
        header("Location: reservation.php");
        exit;
    } else {
        $error = "Erreur lors de la mise à jour : " . $stmtUpdate->error;
    }
}
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <h4><?= $pageTitle ?></h4>
  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>
  <form method="post" action="">
    <div class="mb-3">
      <label for="date_reservation" class="form-label">Date de réservation</label>
      <input type="date" id="date_reservation" name="date_reservation" required class="form-control" value="<?= htmlspecialchars($reservation['date_reservation']) ?>" />
    </div>
    <div class="form-check mb-3">
      <input type="checkbox" id="assurance_annulation" name="assurance_annulation" class="form-check-input" <?= $reservation['assurance_annulation'] ? 'checked' : '' ?> />
      <label for="assurance_annulation" class="form-check-label">Assurance annulation</label>
    </div>
    <div class="form-check mb-3">
      <input type="checkbox" id="chambre_supplementaire" name="chambre_supplementaire" class="form-check-input" <?= $reservation['chambre_supplementaire'] ? 'checked' : '' ?> />
      <label for="chambre_supplementaire" class="form-check-label">Chambre supplémentaire</label>
    </div>
    <div class="mb-3">
      <label for="id_client" class="form-label">Client</label>
      <select name="id_client" id="id_client" class="form-select" required>
        <option value="">-- Sélectionner un client --</option>
        <?php while ($client = $clientsRes->fetch_assoc()): ?>
          <option value="<?= $client['id_client'] ?>" <?= ($client['id_client'] == $reservation['id_client']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($client['nom'] . ' ' . $client['prenom']) ?>
          </option>
        <?php endwhile; ?>
      </select>
    </div>
    <button type="submit" class="btn btn-primary">Mettre à jour</button>
    <a href="reservation.php" class="btn btn-secondary">Annuler</a>
  </form>
</main>

<?php include('includes/footer.php'); ?>
