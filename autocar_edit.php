<?php
$pageTitle = "Modifier un autocar";
include('includes/header.php');
include('includes/sidebar.php');

$conn = new mysqli("sql202.infinityfree.com", "if0_39302602", "jT4CeZzfz4", "if0_39302602_dbtravel");
if ($conn->connect_error) die("Erreur: " . $conn->connect_error);

if (!isset($_GET['id'])) {
    header("Location: autocar.php");
    exit;
}
$id = intval($_GET['id']);

$error = "";

$result = $conn->query("SELECT * FROM autocar WHERE id_autocar = $id");
if ($result->num_rows === 0) {
    header("Location: autocar.php");
    exit;
}
$autocar = $result->fetch_assoc();

$immatriculation = $autocar['immatriculation'];
$id_type = $autocar['id_type'];

$typeResult = $conn->query("SELECT id_type, nom_type FROM typeautocar ORDER BY nom_type");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $immatriculation = trim($_POST['immatriculation']);
    $id_type = intval($_POST['id_type']);

    if ($immatriculation === "" || $id_type <= 0) {
        $error = "Immatriculation et type sont obligatoires.";
    } else {
        $stmt = $conn->prepare("UPDATE autocar SET immatriculation = ?, id_type = ? WHERE id_autocar = ?");
        $stmt->bind_param("sii", $immatriculation, $id_type, $id);
        if ($stmt->execute()) {
            header("Location: autocar.php");
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
      <label for="immatriculation" class="form-label">Immatriculation</label>
      <input type="text" id="immatriculation" name="immatriculation" class="form-control" required value="<?= htmlspecialchars($immatriculation) ?>" />
    </div>
    <div class="mb-3">
      <label for="id_type" class="form-label">Type d'autocar</label>
      <select id="id_type" name="id_type" class="form-select" required>
        <option value="">-- Choisir un type --</option>
        <?php while ($type = $typeResult->fetch_assoc()): ?>
          <option value="<?= $type['id_type'] ?>" <?= ($type['id_type'] == $id_type) ? 'selected' : '' ?>>
            <?= htmlspecialchars($type['nom_type']) ?>
          </option>
        <?php endwhile; ?>
      </select>
    </div>
    <button type="submit" class="btn btn-primary">Modifier</button>
    <a href="autocar.php" class="btn btn-secondary">Annuler</a>
  </form>
</main>

<?php include('includes/footer.php'); ?>
