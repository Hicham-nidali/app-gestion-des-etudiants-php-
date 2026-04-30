<?php
require 'connexion.php';

$id = (int)($_GET['id'] ?? 0);

if ($id > 0) {
    $stmt = $conn->prepare("DELETE FROM etudiants WHERE id=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            header('Location: index.php?msg=Etudiant supprimé avec succès');
        } else {
            header('Location: index.php?msg=Etudiant pas trouvé');
        }
    } else {
        echo "Erreur : " . $conn->error;
    }
    exit;
}

$conn->close();
?>