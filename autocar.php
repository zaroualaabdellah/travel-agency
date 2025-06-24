<?php
$pageTitle = "Liste des Autocars";
include('includes/header.php');
include('includes/sidebar.php');

$conn = new mysqli("sql202.infinityfree.com", "if0_39302602", "jT4CeZzfz4", "if0_39302602_dbtravel");
if ($conn->connect_error) die("Erreur: " . $conn->connect_error);

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM autocar WHERE id_autocar = $id");
    header("Location: autocar.php");
    exit;
}

$result = $conn->query("
  SELECT a.id_autocar, a.immatriculation, t.nom_type
  FROM autocar a
  JOIN typeautocar t ON a.id_type = t.id_type
  ORDER BY a.id_autocar DESC
");
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="topbar d-flex justify-content-between align-items-center">
    <h4><?= $pageTitle ?></h4>
    <a href="autocar_add.php" class="btn btn-primary btn-sm">Ajouter un autocar</a>
  </div>

  <div class="content mt-4">
    <table id="autocarTable" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Immatriculation</th>
          <th>Type d'autocar</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id_autocar'] ?></td>
          <td><?= htmlspecialchars($row['immatriculation']) ?></td>
          <td><?= htmlspecialchars($row['nom_type']) ?></td>
          <td>
            <a href="autocar_edit.php?id=<?= $row['id_autocar'] ?>" class="btn btn-warning btn-sm">Modifier</a>
            <a href="?delete=<?= $row['id_autocar'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cet autocar ?')">Supprimer</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</main>

<?php include('includes/footer.php'); ?>
