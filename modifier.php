<?php
require 'connexion.php';

$id = (int)($_GET['id'] ?? 0);


$stmt = $conn->prepare("SELECT * FROM etudiants WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$etudiant = $stmt->get_result()->fetch_assoc();

if (!$etudiant) {
    echo 'Etudiant introuvable';
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id      = (int)$_POST['id'];
    $nom     = trim($_POST['nom']);
    $prenom  = trim($_POST['prenom']);
    $email   = trim($_POST['email']);
    $filiere = $_POST['filiere'];

    $stmt = $conn->prepare("UPDATE etudiants SET nom=?, prenom=?, email=?, filiere=? WHERE id=?");
    $stmt->bind_param("ssssi", $nom, $prenom, $email, $filiere, $id);

    if ($stmt->execute()) {
        header('Location: index.php?msg=Etudiant modifié avec succès');
        exit;
    } else {
        echo "Erreur : " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un Etudiant</title>
</head>
<body>
    <h2>Modifier un Etudiant</h2>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $etudiant['id'] ?>">

        <label>Nom :</label><br>
        <input type="text" name="nom" value="<?= htmlspecialchars($etudiant['nom']) ?>" required><br><br>

        <label>Prenom :</label><br>
        <input type="text" name="prenom" value="<?= htmlspecialchars($etudiant['prenom']) ?>" required><br><br>

        <label>Email :</label><br>
        <input type="text" name="email" value="<?= htmlspecialchars($etudiant['email']) ?>" required><br><br>

        <label>Filiere :</label><br>
        <select name="filiere">
            <option value="S2IA" <?= $etudiant['filiere'] === 'S2IA' ? 'selected' : '' ?>>S2IA</option>
            <option value="IIIA" <?= $etudiant['filiere'] === 'IIIA' ? 'selected' : '' ?>>IIIA</option>
        </select><br><br>

        <button type="submit">Modifier</button>
    </form>
    <br><a href="index.php">← Retour à la liste</a>
</body>
</html>
<?php $conn->close(); ?>
