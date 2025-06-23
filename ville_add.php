<?php
$pageTitle = "Ajouter une Ville";
include('includes/header.php');
include('includes/sidebar.php');

$conn = new mysqli("localhost", "root", "", "dbtravel");
if ($conn->connect_error) die("Erreur: " . $conn->connect_error);

$departements = $conn->query("SELECT id_dep, nom FROM Departement");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $conn->real_escape_string($_POST['nom']);
    $code_postal = $conn->real_escape_string($_POST['code_postal']);
    $id_dep = intval($_POST['id_dep']);
    $conn->query("INSERT INTO Ville (nom, code_postal, id_dep) VALUES ('$nom', '$code_postal', $id_dep)");
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
        <input type="text" name="nom" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Code Postal</label>
        <input type="text" name="code_postal" class="form-control">
      </div>
      <div class="mb-3">
        <label>Département</label>
        <select name="id_dep" class="form-select" required>
          <option value="">-- Choisir un département --</option>
          <?php while ($d = $departements->fetch_assoc()): ?>
            <option value="<?= $d['id_dep'] ?>"><?= htmlspecialchars($d['nom']) ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <button type="submit" class="btn btn-success">Enregistrer</button>
      <a href="ville.php" class="btn btn-secondary">Annuler</a>
    </form>
  </div>
</main>

<?php include('includes/footer.php'); ?>
