<?php
// Configuration de la base de données MySQL
$host = "localhost";
$dbname = "utsa_db";
$username = "root";
$password = ""; // Par défaut sous XAMPP/WAMP, le mot de passe est vide

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Configurer l'affichage des erreurs PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (\PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>