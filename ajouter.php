<?php
require 'connexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom     = trim($_POST['nom']);
    $prenom  = trim($_POST['prenom']);
    $email   = trim($_POST['email']);
    $filiere = $_POST['filiere'];

    $stmt = $conn->prepare("INSERT INTO etudiants (nom, prenom, email, filiere) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nom, $prenom, $email, $filiere);

    if ($stmt->execute()) {
        $nouveauId = $conn->insert_id;
        echo "L'etudiant etait ajouter avec succes avec id : " . $nouveauId;
        header('Location: index.php?msg=Etudiant ajouté avec succès');
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
    <title>Ajouter un Etudiant</title>
</head>
<body>
    <h2>Ajouter un Etudiant</h2>
    <form method="POST">
        <label>Nom :</label><br>
        <input type="text" name="nom" placeholder="Nom" required><br><br>

        <label>Prenom :</label><br>
        <input type="text" name="prenom" placeholder="Prenom" required><br><br>

        <label>Email :</label><br>
        <input type="text" name="email" placeholder="Email" required><br><br>

        <label>Filiere :</label><br>
        <select name="filiere">
            <option value="S2IA">S2IA</option>
            <option value="IIIA">IIIA</option>
        </select><br><br>

        <button type="submit">Ajouter</button>
    </form>
    <br><a href="index.php">← Retour à la liste</a>
</body>
</html>
<?php $conn->close(); ?>