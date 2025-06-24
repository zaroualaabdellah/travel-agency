<?php
$pageTitle = "Modifier un Type d'autocar";
include('includes/header.php');
include('includes/sidebar.php');

$conn = new mysqli("sql202.infinityfree.com", "if0_39302602", "jT4CeZzfz4", "if0_39302602_dbtravel");
if ($conn->connect_error) die("Erreur: " . $conn->connect_error);

if (!isset($_GET['id'])) {
    header("Location: typeautocar.php");
    exit;
}
$id = intval($_GET['id']);

$error = "";

$result = $conn->query("SELECT * FROM typeautocar WHERE id_type = $id");
if ($result->num_rows === 0) {
    header("Location: typeautocar.php");
    exit;
}
$typeautocar = $result->fetch_assoc();

$nom_type = $typeautocar['nom_type'];
$description = $typeautocar['description'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom_type = trim($_POST['nom_type']);
    $description = trim($_POST['description']);

    if ($nom_type === "") {
        $error = "Le nom du type est obligatoire.";
    } else {
        $stmt = $conn->prepare("UPDATE typeautocar SET nom_type = ?, description = ? WHERE id_type = ?");
        $stmt->bind_param("ssi", $nom_type, $description, $id);
        if ($stmt->execute()) {
            header("Location: typeautocar.php");
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
      <label for="nom_type" class="form-label">Nom du Type</label>
      <input type="text" id="nom_type" name="nom_type" class="form-control" required value="<?= htmlspecialchars($nom_type) ?>" />
    </div>
    <div class="mb-3">
      <label for="description" class="form-label">Description</label>
      <textarea id="description" name="description" class="form-control"><?= htmlspecialchars($description) ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Modifier</button>
    <a href="typeautocar.php" class="btn btn-secondary">Annuler</a>
  </form>
</main>

<?php include('includes/footer.php'); ?>
