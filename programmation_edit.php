<?php

$pageTitle = "Modifier Programmation";
include('includes/header.php');
include('includes/sidebar.php');

$conn = new mysqli("localhost", "root", "", "dbtravel");
if ($conn->connect_error) die("Erreur: " . $conn->connect_error);

if (!isset($_GET['id'])) {
    header("Location: programmation.php");
    exit;
}

$id = intval($_GET['id']);
$error = "";

// Fetch existing programmation data
$stmt = $conn->prepare("SELECT * FROM Programmation WHERE id_programmation = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    header("Location: programmation.php");
    exit;
}
$prog = $result->fetch_assoc();
$stmt->close();

$date_depart = $prog['date_depart'];
$date_retour = $prog['date_retour'];
$prix_base = $prog['prix_base'];
$id_voyage = $prog['id_voyage'];

// Fetch voyages, autocars, and points depart for selects
$voyages = $conn->query("SELECT id_voyage, libelle FROM Voyage ORDER BY libelle");
$autocars = $conn->query("SELECT a.id_autocar, a.immatriculation, t.nom_type FROM Autocar a JOIN TypeAutocar t ON a.id_type = t.id_type ORDER BY a.immatriculation");
$points = $conn->query("SELECT p.id_point_depart, p.lieu, v.nom AS ville_nom FROM PointDepart p JOIN Ville v ON p.id_ville = v.id_ville ORDER BY p.lieu");

// Fetch selected autocars and points
$selected_autocars = [];
$res1 = $conn->query("SELECT id_autocar FROM Programmation_Autocar WHERE id_programmation = $id");
while ($row = $res1->fetch_assoc()) {
    $selected_autocars[] = $row['id_autocar'];
}
$selected_points = [];
$res2 = $conn->query("SELECT id_point_depart FROM Programmation_PointDepart WHERE id_programmation = $id");
while ($row = $res2->fetch_assoc()) {
    $selected_points[] = $row['id_point_depart'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date_depart = $_POST['date_depart'] ?? "";
    $date_retour = $_POST['date_retour'] ?? "";
    $prix_base = $_POST['prix_base'] ?? "";
    $id_voyage = intval($_POST['id_voyage']);
    $selected_autocars = $_POST['autocars'] ?? [];
    $selected_points = $_POST['points'] ?? [];

    if (!$date_depart || !$date_retour || !$prix_base || $id_voyage <= 0) {
        $error = "Tous les champs sont obligatoires.";
    } else {
        // Update Programmation
        $stmt = $conn->prepare("UPDATE Programmation SET date_depart = ?, date_retour = ?, prix_base = ?, id_voyage = ? WHERE id_programmation = ?");
        $stmt->bind_param("ssdii", $date_depart, $date_retour, $prix_base, $id_voyage, $id);
        if ($stmt->execute()) {
            // Update many-to-many autocars
            $conn->query("DELETE FROM Programmation_Autocar WHERE id_programmation = $id");
            if (!empty($selected_autocars)) {
                $stmt2 = $conn->prepare("INSERT INTO Programmation_Autocar (id_programmation, id_autocar) VALUES (?, ?)");
                foreach ($selected_autocars as $id_autocar) {
                    $id_autocar = intval($id_autocar);
                    $stmt2->bind_param("ii", $id, $id_autocar);
                    $stmt2->execute();
                }
                $stmt2->close();
            }

            // Update many-to-many points depart
            $conn->query("DELETE FROM Programmation_PointDepart WHERE id_programmation = $id");
            if (!empty($selected_points)) {
                $stmt3 = $conn->prepare("INSERT INTO Programmation_PointDepart (id_programmation, id_point_depart) VALUES (?, ?)");
                foreach ($selected_points as $id_point) {
                    $id_point = intval($id_point);
                    $stmt3->bind_param("ii", $id, $id_point);
                    $stmt3->execute();
                }
                $stmt3->close();
            }

            header("Location: programmation.php");
            exit;
        } else {
            $error = "Erreur lors de la mise à jour: " . $stmt->error;
        }
        $stmt->close();
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
      <label for="date_depart" class="form-label">Date de départ</label>
      <input type="date" id="date_depart" name="date_depart" class="form-control" required value="<?= htmlspecialchars($date_depart) ?>">
    </div>

    <div class="mb-3">
      <label for="date_retour" class="form-label">Date de retour</label>
      <input type="date" id="date_retour" name="date_retour" class="form-control" required value="<?= htmlspecialchars($date_retour) ?>">
    </div>

    <div class="mb-3">
      <label for="prix_base" class="form-label">Prix de base (€)</label>
      <input type="number" step="0.01" id="prix_base" name="prix_base" class="form-control" required value="<?= htmlspecialchars($prix_base) ?>">
    </div>

    <div class="mb-3">
      <label for="id_voyage" class="form-label">Voyage</label>
      <select id="id_voyage" name="id_voyage" class="form-select" required>
        <option value="">-- Choisir un voyage --</option>
        <?php while ($v = $voyages->fetch_assoc()): ?>
          <option value="<?= $v['id_voyage'] ?>" <?= ($v['id_voyage'] == $id_voyage) ? 'selected' : '' ?>>
            <?= htmlspecialchars($v['libelle']) ?>
          </option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Autocars (plusieurs possibles)</label>
      <select name="autocars[]" class="form-select" multiple size="5">
        <?php
        // Reset result pointer before looping
        $autocars->data_seek(0);
        while ($a = $autocars->fetch_assoc()): ?>
          <option value="<?= $a['id_autocar'] ?>" <?= in_array($a['id_autocar'], $selected_autocars) ? 'selected' : '' ?>>
            <?= htmlspecialchars($a['immatriculation'] . " (" . $a['nom_type'] . ")") ?>
          </option>
        <?php endwhile; ?>
      </select>
      <small class="form-text text-muted">Ctrl+click pour sélectionner plusieurs</small>
    </div>

    <div class="mb-3">
      <label class="form-label">Points de départ (plusieurs possibles)</label>
      <select name="points[]" class="form-select" multiple size="5">
        <?php
        $points->data_seek(0);
        while ($p = $points->fetch_assoc()): ?>
          <option value="<?= $p['id_point_depart'] ?>" <?= in_array($p['id_point_depart'], $selected_points) ? 'selected' : '' ?>>
            <?= htmlspecialchars($p['lieu'] . " (" . $p['ville_nom'] . ")") ?>
          </option>
        <?php endwhile; ?>
      </select>
      <small class="form-text text-muted">Ctrl+click pour sélectionner plusieurs</small>
    </div>

    <button type="submit" class="btn btn-primary">Modifier</button>
    <a href="programmation.php" class="btn btn-secondary">Annuler</a>
  </form>
</main>

<?php include('includes/footer.php'); ?>
