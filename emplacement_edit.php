<?php
$pageTitle = "Modifier un Emplacement";
include('includes/header.php');
include('includes/sidebar.php');

$conn = new mysqli("localhost", "root", "", "dbtravel");
if ($conn->connect_error) die("Erreur: " . $conn->connect_error);

if (!isset($_GET['id'])) {
    header("Location: emplacement.php");
    exit;
}
$id = intval($_GET['id']);

$error = "";

$result = $conn->query("SELECT * FROM Emplacement WHERE id_emplacement = $id");
if ($result->num_rows === 0) {
    header("Location: emplacement.php");
    exit;
}
$emplacement = $result->fetch_assoc();

$numero = $emplacement['numero'];
$id_autocar = $emplacement['id_autocar'];

$autocarResult = $conn->query("SELECT id_autocar, immatriculation FROM Autocar ORDER BY immatriculation");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero = intval($_POST['numero']);
    $id_autocar = intval($_POST['id_autocar']);

    if ($numero <= 0 || $id_autocar <= 0) {
        $error = "Le numéro et l'autocar sont obligatoires et doivent être valides.";
    } else {
        // Check duplicate seat number for the bus excluding current record
        $stmtCheck = $conn->prepare("SELECT COUNT(*) FROM Emplacement WHERE numero = ? AND id_autocar = ? AND id_emplacement != ?");
        $stmtCheck->bind_param("iii", $numero, $id_autocar, $id);
        $stmtCheck->execute();
        $stmtCheck->bind_result($count);
        $stmtCheck->fetch();
        $stmtCheck->close();

        if ($count > 0) {
            $error = "Ce numéro d'emplacement existe déjà pour cet autocar.";
        } else {
            $stmt = $conn->prepare("UPDATE Emplacement SET numero = ?, id_autocar = ? WHERE id_emplacement = ?");
            $stmt->bind_param("iii", $numero, $id_autocar, $id);
            if ($stmt->execute()) {
                header("Location: emplacement.php");
                exit;
            } else {
                $error = "Erreur lors de la modification : " . $stmt->error;
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
      <label for="numero" class="form-label">Numéro d'Emplacement</label>
      <input type="number" id="numero" name="numero" class="form-control" required value="<?= htmlspecialchars($numero) ?>" min="1" />
    </div>
    <div class="mb-3">
      <label for="id_autocar" class="form-label">Autocar</label>
      <select id="id_autocar" name="id_autocar" class="form-select" required>
        <option value="">-- Choisir un autocar --</option>
        <?php while ($autocar = $autocarResult->fetch_assoc()): ?>
          <option value="<?= $autocar['id_autocar'] ?>" <?= ($autocar['id_autocar'] == $id_autocar) ? 'selected' : '' ?>>
            <?= htmlspecialchars($autocar['immatriculation']) ?>
          </option>
        <?php endwhile; ?>
      </select>
    </div>
    <button type="submit" class="btn btn-primary">Modifier</button>
    <a href="emplacement.php" class="btn btn-secondary">Annuler</a>
  </form>
</main>

<?php include('includes/footer.php'); ?>
