<?php
require 'connexion.php';

$page = (int)($_GET['page'] ?? 1);
$parpage = 5;
$offset = ($page - 1) * $parpage;

$stmt = $conn->prepare("SELECT * FROM etudiants ORDER BY id DESC LIMIT ? OFFSET ?");
$stmt->bind_param("ii", $parpage, $offset);
$stmt->execute();
$etudiants = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$total = $conn->query("SELECT COUNT(*) FROM etudiants")->fetch_row()[0];
$nbPages = ceil($total / $parpage);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Etudiants</title>
</head>
<body>
    <h1>PAGE de Gestion des Etudiants</h1>

    <?php if (isset($_GET['msg'])): ?>
        <div><?= htmlspecialchars($_GET['msg']) ?></div>
    <?php endif; ?>

    <a href="ajouter.php">+ Ajouter un Etudiant</a>

    <table >
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prenom</th>
            <th>Email</th>
            <th>Filiere</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($etudiants as $et): ?>
        <tr>
            <td><?= htmlspecialchars($et['id']) ?></td>
            <td><?= htmlspecialchars($et['nom']) ?></td>
            <td><?= htmlspecialchars($et['prenom']) ?></td>
            <td><?= htmlspecialchars($et['email']) ?></td>
            <td><?= htmlspecialchars($et['filiere']) ?></td>
            <td>
                <a href="modifier.php?id=<?= $et['id'] ?>">Modifier</a>
                <a href="supprimer.php?id=<?= $et['id'] ?>" onclick="return confirm('Supprimer cet étudiant ?')">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <div>
        <?php for ($i = 1; $i <= $nbPages; $i++): ?>
            <a href="?page=<?= $i ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>

</body>
</html>
<?php $conn->close(); ?>