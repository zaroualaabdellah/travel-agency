<?php
$pageTitle = "Liste des Villes";
include('includes/header.php');
include('includes/sidebar.php');

$conn = new mysqli("sql202.infinityfree.com", "if0_39302602", "jT4CeZzfz4", "if0_39302602_dbtravel");
if ($conn->connect_error) die("Erreur: " . $conn->connect_error);

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM ville WHERE id_ville = $id");
    header("Location: ville.php");
    exit;
}

$result = $conn->query("
  SELECT v.id_ville, v.nom, v.code_postal, d.nom AS nom_dep
  FROM ville v
  JOIN departement d ON v.id_dep = d.id_dep
  ORDER BY v.id_ville DESC
");
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="topbar d-flex justify-content-between align-items-center">
    <h4><?= $pageTitle ?></h4>
    <a href="ville_add.php" class="btn btn-primary btn-sm">Ajouter une ville</a>
  </div>

  <div class="content mt-4">
    <table id="villeTable" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nom</th>
          <th>Code Postal</th>
          <th>Département</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id_ville'] ?></td>
          <td><?= htmlspecialchars($row['nom']) ?></td>
          <td><?= htmlspecialchars($row['code_postal']) ?></td>
          <td><?= htmlspecialchars($row['nom_dep']) ?></td>
          <td>
            <a href="ville_edit.php?id=<?= $row['id_ville'] ?>" class="btn btn-warning btn-sm">Modifier</a>
            <a href="?delete=<?= $row['id_ville'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cette ville ?')">Supprimer</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</main>

<?php include('includes/footer.php'); ?>
