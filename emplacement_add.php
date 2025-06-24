<?php
$pageTitle = "Ajouter un emplacement";
include('includes/header.php');
include('includes/sidebar.php');

$conn = new mysqli("sql202.infinityfree.com", "if0_39302602", "jT4CeZzfz4", "if0_39302602_dbtravel");
if ($conn->connect_error) die("Erreur: " . $conn->connect_error);

$numero = "";
$id_autocar = 0;
$error = "";

$autocarResult = $conn->query("SELECT id_autocar, immatriculation FROM autocar ORDER BY immatriculation");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero = intval($_POST['numero']);
    $id_autocar = intval($_POST['id_autocar']);

    if ($numero <= 0 || $id_autocar <= 0) {
        $error = "Le numéro et l'autocar sont obligatoires et doivent être valides.";
    } else {
        // Check if seat number already exists for this bus to avoid duplicates
        $stmtCheck = $conn->prepare("SELECT COUNT(*) FROM emplacement WHERE numero = ? AND id_autocar = ?");
        $stmtCheck->bind_param("ii", $numero, $id_autocar);
        $stmtCheck->execute();
        $stmtCheck->bind_result($count);
        $stmtCheck->fetch();
        $stmtCheck->close();

        if ($count > 0) {
            $error = "Ce numéro d'emplacement existe déjà pour cet autocar.";
        } else {
            $stmt = $conn->prepare("INSERT INTO emplacement (numero, id_autocar) VALUES (?, ?)");
            $stmt->bind_param("ii", $numero, $id_autocar);
            if ($stmt->execute()) {
                header("Location: emplacement.php");
                exit;
            } else {
                $error = "Erreur lors de l'ajout : " . $stmt->error;
            }
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
      <label for="numero" class="form-label">Numéro d'emplacement</label>
      <input type="number" id="numero" name="numero" class="form-control" required value="<?= htmlspecialchars($numero) ?>" min="1" />
    </div>
    <div class="mb-3">
      <label for="id_autocar" class="form-label">autocar</label>
      <select id="id_autocar" name="id_autocar" class="form-select" required>
        <option value="">-- Choisir un autocar --</option>
        <?php while ($autocar = $autocarResult->fetch_assoc()): ?>
          <option value="<?= $autocar['id_autocar'] ?>" <?= ($autocar['id_autocar'] == $id_autocar) ? 'selected' : '' ?>>
            <?= htmlspecialchars($autocar['immatriculation']) ?>
          </option>
        <?php endwhile; ?>
      </select>
    </div>
    <button type="submit" class="btn btn-primary">Ajouter</button>
    <a href="emplacement.php" class="btn btn-secondary">Annuler</a>
  </form>
</main>

<?php include('includes/footer.php'); ?>
