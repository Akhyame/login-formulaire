<?php
// Connexion à la base de données
include'BD.php';

// Variables pour le formulaire
$login = $etablissement_id = "";
$erreur = "";

// Récupérer la liste des établissements
$etablissements = [];
try {
    $stmt = $pdo->query("SELECT id, nom FROM etablissements");
    $etablissements = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p>Erreur lors de la récupération des établissements : " . $e->getMessage() . "</p>";
}

// Lorsque le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $etablissement_id = $_POST['etablissement'];

    // Vérification des champs
    if (empty($login) || empty($etablissement_id)) {
        $erreur = "Tous les champs doivent être remplis.";
    } else {
        // Insertion de l'étudiant dans la table 'utilisateurs'
        try {
            // Pas besoin de 'pass' ici puisque tu ne demandes pas de mot de passe
            $stmt = $pdo->prepare("INSERT INTO utilisateurs (login, etablissement_id) VALUES (:login, :etablissement_id)");
            $stmt->bindParam(':login', $login);
            $stmt->bindParam(':etablissement_id', $etablissement_id);
            $stmt->execute();
            $message = "L'étudiant a été ajouté avec succès !";
        } catch (PDOException $e) {
            $erreur = "Erreur lors de l'ajout de l'étudiant : " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un étudiant</title>
    <style>
        body {
            /* Ajout du dégradé de fond */
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
            max-width: 600px;
        }

        h2 {
            color: #8E7AB5;
        }

        .form-input {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            width: 100%;
        }

        button {
            padding: 10px 20px;
            background-color: #8E7AB5;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #6a5acd;
        }

        .error {
            color: red;
            margin-top: 10px;
        }

        .success {
            color: green;
            margin-top: 10px;
        }

        /* Stylisation pour le bouton "Retour au menu" */
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
    <h2>Ajouter un étudiant</h2>

    <!-- Formulaire d'ajout d'étudiant -->
    <form method="POST" action="">
        <label for="login">Nom de l'etudiant :</label><br>
        <input type="text" id="login" name="login" class="form-input" value="<?= htmlspecialchars($login); ?>" required><br><br>

        <label for="etablissement">Choisir une établissement :</label><br>
        <select name="etablissement" id="etablissement" class="form-input" required>
            <option value="">Sélectionner un établissement</option>
            <?php foreach ($etablissements as $etablissement): ?>
                <option value="<?= $etablissement['id']; ?>" <?= ($etablissement['id'] == $etablissement_id) ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($etablissement['nom']); ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <button type="submit">Ajouter l'étudiant</button>
    </form>

    <?php if (!empty($erreur)): ?>
        <p class="error"><?= $erreur; ?></p>
    <?php elseif (isset($message)): ?>
        <p class="success"><?= $message; ?></p>
    <?php endif; ?>

    <br>
    <!-- Bouton retour -->
    <a href="bienvenue.php">
        <button class="back-btn">Retour au menu</button>
    </a>
</div>

</body>
</html>