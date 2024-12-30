<?php
session_start();

// Vérifier si l'utilisateur est autorisé
if (!isset($_SESSION["autoriser"]) || $_SESSION["autoriser"] !== "oui") {
    header("Location: index.php");  // Redirige vers la page de connexion si l'utilisateur n'est pas connecté
    exit();
}

// Connexion à la base de données
include 'BD.php';

// Récupérer les utilisateurs et leurs établissements de la base de données
$utilisateurs = [];
try {
    $stmt = $pdo->query("
        SELECT utilisateurs.id, utilisateurs.login, etablissements.nom AS etablissement
        FROM utilisateurs
        JOIN etablissements ON utilisateurs.etablissement_id = etablissements.id
    ");
    $utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p class='error'>Erreur lors de la récupération des etudaints : " . $e->getMessage() . "</p>";
}

// Variables pour les messages
$message = '';
$messageType = '';  // 'success' ou 'error'

// Traitement de la suppression
if (isset($_GET['supprimer'])) {
    $id = $_GET['supprimer'];

    try {
        // Préparer et exécuter la suppression
        $stmt = $pdo->prepare("DELETE FROM utulisateurs WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Message de succès
        $message = "etudiant supprimé avec succès !";
        $messageType = 'success';
    } catch (PDOException $e) {
        $message = "Erreur lors de la suppression : " . $e->getMessage();
        $messageType = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Afficher les etudiants</title>
    <style>
        body {
            background: linear-gradient(to bottom, #F8F8FF, #8E7AB5); /* Dégradé de couleurs */
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

        .button-group {
            display: flex;
            justify-content: center;
        }

        .action-btn {
            margin: 0 5px;
            padding: 5px 10px;
            background-color: #8E7AB5;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .action-btn:hover {
            background-color: #6a5acd;
        }

        /* Messages */
        .success {
            color: green;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .error {
            color: red;
            font-weight: bold;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Liste des etudiants</h2>

    <!-- Message de succès ou d'erreur -->
    <?php if ($message): ?>
        <div class="<?= $messageType; ?>">
            <?= $message; ?>
        </div>
    <?php endif; ?>

    <table>
        <tr>
            <th>Nom de l'etudiant</th>
            <th>Établissement</th>
            <th>Actions</th>
        </tr>
        <?php if (count($utilisateurs) > 0): ?>
            <?php foreach ($utilisateurs as $utilisateur): ?>
                <tr>
                    <td><?= htmlspecialchars($utilisateur['login']); ?></td>
                    <td><?= htmlspecialchars($utilisateur['etablissement']); ?></td>
                    <td class="button-group">
                        <!-- Lien Modifier -->
                        <a href="modifier_utilisateur.php?id=<?= $utilisateur['id']; ?>&login=<?= urlencode($utilisateur['login']); ?>">
                            <button class="action-btn">Modifier</button>
                        </a>
                        <!-- Lien Supprimer -->
                        <a href="?supprimer=<?= $utilisateur['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                            <button class="action-btn">Supprimer</button>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3">Aucun etudiant trouvé</td>
            </tr>
        <?php endif; ?>
    </table>

    <a href="bienvenue.php">
        <button class="back-btn">Retour à l'accueil</button>
    </a>
</div>

</body>
</html>
</html>
