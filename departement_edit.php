<?php
$pageTitle = "Modifier un Département";
include('includes/header.php');
include('includes/sidebar.php');

$conn = new mysqli("localhost", "root", "", "dbtravel");
if ($conn->connect_error) die("Erreur: " . $conn->connect_error);

$id = intval($_GET['id']);
$departement = $conn->query("SELECT * FROM Departement WHERE id_dep = $id")->fetch_assoc();
$regions = $conn->query("SELECT id_region, nom FROM Region");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $conn->real_escape_string($_POST['nom']);
    $code = $conn->real_escape_string($_POST['code']);
    $id_region = intval($_POST['id_region']);
    $conn->query("UPDATE Departement SET nom = '$nom', code = '$code', id_region = $id_region WHERE id_dep = $id");
    header("Location: departement.php");
    exit;
}
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="topbar"><h4><?= $pageTitle ?></h4></div>

  <div class="content mt-4">
    <form method="post">
      <div class="mb-3">
        <label>Nom du Département</label>
        <input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($departement['nom']) ?>" required>
      </div>
      <div class="mb-3">
        <label>Code</label>
        <input type="text" name="code" class="form-control" value="<?= htmlspecialchars($departement['code']) ?>">
      </div>
      <div class="mb-3">
        <label>Région</label>
        <select name="id_region" class="form-select" required>
          <?php while ($r = $regions->fetch_assoc()): ?>
            <option value="<?= $r['id_region'] ?>" <?= $departement['id_region'] == $r['id_region'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($r['nom']) ?>
            </option>
          <?php endwhile; ?>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Modifier</button>
      <a href="departement.php" class="btn btn-secondary">Annuler</a>
    </form>
  </div>
</main>

<?php include('includes/footer.php'); ?>
