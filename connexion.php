<?php 
$servername = "localhost";
$username = "hicham";
$password = "password123"; 
$dbname = "gestion_etudiants";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

echo "Connexion réussie";
?>




?>