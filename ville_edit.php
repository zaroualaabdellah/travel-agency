<?php
$pageTitle = "Modifier une Ville";
include('includes/header.php');
include('includes/sidebar.php');

$conn = new mysqli("localhost", "root", "", "dbtravel");
if ($conn->connect_error) die("Erreur: " . $conn->connect_error);

$id = intval($_GET['id']);
$ville = $conn->query("SELECT * FROM Ville WHERE id_ville = $id")->fetch_assoc();
$departements = $conn->query("SELECT id_dep, nom FROM Departement");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $conn->real_escape_string($_POST['nom']);
    $code_postal = $conn->real_escape_string($_POST['code_postal']);
    $id_dep = intval($_POST['id_dep']);
    $conn->query("UPDATE Ville SET nom = '$nom', code_postal = '$code_postal', id_dep = $id_dep WHERE id_ville = $id");
    header("Location: ville.php");
    exit;
}
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="topbar"><h4><?= $pageTitle ?></h4></div>

  <div class="content mt-4">
    <form method="post">
      <div class="mb-3">
        <label>Nom de la Ville</label>
        <input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($ville['nom']) ?>" required>
      </div>
      <div class="mb-3">
        <label>Code Postal</label>
        <input type="text" name="code_postal" class="form-control" value="<?= htmlspecialchars($ville['code_postal']) ?>">
      </div>
      <div class="mb-3">
        <label>Département</label>
        <select name="id_dep" class="form-select" required>
          <?php while ($d = $departements->fetch_assoc()): ?>
            <option value="<?= $d['id_dep'] ?>" <?= $ville['id_dep'] == $d['id_dep'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($d['nom']) ?>
            </option>
          <?php endwhile; ?>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Modifier</button>
      <a href="ville.php" class="btn btn-secondary">Annuler</a>
    </form>
  </div>
</main>

<?php include('includes/footer.php'); ?>
