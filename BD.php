<?php
$host = 'localhost';
$port = '8888';
$username = 'root'; // Par défaut sous MAMP
$password = 'root'; // Par défaut sous MAMP
$dbname = 'utulisateurs'; // Nom de ta base de données


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;port=$port", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
