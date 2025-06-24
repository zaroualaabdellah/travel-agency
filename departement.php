<?php
$pageTitle = "Liste des Départements";
include('includes/header.php');
include('includes/sidebar.php');

$conn = new mysqli("sql202.infinityfree.com", "if0_39302602", "jT4CeZzfz4", "if0_39302602_dbtravel");
if ($conn->connect_error) die("Erreur: " . $conn->connect_error);

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM departement WHERE id_dep = $id");
    header("Location: departement.php");
    exit;
}

$result = $conn->query("
  SELECT d.id_dep, d.nom, d.code, r.nom AS nom_region
  FROM departement d
  JOIN region r ON d.id_region = r.id_region
  ORDER BY d.id_dep DESC
");
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="topbar d-flex justify-content-between align-items-center">
    <h4><?= $pageTitle ?></h4>
    <a href="departement_add.php" class="btn btn-primary btn-sm">Ajouter un Département</a>
  </div>

  <div class="content mt-4">
    <table id="departementTable" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nom</th>
          <th>Code</th>
          <th>Région</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id_dep'] ?></td>
          <td><?= htmlspecialchars($row['nom']) ?></td>
          <td><?= htmlspecialchars($row['code']) ?></td>
          <td><?= htmlspecialchars($row['nom_region']) ?></td>
          <td>
            <a href="departement_edit.php?id=<?= $row['id_dep'] ?>" class="btn btn-warning btn-sm">Modifier</a>
            <a href="?delete=<?= $row['id_dep'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce département ?')">Supprimer</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</main>

<?php include('includes/footer.php'); ?>
