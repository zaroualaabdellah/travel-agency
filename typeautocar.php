<?php
$pageTitle = "Liste des Types d'Autocar";
include('includes/header.php');
include('includes/sidebar.php');

$conn = new mysqli("localhost", "root", "", "dbtravel");
if ($conn->connect_error) die("Erreur: " . $conn->connect_error);

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM TypeAutocar WHERE id_type = $id");
    header("Location: typeautocar.php");
    exit;
}

$result = $conn->query("SELECT id_type, nom_type, description FROM TypeAutocar ORDER BY id_type DESC");
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="topbar d-flex justify-content-between align-items-center">
    <h4><?= $pageTitle ?></h4>
    <a href="typeautocar_add.php" class="btn btn-primary btn-sm">Ajouter un Type d'Autocar</a>
  </div>

  <div class="content mt-4">
    <table id="typeAutocarTable" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nom du Type</th>
          <th>Description</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id_type'] ?></td>
          <td><?= htmlspecialchars($row['nom_type']) ?></td>
          <td><?= nl2br(htmlspecialchars($row['description'])) ?></td>
          <td>
            <a href="typeautocar_edit.php?id=<?= $row['id_type'] ?>" class="btn btn-warning btn-sm">Modifier</a>
            <a href="?delete=<?= $row['id_type'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce type d\'autocar ?')">Supprimer</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</main>

<?php include('includes/footer.php'); ?>
