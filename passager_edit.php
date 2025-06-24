<?php
session_start();
if (!isset($_SESSION['user'])) header('Location: login.php');

$pageTitle = "Modifier passager";
include('includes/header.php');
include('includes/sidebar.php');

$conn = new mysqli("sql202.infinityfree.com", "if0_39302602", "jT4CeZzfz4", "if0_39302602_dbtravel");
if ($conn->connect_error) die("Erreur: " . $conn->connect_error);

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    header("Location: passager.php");
    exit;
}

// Fetch passager data
$stmt = $conn->prepare("SELECT * FROM passager WHERE id_passager = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$passager = $stmt->get_result()->fetch_assoc();
if (!$passager) {
    header("Location: passager.php");
    exit;
}

// Fetch reservations for dropdown
$reservationsRes = $conn->query("
  SELECT r.id_reservation, r.date_reservation, c.nom, c.prenom
  FROM reservation r
  JOIN client c ON r.id_client = c.id_client
  ORDER BY r.date_reservation DESC
");

// Fetch emplacements for dropdown
$emplacementsRes = $conn->query("SELECT id_emplacement, numero FROM emplacement ORDER BY numero");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');
    $id_reservation = intval($_POST['id_reservation']);
    $id_emplacement = intval($_POST['id_emplacement']);

    if ($nom === '' || $prenom === '' || $id_reservation <= 0 || $id_emplacement <= 0) {
        $error = "Nom, prénom, réservation et emplacement sont obligatoires.";
    } else {
        $stmt = $conn->prepare("UPDATE passager SET nom=?, prenom=?, telephone=?, id_reservation=?, id_emplacement=? WHERE id_passager=?");
        $stmt->bind_param("sssiii", $nom, $prenom, $telephone, $id_reservation, $id_emplacement, $id);
        if ($stmt->execute()) {
            header("Location: passager.php");
            exit;
        } else {
            $error = "Erreur lors de la modification : " . $stmt->error;
        }
    }
}
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <h4><?= $pageTitle ?></h4>
  <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>
  <form method="post" action="">
    <div class="mb-3">
      <label for="nom" class="form-label">Nom</label>
      <input type="text" name="nom" id="nom" class="form-control" required value="<?= htmlspecialchars($_POST['nom'] ?? $passager['nom']) ?>" />
    </div>
    <div class="mb-3">
      <label for="prenom" class="form-label">Prénom</label>
      <input type="text" name="prenom" id="prenom" class="form-control" required value="<?= htmlspecialchars($_POST['prenom'] ?? $passager['prenom']) ?>" />
    </div>
    <div class="mb-3">
      <label for="telephone" class="form-label">Téléphone</label>
      <input type="text" name="telephone" id="telephone" class="form-control" value="<?= htmlspecialchars($_POST['telephone'] ?? $passager['telephone']) ?>" />
    </div>
    <div class="mb-3">
      <label for="id_reservation" class="form-label">Réservation</label>
      <select name="id_reservation" id="id_reservation" class="form-select" required>
        <option value="">-- Sélectionner une réservation --</option>
        <?php while ($res = $reservationsRes->fetch_assoc()): ?>
          <?php
            $selected = (isset($_POST['id_reservation']) && $_POST['id_reservation'] == $res['id_reservation']) ||
                        (!isset($_POST['id_reservation']) && $passager['id_reservation'] == $res['id_reservation'])
                        ? 'selected' : '';
          ?>
          <option value="<?= $res['id_reservation'] ?>" <?= $selected ?>>
            <?= htmlspecialchars("{$res['id_reservation']} - {$res['date_reservation']} ({$res['nom']} {$res['prenom']})") ?>
          </option>
        <?php endwhile; ?>
      </select>
    </div>
    <div class="mb-3">
      <label for="id_emplacement" class="form-label">emplacement (N°)</label>
      <select name="id_emplacement" id="id_emplacement" class="form-select" required>
        <option value="">-- Sélectionner un emplacement --</option>
        <?php while ($emplacement = $emplacementsRes->fetch_assoc()): ?>
          <?php
            $selected = (isset($_POST['id_emplacement']) && $_POST['id_emplacement'] == $emplacement['id_emplacement']) ||
                        (!isset($_POST['id_emplacement']) && $passager['id_emplacement'] == $emplacement['id_emplacement'])
                        ? 'selected' : '';
          ?>
          <option value="<?= $emplacement['id_emplacement'] ?>" <?= $selected ?>>
            <?= "N° " . $emplacement['numero'] ?>
          </option>
        <?php endwhile; ?>
      </select>
    </div>
    <button type="submit" class="btn btn-primary">Modifier</button>
    <a href="passager.php" class="btn btn-secondary">Annuler</a>
  </form>
</main>

<?php include('includes/footer.php'); ?>
