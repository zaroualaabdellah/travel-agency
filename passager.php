<?php
session_start();
if (!isset($_SESSION['user'])) header('Location: login.php');

$pageTitle = "Liste des Passagers";
include('includes/header.php');
include('includes/sidebar.php');

$conn = new mysqli("localhost", "root", "", "dbtravel");
if ($conn->connect_error) die("Erreur: " . $conn->connect_error);

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM Passager WHERE id_passager = $id");
    header("Location: passager.php");
    exit;
}

$sql = "
SELECT p.id_passager, p.nom, p.prenom, p.telephone, r.id_reservation, r.date_reservation, c.nom AS client_nom, c.prenom AS client_prenom,
       e.numero AS emplacement_numero
FROM Passager p
JOIN Reservation r ON p.id_reservation = r.id_reservation
JOIN Client c ON r.id_client = c.id_client
JOIN Emplacement e ON p.id_emplacement = e.id_emplacement
ORDER BY p.id_passager DESC
";
$result = $conn->query($sql);
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="topbar d-flex justify-content-between align-items-center">
    <h4><?= $pageTitle ?></h4>
    <a href="passager_add.php" class="btn btn-primary btn-sm">Ajouter Passager</a>
  </div>
  <div class="content mt-4">
    <table id="passagerTable" class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nom</th>
          <th>Prénom</th>
          <th>Téléphone</th>
          <th>Réservation (ID)</th>
          <th>Client</th>
          <th>Date réservation</th>
          <th>Emplacement (N°)</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($p = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $p['id_passager'] ?></td>
          <td><?= htmlspecialchars($p['nom']) ?></td>
          <td><?= htmlspecialchars($p['prenom']) ?></td>
          <td><?= htmlspecialchars($p['telephone']) ?></td>
          <td><?= $p['id_reservation'] ?></td>
          <td><?= htmlspecialchars($p['client_nom'] . ' ' . $p['client_prenom']) ?></td>
          <td><?= htmlspecialchars($p['date_reservation']) ?></td>
          <td><?= htmlspecialchars($p['emplacement_numero']) ?></td>
          <td>
            <a href="passager_edit.php?id=<?= $p['id_passager'] ?>" class="btn btn-warning btn-sm">Modifier</a>
            <a href="?delete=<?= $p['id_passager'] ?>" onclick="return confirm('Supprimer ce passager ?')" class="btn btn-danger btn-sm">Supprimer</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</main>

<?php include('includes/footer.php'); ?>
