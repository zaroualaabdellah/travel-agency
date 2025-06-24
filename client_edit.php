<?php
 

$conn = new mysqli("sql202.infinityfree.com", "if0_39302602", "jT4CeZzfz4", "if0_39302602_dbtravel");
if ($conn->connect_error) die($conn->connect_error);

if (!isset($_GET['id'])) { header('Location: client.php'); exit; }
$id = intval($_GET['id']);

$pageTitle = "Modifier client";
include('includes/header.php');
include('includes/sidebar.php');

$client = $conn->query("SELECT * FROM client WHERE id_client = $id")->fetch_assoc();
$account = $conn->query("SELECT * FROM utilisateur WHERE id_client = $id")->fetch_assoc();
$villes = $conn->query("SELECT id_ville, nom FROM ville");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $conn->real_escape_string($_POST['nom']);
    $prenom = $conn->real_escape_string($_POST['prenom']);
    $genre = $_POST['genre'];
    $adresse = $conn->real_escape_string($_POST['adresse']);
    $id_ville = intval($_POST['id_ville']);
    $conn->query("
      UPDATE client SET nom='$nom', prenom='$prenom', genre='$genre', adresse='$adresse', id_ville=$id_ville
      WHERE id_client = $id");

    if (!empty($_POST['password'])) {
        $hash = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $conn->query("
          UPDATE utilisateur SET mot_de_passe='$hash'
          WHERE id_client = $id");
    }

    header('Location: client.php');
    exit;
}
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <h4><?= $pageTitle ?></h4>
  <form method="post" class="mt-4">
    <!-- repeat fields for nom/prenom/genre/adresse/ville as above -->
    <div class="row mb-3">
      <div class="col">
        <label>Nom</label><input type="text" name="nom" value="<?= htmlspecialchars($client['nom']) ?>" class="form-control" required>
      </div>
      <div class="col">
        <label>Prénom</label><input type="text" name="prenom" value="<?= htmlspecialchars($client['prenom']) ?>" class="form-control" required>
      </div>
    </div>
    <div class="mb-3">
      <label>Genre</label>
      <select name="genre" class="form-select">
        <option value="M" <?= $client['genre']=='M'?'selected':'' ?>>M</option>
        <option value="F" <?= $client['genre']=='F'?'selected':'' ?>>F</option>
      </select>
    </div>
    <div class="mb-3"><label>Adresse</label><input type="text" name="adresse" value="<?= htmlspecialchars($client['adresse']) ?>" class="form-control"></div>
    <div class="mb-3">
      <label>ville</label>
      <select name="id_ville" class="form-select">
        <?php while ($v = $villes->fetch_assoc()): ?>
        <option value="<?= $v['id_ville'] ?>" <?= $client['id_ville']==$v['id_ville']?'selected':'' ?>><?= htmlspecialchars($v['nom']) ?></option>
        <?php endwhile; ?>
      </select>
    </div>
    <hr>
    <?php if ($account): ?>
      <h5>Modifier mot de passe (optionnel)</h5>
      <div class="mb-3">
        <label>Nouveau mot de passe</label>
        <input type="password" name="password" class="form-control">
      </div>
    <?php endif; ?>
    <button class="btn btn-primary">Enregistrer</button>
    <a href="client.php" class="btn btn-secondary">Annuler</a>
  </form>
</main>

<?php include('includes/footer.php'); ?>
