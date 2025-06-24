<?php

$pageTitle = "Liste des Programmations";
include('includes/header.php');
include('includes/sidebar.php');

$conn = new mysqli("sql202.infinityfree.com", "if0_39302602", "jT4CeZzfz4", "if0_39302602_dbtravel");
if ($conn->connect_error) die("Erreur: " . $conn->connect_error);

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    // Delete related many-to-many first
    $conn->query("DELETE FROM Programmation_Autocar WHERE id_programmation = $id");
    $conn->query("DELETE FROM Programmation_PointDepart WHERE id_programmation = $id");
    // Then delete programmation
    $conn->query("DELETE FROM programmation WHERE id_programmation = $id");
    header("Location: programmation.php");
    exit;
}

$sql = "
SELECT p.id_programmation, p.date_depart, p.date_retour, p.prix_base, v.libelle AS voyage_libelle
FROM programmation p
JOIN voyage v ON p.id_voyage = v.id_voyage
ORDER BY p.id_programmation DESC
";
$result = $conn->query($sql);
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="topbar d-flex justify-content-between align-items-center">
    <h4><?= $pageTitle ?></h4>
    <a href="programmation_add.php" class="btn btn-primary btn-sm">Ajouter programmation</a>
  </div>
  <div class="content mt-4">
    <table id="programmationTable" class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Date Départ</th>
          <th>Date Retour</th>
          <th>Prix Base</th>
          <th>voyage</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id_programmation'] ?></td>
          <td><?= htmlspecialchars($row['date_depart']) ?></td>
          <td><?= htmlspecialchars($row['date_retour']) ?></td>
          <td><?= htmlspecialchars($row['prix_base']) ?> €</td>
          <td><?= htmlspecialchars($row['voyage_libelle']) ?></td>
          <td>
            <a href="programmation_edit.php?id=<?= $row['id_programmation'] ?>" class="btn btn-warning btn-sm">Modifier</a>
            <a href="?delete=<?= $row['id_programmation'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cette programmation ?')">Supprimer</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</main>

<?php include('includes/footer.php'); ?>
