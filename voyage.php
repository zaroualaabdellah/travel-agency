<?php
$pageTitle = "Liste des Voyages";
include('includes/header.php');
include('includes/sidebar.php');

$conn = new mysqli("sql202.infinityfree.com", "if0_39302602", "jT4CeZzfz4", "if0_39302602_dbtravel");
if ($conn->connect_error) die("Erreur: " . $conn->connect_error);

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM voyage WHERE id_voyage = $id");
    header("Location: voyage.php");
    exit;
}

$result = $conn->query("
  SELECT v.id_voyage, v.libelle, v.type_voyage, v.pension, h.nom AS hotel
  FROM voyage v
  JOIN hotel h ON v.id_hotel = h.id_hotel
  ORDER BY v.id_voyage DESC
");
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="topbar d-flex justify-content-between align-items-center">
    <h4><?= $pageTitle ?></h4>
    <a href="voyage_add.php" class="btn btn-primary btn-sm">Ajouter un voyage</a>
  </div>

  <div class="content mt-4">
    <table id="voyageTable" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Libellé</th>
          <th>Type</th>
          <th>Pension</th>
          <th>Hôtel</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id_voyage'] ?></td>
          <td><?= htmlspecialchars($row['libelle']) ?></td>
          <td><?= htmlspecialchars($row['type_voyage']) ?></td>
          <td><?= htmlspecialchars($row['pension']) ?></td>
          <td><?= htmlspecialchars($row['hotel']) ?></td>
          <td>
            <a href="voyage_edit.php?id=<?= $row['id_voyage'] ?>" class="btn btn-warning btn-sm">Modifier</a>
            <a href="?delete=<?= $row['id_voyage'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce voyage ?')">Supprimer</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</main>

<?php include('includes/footer.php'); ?>
