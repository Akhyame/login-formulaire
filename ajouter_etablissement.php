<?php
// Connexion à la base de données
$host = 'localhost';
$port = '8889';
$username = 'root';
$password = 'root';
$dbname = 'utulisateurs'; // Assure-toi que c'est bien 'utulisateurs'

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;port=$port", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $adresse = $_POST['adresse'];

    if (!empty($nom) && !empty($adresse)) {
        // Préparer et exécuter la requête d'insertion
        try {
            $stmt = $pdo->prepare("INSERT INTO etablissements (nom, adresse) VALUES (:nom, :adresse)");
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':adresse', $adresse);
            $stmt->execute();

            $message = "L'établissement a été ajouté avec succès !";
            $messageType = 'success';
        } catch (PDOException $e) {
            $message = "Erreur lors de l'ajout de l'établissement : " . $e->getMessage();
            $messageType = 'error';
        }
    } else {
        $message = "Veuillez remplir tous les champs.";
        $messageType = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un établissement</title>
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
            max-width: 900px;
        }

        h2 {
            color: #8E7AB5;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"], input[type="textarea"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            padding: 10px 20px;
            background-color: #8E7AB5;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #6a5acd;
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

        .message {
            font-weight: bold;
            margin-top: 20px;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Ajouter un établissement</h2>

    <!-- Formulaire d'ajout -->
    <form method="POST" action="">
        <label for="nom">Nom de l'établissement</label>
        <input type="text" name="nom" id="nom" required>

        <label for="adresse">Adresse de l'établissement</label>
        <input type="text" name="adresse" id="adresse" required>

        <button type="submit">Ajouter l'établissement</button>
    </form>

    <!-- Affichage du message de succès ou d'erreur -->
    <?php if (isset($message)): ?>
        <div class="message <?php echo $messageType; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <!-- Bouton de retour au menu -->
    <a href="bienvenue.php">
        <button class="back-btn">Retour au menu</button>
    </a>

</div>

</body>
</html>