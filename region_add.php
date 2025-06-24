<?php
$pageTitle = "Ajouter une Région";
include('includes/header.php');
include('includes/sidebar.php');

$conn = new mysqli("sql202.infinityfree.com", "if0_39302602", "jT4CeZzfz4", "if0_39302602_dbtravel");
if ($conn->connect_error) die("Erreur: " . $conn->connect_error);

$paysList = $conn->query("SELECT id_pays, nom FROM pays");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $conn->real_escape_string($_POST['nom']);
    $id_pays = intval($_POST['id_pays']);
    $conn->query("INSERT INTO region (nom, id_pays) VALUES ('$nom', $id_pays)");
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
        <input type="text" name="nom" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>pays</label>
        <select name="id_pays" class="form-select" required>
          <option value="">-- Choisir un pays --</option>
          <?php while ($p = $paysList->fetch_assoc()): ?>
            <option value="<?= $p['id_pays'] ?>"><?= htmlspecialchars($p['nom']) ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <button type="submit" class="btn btn-success">Enregistrer</button>
      <a href="region.php" class="btn btn-secondary">Annuler</a>
    </form>
  </div>
</main>

<?php include('includes/footer.php'); ?>
