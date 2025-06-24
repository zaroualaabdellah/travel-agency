<?php
$pageTitle = "Gestion des pays";
include('includes/header.php');
include('includes/sidebar.php');

// DB Connection
$conn = new mysqli("sql202.infinityfree.com", "if0_39302602", "jT4CeZzfz4", "if0_39302602_dbtravel");
if ($conn->connect_error) die("Erreur: " . $conn->connect_error);

// Handle Delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM pays WHERE id_pays = $id");
    header("Location: pays.php");
    exit;
}

// Fetch all countries
$pays = $conn->query("SELECT * FROM pays ORDER BY id_pays DESC");
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="topbar d-flex justify-content-between align-items-center">
        <h4><?php echo $pageTitle; ?></h4>
        <a href="pays_add.php" class="btn btn-primary btn-sm">Ajouter un pays</a>
    </div>

    <div class="content mt-4">
        <table id="paysTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $pays->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id_pays'] ?></td>
                        <td><?= htmlspecialchars($row['nom']) ?></td>
                        <td>
                            <a href="pays_edit.php?id=<?= $row['id_pays'] ?>" class="btn btn-sm btn-warning">Modifier</a>
                            <a href="?delete=<?= $row['id_pays'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ce pays ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</main>

<?php include('includes/footer.php'); ?>