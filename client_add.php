<?php
 

$conn = new mysqli("sql202.infinityfree.com", "if0_39302602", "jT4CeZzfz4", "if0_39302602_dbtravel");
if ($conn->connect_error) die($conn->connect_error);

$pageTitle = "Ajouter un client";
include('includes/header.php');
include('includes/sidebar.php');

$villes = $conn->query("SELECT id_ville, nom FROM ville");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $conn->real_escape_string($_POST['nom']);
    $prenom = $conn->real_escape_string($_POST['prenom']);
    $genre = $_POST['genre'];
    $adresse = $conn->real_escape_string($_POST['adresse']);
    $id_ville = intval($_POST['id_ville']);

    $conn->query("
      INSERT INTO client (nom, prenom, genre, adresse, id_ville)
      VALUES ('$nom', '$prenom', '$genre', '$adresse', $id_ville)");

    $id_client = $conn->insert_id;

    // Optional user account
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = $conn->real_escape_string($_POST['username']);
        $hash = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $role = 'client';
        $conn->query("
          INSERT INTO utilisateur (id_client, username, mot_de_passe, role)
          VALUES ($id_client, '$username', '$hash', '$role')");
    }

    header('Location: client.php');
    exit;
}
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <h4><?= $pageTitle ?></h4>
  <form method="post" class="mt-4">
    <div class="row mb-3">
      <div class="col">
        <label>Nom</label>
        <input type="text" name="nom" class="form-control" required>
      </div>
      <div class="col">
        <label>Prénom</label>
        <input type="text" name="prenom" class="form-control" required>
      </div>
    </div>
    <div class="mb-3">
      <label>Genre</label>
      <select name="genre" class="form-select" required>
        <option value="M">M</option>
        <option value="F">F</option>
      </select>
    </div>
    <div class="mb-3">
      <label>Adresse</label>
      <input type="text" name="adresse" class="form-control">
    </div>
    <div class="mb-3">
      <label>ville</label>
      <select name="id_ville" class="form-select" required>
        <option value="">-- Choisir --</option>
        <?php while ($v = $villes->fetch_assoc()): ?>
        <option value="<?= $v['id_ville'] ?>"><?= htmlspecialchars($v['nom']) ?></option>
        <?php endwhile; ?>
      </select>
    </div>
    <hr>
    <h5>Créer un compte (optionnel)</h5>
    <div class="mb-3">
      <label>Username</label>
      <input type="text" name="username" class="form-control">
    </div>
    <div class="mb-3">
      <label>Password</label>
      <input type="password" name="password" class="form-control">
    </div>
    <button class="btn btn-success">Enregistrer</button>
    <a href="client.php" class="btn btn-secondary">Annuler</a>
  </form>
</main>

<?php include('includes/footer.php'); ?>
