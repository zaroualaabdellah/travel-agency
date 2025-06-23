<?php
$pageTitle = "Ajouter un Hôtel";
include('includes/header.php');
include('includes/sidebar.php');

$conn = new mysqli("localhost", "root", "", "dbtravel");
if ($conn->connect_error) die("Erreur: " . $conn->connect_error);

$nom = "";
$adresse = "";
$id_ville = 0;
$error = "";

$villeResult = $conn->query("SELECT id_ville, nom FROM Ville ORDER BY nom");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom']);
    $adresse = trim($_POST['adresse']);
    $id_ville = intval($_POST['id_ville']);

    if ($nom === "" || $adresse === "" || $id_ville <= 0) {
        $error = "Tous les champs sont obligatoires.";
    } else {
        $stmt = $conn->prepare("INSERT INTO Hotel (nom, adresse, id_ville) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $nom, $adresse, $id_ville);
        if ($stmt->execute()) {
            header("Location: hotel.php");
            exit;
        } else {
            $error = "Erreur lors de l'ajout : " . $stmt->error;
        }
    }
}
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <h4><?= $pageTitle ?></h4>

  <?php if ($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <form method="post" action="">
    <div class="mb-3">
      <label for="nom" class="form-label">Nom</label>
      <input type="text" id="nom" name="nom" class="form-control" required value="<?= htmlspecialchars($nom) ?>" />
    </div>

    <div class="mb-3">
      <label for="adresse" class="form-label">Adresse</label>
      <input type="text" id="adresse" name="adresse" class="form-control" required value="<?= htmlspecialchars($adresse) ?>" />
    </div>

    <div class="mb-3">
      <label for="id_ville" class="form-label">Ville</label>
      <select id="id_ville" name="id_ville" class="form-select" required>
        <option value="">-- Choisir une ville --</option>
        <?php while ($ville = $villeResult->fetch_assoc()): ?>
          <option value="<?= $ville['id_ville'] ?>" <?= ($ville['id_ville'] == $id_ville) ? 'selected' : '' ?>>
            <?= htmlspecialchars($ville['nom']) ?>
          </option>
        <?php endwhile; ?>
      </select>
    </div>

    <button type="submit" class="btn btn-primary">Ajouter</button>
    <a href="hotel.php" class="btn btn-secondary">Annuler</a>
  </form>
</main>

<?php include('includes/footer.php'); ?>
