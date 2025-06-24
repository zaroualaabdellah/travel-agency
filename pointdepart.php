<?php

$pageTitle = "Liste des Points de Départ";
include('includes/header.php');
include('includes/sidebar.php');

$conn = new mysqli("sql202.infinityfree.com", "if0_39302602", "jT4CeZzfz4", "if0_39302602_dbtravel");
if ($conn->connect_error) die("Erreur: " . $conn->connect_error);

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    // Delete linked programmation_pointdepart rows first (FK constraint)
    $conn->query("DELETE FROM Programmation_PointDepart WHERE id_point_depart = $id");
    // Then delete pointdepart
    $conn->query("DELETE FROM pointdepart WHERE id_point_depart = $id");
    header("Location: pointdepart.php");
    exit;
}

// Fetch points with city names (join ville)
$sql = "
SELECT p.id_point_depart, p.lieu, v.nom AS ville_nom
FROM pointdepart p
JOIN ville v ON p.id_ville = v.id_ville
ORDER BY p.id_point_depart DESC
";
$result = $conn->query($sql);
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="topbar d-flex justify-content-between align-items-center">
    <h4><?= $pageTitle ?></h4>
    <a href="pointdepart_add.php" class="btn btn-primary btn-sm">Ajouter Point de Départ</a>
  </div>

  <div class="content mt-4">
    <table id="pointdepartTable" class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Lieu</th>
          <th>ville</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id_point_depart'] ?></td>
          <td><?= htmlspecialchars($row['lieu']) ?></td>
          <td><?= htmlspecialchars($row['ville_nom']) ?></td>
          <td>
            <a href="pointdepart_edit.php?id=<?= $row['id_point_depart'] ?>" class="btn btn-warning btn-sm">Modifier</a>
            <a href="?delete=<?= $row['id_point_depart'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce point de départ ?')">Supprimer</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</main>

<?php include('includes/footer.php'); ?>
