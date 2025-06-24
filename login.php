<?php
session_start();
$conn = new mysqli("sql202.infinityfree.com", "if0_39302602", "jT4CeZzfz4", "if0_39302602_dbtravel");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $conn->real_escape_string($_POST['username']);
    $pwd = $_POST['password'];

    $res = $conn->query("SELECT * FROM utilisateur WHERE username='$user' AND actif=1");

    if ($r = $res->fetch_assoc()) {
        if (password_verify($pwd, $r['mot_de_passe'])) {
            $_SESSION['user'] = ['id' => $r['id_utilisateur'], 'role' => $r['role']];
            header('Location: index.php'); exit;
        } else {
            $error = "Identifiants invalides.";
        }
    } else {
        $error = "Identifiants invalides.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card mt-5">
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Connexion</h2>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>
                     <img src="image/images.png" style="width:100%;">   
                    <form method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label">Nom d'utilisateur</label>
                            <input type="text" name="username" id="username" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Se connecter</button>
                    </form>
                    <h4>created by Rekabi and Ghomari</h4>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
