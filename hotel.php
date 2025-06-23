<?php
$pageTitle = "Liste des Hôtels";
include('includes/header.php');
include('includes/sidebar.php');

$conn = new mysqli("localhost", "root", "", "dbtravel");
if ($conn->connect_error) die("Erreur: " . $conn->connect_error);

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM Hotel WHERE id_hotel = $id");
    header("Location: hotel.php");
    exit;
}

$result = $conn->query("
  SELECT h.id_hotel, h.nom, h.adresse, v.nom AS ville
  FROM Hotel h
  LEFT JOIN Ville v ON h.id_ville = v.id_ville
  ORDER BY h.id_hotel DESC
");
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="topbar d-flex justify-content-between align-items-center">
    <h4><?= $pageTitle ?></h4>
    <a href="hotel_add.php" class="btn btn-primary btn-sm">Ajouter un Hôtel</a>
  </div>

  <div class="content mt-4">
    <table id="hotelTable" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nom</th>
          <th>Adresse</th>
          <th>Ville</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id_hotel'] ?></td>
          <td><?= htmlspecialchars($row['nom']) ?></td>
          <td><?= htmlspecialchars($row['adresse']) ?></td>
          <td><?= htmlspecialchars($row['ville']) ?></td>
          <td>
            <a href="hotel_edit.php?id=<?= $row['id_hotel'] ?>" class="btn btn-warning btn-sm">Modifier</a>
            <a href="?delete=<?= $row['id_hotel'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cet hôtel ?')">Supprimer</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</main>

<?php include('includes/footer.php'); ?>
