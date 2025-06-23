<?php
$pageTitle = "Ajouter un Pays";
include('includes/header.php');
include('includes/sidebar.php');

$conn = new mysqli("localhost", "root", "", "dbtravel");
if ($conn->connect_error) die("Erreur: " . $conn->connect_error);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $conn->real_escape_string($_POST['nom']);
    $conn->query("INSERT INTO Pays (nom) VALUES ('$nom')");
    header("Location: pays.php");
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
        <label for="nom" class="form-label">Nom du Pays</label>
        <input type="text" name="nom" id="nom" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-success">Enregistrer</button>
      <a href="pays.php" class="btn btn-secondary">Annuler</a>
    </form>
  </div>
</main>

<?php include('includes/footer.php'); ?>
