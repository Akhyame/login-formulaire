<?php
// Connexion à la base de données
$host = 'localhost';
$port = '8889';
$username = 'root';
$password = 'root';
$dbname = 'utulisateurs'; // Assure-toi que la base de données est correcte

try {
    // Connexion PDO à la base de données
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;port=$port", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Récupérer les établissements depuis la base de données
$etablissements = [];
try {
    $stmt = $pdo->query("SELECT nom, adresse FROM etablissements");
    $etablissements = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p class='error'>Erreur lors de la récupération des établissements : " . $e->getMessage() . "</p>";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afficher les établissements</title>
    <style>
        body {
            /* Ajout du dégradé de couleurs de fond */
            background: linear-gradient(to right, #c25fff, #feb47b, #8E7AB5, #6a5acd);
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            text-align: center;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 900px;
        }

        h2 {
            color: #8E7AB5;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #8E7AB5;
            color: white;
        }

        .back-btn {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #8E7AB5;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .back-btn:hover {
            background-color: #6a5acd;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Liste des établissements</h2>

    <!-- Tableau des établissements -->
    <table>
        <tr>
            <th>Nom de l'établissement</th>
            <th>Adresse de l'établissement</th>
        </tr>
        <?php if (count($etablissements) > 0): ?>
            <?php foreach ($etablissements as $etablissement): ?>
                <tr>
                    <td><?= htmlspecialchars($etablissement['nom']); ?></td>
                    <td><?= htmlspecialchars($etablissement['adresse']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="2">Aucun établissement trouvé.</td>
            </tr>
        <?php endif; ?>
    </table>

    <!-- Bouton pour revenir au menu -->
    <a href="bienvenue.php">
        <button class="back-btn">Retour au menu</button>
    </a>
</div>

</body>
</html>