<?php
$pageTitle = "Modifier une Région";
include('includes/header.php');
include('includes/sidebar.php');

$conn = new mysqli("localhost", "root", "", "dbtravel");
if ($conn->connect_error) die("Erreur: " . $conn->connect_error);

$id = intval($_GET['id']);
$region = $conn->query("SELECT * FROM Region WHERE id_region = $id")->fetch_assoc();
$paysList = $conn->query("SELECT id_pays, nom FROM Pays");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $conn->real_escape_string($_POST['nom']);
    $id_pays = intval($_POST['id_pays']);
    $conn->query("UPDATE Region SET nom = '$nom', id_pays = $id_pays WHERE id_region = $id");
    header("Location: region.php");
    exit;
}
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="topbar">
    <h4><?php echo $pageTitle; ?></h4>
  </div>
  <div class="content mt-4">
    <form method="post">
      <div class="mb-3">
        <label>Nom de la Région</label>
        <input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($region['nom']) ?>" required>
      </div>
      <div class="mb-3">
        <label>Pays</label>
        <select name="id_pays" class="form-select" required>
          <?php while ($p = $paysList->fetch_assoc()): ?>
            <option value="<?= $p['id_pays'] ?>" <?= $region['id_pays'] == $p['id_pays'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($p['nom']) ?>
            </option>
          <?php endwhile; ?>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Modifier</button>
      <a href="region.php" class="btn btn-secondary">Annuler</a>
    </form>
  </div>
</main>

<?php include('includes/footer.php'); ?>
