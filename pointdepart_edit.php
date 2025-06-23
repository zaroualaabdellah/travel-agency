<?php
$pageTitle = "Modifier Point de Départ";
include('includes/header.php');
include('includes/sidebar.php');

$conn = new mysqli("localhost", "root", "", "dbtravel");
if ($conn->connect_error) die("Erreur: " . $conn->connect_error);

if (!isset($_GET['id'])) {
    header("Location: pointdepart.php");
    exit;
}

$id = intval($_GET['id']);
$error = "";

// Fetch existing pointdepart
$stmt = $conn->prepare("SELECT * FROM PointDepart WHERE id_point_depart = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 0) {
    header("Location: pointdepart.php");
    exit;
}
$point = $res->fetch_assoc();
$stmt->close();

$lieu = $point['lieu'];
$id_ville = $point['id_ville'];

// Fetch villes for select dropdown
$villeResult = $conn->query("SELECT id_ville, nom FROM Ville ORDER BY nom");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lieu = trim($_POST['lieu'] ?? "");
    $id_ville = intval($_POST['id_ville'] ?? 0);

    if (!$lieu || $id_ville <= 0) {
        $error = "Tous les champs sont obligatoires.";
    } else {
        $stmt = $conn->prepare("UPDATE PointDepart SET lieu = ?, id_ville = ? WHERE id_point_depart = ?");
        $stmt->bind_param("sii", $lieu, $id_ville, $id);
        if ($stmt->execute()) {
            header("Location: pointdepart.php");
            exit;
        } else {
            $error = "Erreur lors de la mise à jour: " . $stmt->error;
        }
        $stmt->close();
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
      <label for="lieu" class="form-label">Lieu</label>
      <input type="text" id="lieu" name="lieu" class="form-control" required value="<?= htmlspecialchars($lieu) ?>">
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
    <a href="pointdepart.php" class="btn btn-secondary">Annuler</a>
  </form>
</main>

<?php include('includes/footer.php'); ?>
