<?php
$pageTitle = "Liste des Emplacements";
include('includes/header.php');
include('includes/sidebar.php');

$conn = new mysqli("sql202.infinityfree.com", "if0_39302602", "jT4CeZzfz4", "if0_39302602_dbtravel");
if ($conn->connect_error) die("Erreur: " . $conn->connect_error);

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM emplacement WHERE id_emplacement = $id");
    header("Location: emplacement.php");
    exit;
}

// Join with autocar to display bus info
$result = $conn->query("
    SELECT e.id_emplacement, e.numero, a.immatriculation, t.nom_type
    FROM emplacement e
    JOIN autocar a ON e.id_autocar = a.id_autocar
    JOIN typeautocar t ON a.id_type = t.id_type
    ORDER BY e.id_emplacement DESC
");
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="topbar d-flex justify-content-between align-items-center">
    <h4><?= $pageTitle ?></h4>
    <a href="emplacement_add.php" class="btn btn-primary btn-sm">Ajouter un emplacement</a>
  </div>

  <div class="content mt-4">
    <table id="emplacementTable" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Numéro</th>
          <th>autocar</th>
          <th>Type d'autocar</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id_emplacement'] ?></td>
          <td><?= htmlspecialchars($row['numero']) ?></td>
          <td><?= htmlspecialchars($row['immatriculation']) ?></td>
          <td><?= htmlspecialchars($row['nom_type']) ?></td>
          <td>
            <a href="emplacement_edit.php?id=<?= $row['id_emplacement'] ?>" class="btn btn-warning btn-sm">Modifier</a>
            <a href="?delete=<?= $row['id_emplacement'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cet emplacement ?')">Supprimer</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</main>

<?php include('includes/footer.php'); ?>
