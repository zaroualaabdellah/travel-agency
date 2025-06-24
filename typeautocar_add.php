<?php
$pageTitle = "Ajouter un Type d'autocar";
include('includes/header.php');
include('includes/sidebar.php');

$conn = new mysqli("sql202.infinityfree.com", "if0_39302602", "jT4CeZzfz4", "if0_39302602_dbtravel");
if ($conn->connect_error) die("Erreur: " . $conn->connect_error);

$nom_type = $description = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom_type = trim($_POST['nom_type']);
    $description = trim($_POST['description']);

    if ($nom_type === "") {
        $error = "Le nom du type est obligatoire.";
    } else {
        $stmt = $conn->prepare("INSERT INTO typeautocar (nom_type, description) VALUES (?, ?)");
        $stmt->bind_param("ss", $nom_type, $description);
        if ($stmt->execute()) {
            header("Location: typeautocar.php");
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
      <label for="nom_type" class="form-label">Nom du Type</label>
      <input type="text" id="nom_type" name="nom_type" class="form-control" required value="<?= htmlspecialchars($nom_type) ?>" />
    </div>
    <div class="mb-3">
      <label for="description" class="form-label">Description</label>
      <textarea id="description" name="description" class="form-control"><?= htmlspecialchars($description) ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Ajouter</button>
    <a href="typeautocar.php" class="btn btn-secondary">Annuler</a>
  </form>
</main>

<?php include('includes/footer.php'); ?>
