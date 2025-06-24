<?php

$pageTitle = "Ajouter programmation";
include('includes/header.php');
include('includes/sidebar.php');

$conn = new mysqli("sql202.infinityfree.com", "if0_39302602", "jT4CeZzfz4", "if0_39302602_dbtravel");
if ($conn->connect_error) die("Erreur: " . $conn->connect_error);

$date_depart = "";
$date_retour = "";
$prix_base = "";
$id_voyage = 0;
$selected_autocars = [];
$selected_points = [];
$error = "";

// Fetch voyages, autocars, and points depart for selects
$voyages = $conn->query("SELECT id_voyage, libelle FROM voyage ORDER BY libelle");
$autocars = $conn->query("SELECT a.id_autocar, a.immatriculation, t.nom_type FROM autocar a JOIN typeautocar t ON a.id_type = t.id_type ORDER BY a.immatriculation");
$points = $conn->query("SELECT p.id_point_depart, p.lieu, v.nom AS ville_nom FROM pointdepart p JOIN ville v ON p.id_ville = v.id_ville ORDER BY p.lieu");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date_depart = $_POST['date_depart'] ?? "";
    $date_retour = $_POST['date_retour'] ?? "";
    $prix_base = $_POST['prix_base'] ?? "";
    $id_voyage = intval($_POST['id_voyage']);
    $selected_autocars = $_POST['autocars'] ?? [];
    $selected_points = $_POST['points'] ?? [];

    // Validation
    if (!$date_depart || !$date_retour || !$prix_base || $id_voyage <= 0) {
        $error = "Tous les champs sont obligatoires.";
    } else {
        $stmt = $conn->prepare("INSERT INTO programmation (date_depart, date_retour, prix_base, id_voyage) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssdi", $date_depart, $date_retour, $prix_base, $id_voyage);
        if ($stmt->execute()) {
            $id_programmation = $stmt->insert_id;

            // Insert many-to-many for autocar
            if (!empty($selected_autocars)) {
                $stmt2 = $conn->prepare("INSERT INTO Programmation_Autocar (id_programmation, id_autocar) VALUES (?, ?)");
                foreach ($selected_autocars as $id_autocar) {
                    $id_autocar = intval($id_autocar);
                    $stmt2->bind_param("ii", $id_programmation, $id_autocar);
                    $stmt2->execute();
                }
                $stmt2->close();
            }

            // Insert many-to-many for pointdepart
            if (!empty($selected_points)) {
                $stmt3 = $conn->prepare("INSERT INTO Programmation_PointDepart (id_programmation, id_point_depart) VALUES (?, ?)");
                foreach ($selected_points as $id_point) {
                    $id_point = intval($id_point);
                    $stmt3->bind_param("ii", $id_programmation, $id_point);
                    $stmt3->execute();
                }
                $stmt3->close();
            }

            header("Location: programmation.php");
            exit;
        } else {
            $error = "Erreur lors de l'ajout: " . $stmt->error;
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
      <label for="id_voyage" class="form-label">voyage</label>
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
        <?php while ($a = $autocars->fetch_assoc()): ?>
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
        <?php while ($p = $points->fetch_assoc()): ?>
          <option value="<?= $p['id_point_depart'] ?>" <?= in_array($p['id_point_depart'], $selected_points) ? 'selected' : '' ?>>
            <?= htmlspecialchars($p['lieu'] . " (" . $p['ville_nom'] . ")") ?>
          </option>
        <?php endwhile; ?>
      </select>
      <small class="form-text text-muted">Ctrl+click pour sélectionner plusieurs</small>
    </div>

    <button type="submit" class="btn btn-primary">Ajouter</button>
    <a href="programmation.php" class="btn btn-secondary">Annuler</a>
  </form>
</main>

<?php include('includes/footer.php'); ?>
