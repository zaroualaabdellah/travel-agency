<?php
$pageTitle = "Ajouter un Département";
include('includes/header.php');
include('includes/sidebar.php');

$conn = new mysqli("sql202.infinityfree.com", "if0_39302602", "jT4CeZzfz4", "if0_39302602_dbtravel");
if ($conn->connect_error) die("Erreur: " . $conn->connect_error);

$regions = $conn->query("SELECT id_region, nom FROM region");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $conn->real_escape_string($_POST['nom']);
    $code = $conn->real_escape_string($_POST['code']);
    $id_region = intval($_POST['id_region']);
    $conn->query("INSERT INTO departement (nom, code, id_region) VALUES ('$nom', '$code', $id_region)");
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
        <input type="text" name="nom" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Code</label>
        <input type="text" name="code" class="form-control">
      </div>
      <div class="mb-3">
        <label>Région</label>
        <select name="id_region" class="form-select" required>
          <option value="">-- Choisir une région --</option>
          <?php while ($r = $regions->fetch_assoc()): ?>
            <option value="<?= $r['id_region'] ?>"><?= htmlspecialchars($r['nom']) ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <button type="submit" class="btn btn-success">Enregistrer</button>
      <a href="departement.php" class="btn btn-secondary">Annuler</a>
    </form>
  </div>
</main>

<?php include('includes/footer.php'); ?>
