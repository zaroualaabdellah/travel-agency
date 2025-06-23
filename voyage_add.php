<?php
$pageTitle = "Ajouter un Voyage";
include('includes/header.php');
include('includes/sidebar.php');

$conn = new mysqli("localhost", "root", "", "dbtravel");
if ($conn->connect_error) die("Erreur: " . $conn->connect_error);

$libelle = "";
$type_voyage = "";
$pension = "";
$id_hotel = 0;
$error = "";

$hotelResult = $conn->query("SELECT id_hotel, nom FROM Hotel ORDER BY nom");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $libelle = trim($_POST['libelle']);
    $type_voyage = trim($_POST['type_voyage']);
    $pension = trim($_POST['pension']);
    $id_hotel = intval($_POST['id_hotel']);

    if ($libelle === "" || $type_voyage === "" || $pension === "" || $id_hotel <= 0) {
        $error = "Tous les champs sont obligatoires.";
    } else {
        $stmt = $conn->prepare("INSERT INTO Voyage (libelle, type_voyage, pension, id_hotel) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $libelle, $type_voyage, $pension, $id_hotel);
        if ($stmt->execute()) {
            header("Location: voyage.php");
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
      <label for="libelle" class="form-label">Libellé</label>
      <input type="text" id="libelle" name="libelle" class="form-control" required value="<?= htmlspecialchars($libelle) ?>" />
    </div>

    <div class="mb-3">
      <label for="type_voyage" class="form-label">Type de Voyage</label>
      <input type="text" id="type_voyage" name="type_voyage" class="form-control" required value="<?= htmlspecialchars($type_voyage) ?>" />
    </div>

    <div class="mb-3">
      <label for="pension" class="form-label">Pension</label>
      <input type="text" id="pension" name="pension" class="form-control" required value="<?= htmlspecialchars($pension) ?>" />
    </div>

    <div class="mb-3">
      <label for="id_hotel" class="form-label">Hôtel</label>
      <select id="id_hotel" name="id_hotel" class="form-select" required>
        <option value="">-- Choisir un hôtel --</option>
        <?php while ($hotel = $hotelResult->fetch_assoc()): ?>
          <option value="<?= $hotel['id_hotel'] ?>" <?= ($hotel['id_hotel'] == $id_hotel) ? 'selected' : '' ?>>
            <?= htmlspecialchars($hotel['nom']) ?>
          </option>
        <?php endwhile; ?>
      </select>
    </div>

    <button type="submit" class="btn btn-primary">Ajouter</button>
    <a href="voyage.php" class="btn btn-secondary">Annuler</a>
  </form>
</main>

<?php include('includes/footer.php'); ?>
