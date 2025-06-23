<?php


$pageTitle = "Liste des Clients";
include('includes/header.php');
include('includes/sidebar.php');

$conn = new mysqli("localhost", "root", "", "dbtravel");
if ($conn->connect_error) die("Erreur: " . $conn->connect_error);

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM Utilisateur WHERE id_client = $id");
    $conn->query("DELETE FROM Client WHERE id_client = $id");
    header("Location: client.php");
    exit;
}

$sql = "
SELECT c.id_client, c.nom, c.prenom, c.genre, c.adresse, v.nom AS ville
FROM Client c
JOIN Ville v ON c.id_ville = v.id_ville
ORDER BY c.id_client DESC";
$result = $conn->query($sql);
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="topbar d-flex justify-content-between align-items-center">
    <h4><?= $pageTitle ?></h4>
    <a href="client_add.php" class="btn btn-primary btn-sm">Ajouter Client</a>
  </div>
  <div class="content mt-4">
    <table id="datatable" class="table table-striped table-bordered">
  <thead>
    <tr>
      <th>ID</th>
      <th>Nom</th>
      <th>Prénom</th>
      <th>Genre</th>
      <th>Adresse</th>
      <th>Ville</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($c = $result->fetch_assoc()): ?>
    <tr>
      <td><?= $c['id_client'] ?></td>
      <td><?= htmlspecialchars($c['nom']) ?></td>
      <td><?= htmlspecialchars($c['prenom']) ?></td>
      <td><?= $c['genre'] ?></td>
      <td><?= htmlspecialchars($c['adresse']) ?></td>
      <td><?= htmlspecialchars($c['ville']) ?></td>
      <td>
        <a href="client_edit.php?id=<?= $c['id_client'] ?>" class="btn btn-warning btn-sm">Modifier</a>
        <a href="?delete=<?= $c['id_client'] ?>" onclick="return confirm('Supprimer ?')" class="btn btn-danger btn-sm">Supprimer</a>
      </td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>
  </div>
</main>

<?php include('includes/footer.php'); ?>
