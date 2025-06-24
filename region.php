<?php
$pageTitle = "Liste des Régions";
include('includes/header.php');
include('includes/sidebar.php');

$conn = new mysqli("sql202.infinityfree.com", "if0_39302602", "jT4CeZzfz4", "if0_39302602_dbtravel");
if ($conn->connect_error) die("Erreur: " . $conn->connect_error);

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM region WHERE id_region = $id");
    header("Location: region.php");
    exit;
}

$result = $conn->query("
  SELECT r.id_region, r.nom AS nom_region, p.nom AS nom_pays
  FROM region r
  JOIN pays p ON r.id_pays = p.id_pays
  ORDER BY r.id_region DESC
");
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="topbar d-flex justify-content-between align-items-center">
    <h4><?php echo $pageTitle; ?></h4>
    <a href="region_add.php" class="btn btn-primary btn-sm">Ajouter une Région</a>
  </div>

  <div class="content mt-4">
    <table id="regionTable" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nom de la Région</th>
          <th>pays</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id_region'] ?></td>
          <td><?= htmlspecialchars($row['nom_region']) ?></td>
          <td><?= htmlspecialchars($row['nom_pays']) ?></td>
          <td>
            <a href="region_edit.php?id=<?= $row['id_region'] ?>" class="btn btn-warning btn-sm">Modifier</a>
            <a href="?delete=<?= $row['id_region'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cette région ?')">Supprimer</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</main>

<?php include('includes/footer.php'); ?>
