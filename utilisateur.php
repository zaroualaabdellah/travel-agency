<?php

$pageTitle = "Liste des Utilisateurs";
include('includes/header.php');
include('includes/sidebar.php');

$conn = new mysqli("localhost", "root", "", "dbtravel");
if (isset($_GET['toggle'])) {
    $id = intval($_GET['toggle']);
    $conn->query("UPDATE Utilisateur SET actif = NOT actif WHERE id_utilisateur = $id");
    header('Location: utilisateur.php');
    exit;
}
$sql = "
SELECT u.id_utilisateur, u.username, u.role, u.actif, c.nom, c.prenom
FROM Utilisateur u
JOIN Client c ON u.id_client = c.id_client";
$res = $conn->query($sql);
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="content mt-4">
  <h4><?= $pageTitle ?></h4>

  <table id="datatable" class="table table-striped table-bordered">
  <thead>
    <tr>
      <th>ID</th>
      <th>Username</th>
      <th>Client</th>
      <th>Rôle</th>
      <th>Actif</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php while($u=$res->fetch_assoc()): ?>
    <tr>
      <td><?= $u['id_utilisateur'] ?></td>
      <td><?= htmlspecialchars($u['username']) ?></td>
      <td><?= htmlspecialchars($u['nom'].' '.$u['prenom']) ?></td>
      <td><?= $u['role'] ?></td>
      <td><?= $u['actif'] ? '✅' : '❌' ?></td>
      <td>
        <a href="?toggle=<?= $u['id_utilisateur'] ?>" class="btn btn-sm <?= $u['actif'] ? 'btn-outline-danger' : 'btn-outline-success' ?>">
          <?= $u['actif'] ? 'Désactiver' : 'Activer' ?>
        </a>
      </td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table></div>
</main>
<?php include('includes/footer.php'); ?>
