<?php

$pageTitle = "Liste des Réservations";
include('includes/header.php');
include('includes/sidebar.php');

$conn = new mysqli("sql202.infinityfree.com", "if0_39302602", "jT4CeZzfz4", "if0_39302602_dbtravel");
if ($conn->connect_error) die("Erreur: " . $conn->connect_error);

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    // Delete passager(s) linked to reservation first (if any)
    $conn->query("DELETE FROM passager WHERE id_reservation = $id");
    // Then delete the reservation itself
    $conn->query("DELETE FROM reservation WHERE id_reservation = $id");
    header("Location: reservation.php");
    exit;
}

$sql = "
SELECT r.id_reservation, r.date_reservation, r.assurance_annulation, r.chambre_supplementaire,
       c.nom AS client_nom, c.prenom AS client_prenom
FROM reservation r
JOIN client c ON r.id_client = c.id_client
ORDER BY r.id_reservation DESC
";

$result = $conn->query($sql);
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="topbar d-flex justify-content-between align-items-center">
    <h4><?= $pageTitle ?></h4>
    <a href="reservation_add.php" class="btn btn-primary btn-sm">Ajouter Réservation</a>
  </div>
  <div class="content mt-4">
    <table id="reservationTable" class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Date de réservation</th>
          <th>Assurance annulation</th>
          <th>Chambre supplémentaire</th>
          <th>Nom client</th>
          <th>Prénom client</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($r = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $r['id_reservation'] ?></td>
          <td><?= htmlspecialchars($r['date_reservation']) ?></td>
          <td><?= $r['assurance_annulation'] ? 'Oui' : 'Non' ?></td>
          <td><?= $r['chambre_supplementaire'] ? 'Oui' : 'Non' ?></td>
          <td><?= htmlspecialchars($r['client_nom']) ?></td>
          <td><?= htmlspecialchars($r['client_prenom']) ?></td>
          <td>
            <a href="reservation_edit.php?id=<?= $r['id_reservation'] ?>" class="btn btn-warning btn-sm">Modifier</a>
            <a href="?delete=<?= $r['id_reservation'] ?>" onclick="return confirm('Supprimer cette réservation ?')" class="btn btn-danger btn-sm">Supprimer</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</main>

<?php include('includes/footer.php'); ?>
