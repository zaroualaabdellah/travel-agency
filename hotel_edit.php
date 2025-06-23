<?php
$pageTitle = "Modifier un Hôtel";
include('includes/header.php');
include('includes/sidebar.php');

$conn = new mysqli("localhost", "root", "", "dbtravel");
if ($conn->connect_error) die("Erreur: " . $conn->connect_error);

if (!isset($_GET['id'])) {
    header("Location: hotel.php");
    exit;
}
$id = intval($_GET['id']);

$error = "";

$result = $conn->query("SELECT * FROM Hotel WHERE id_hotel = $id");
if ($result->num_rows === 0) {
    header("Location: hotel.php");
    exit;
}
$hotel = $result->fetch_assoc();

$nom = $hotel['nom'];
$adresse = $hotel['adresse'];
$id_ville = $hotel['id_ville'];

$villeResult = $conn->query("SELECT id_ville, nom FROM Ville ORDER BY nom");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom']);
    $adresse = trim($_POST['adresse']);
    $id_ville = intval($_POST['id_ville']);

    if ($nom === "" || $adresse === "" || $id_ville <= 0) {
        $error = "Tous les champs sont obligatoires.";
    } else {
        $stmt = $conn->prepare("UPDATE Hotel SET nom = ?, adresse = ?, id_ville = ? WHERE id_hotel = ?");
        $stmt->bind_param("ssii", $nom, $adresse, $id_ville, $id);
        if ($stmt->execute()) {
            header("Location: hotel.php");
            exit;
        } else {
            $error = "Erreur lors de la modification : " . $stmt->error;
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

    <button type="submit" class="btn btn-primary">Modifier</button>
    <a href="hotel.php" class="btn btn-secondary">Annuler</a>
  </form>
</main>

<?php include('includes/footer.php'); ?>
