<?php
// Connexion à la base de données (assure-toi que les paramètres sont corrects)
$host = 'localhost';
$port = '8889';
$username = 'root'; // Par défaut sous MAMP
$password = 'root'; // Par défaut sous MAMP
$dbname = 'utulisateurs'; // Nom de ta base de données

// Essaie de se connecter à la base de données avec PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;port=$port", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

session_start();

// Déclaration des variables de formulaire
@$login = $_POST["login"];
@$pass = $_POST["pass"];
@$valider = $_POST["valider"];
$erreur = "";

// Quand le formulaire est soumis
if (isset($valider)) {
    // Vérifier que les champs ne sont pas vides
    if (!empty($login) && !empty($pass)) {
        // Hacher le mot de passe
        $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

        // Insérer les données dans la base de données
        try {
            $stmt = $pdo->prepare("INSERT INTO utilisateurs (login, pass) VALUES (:login, :pass)");
            $stmt->bindParam(':login', $login);
            $stmt->bindParam(':pass', $hashed_pass);
            if ($stmt->execute()) {
                $_SESSION["autoriser"] = "oui";

                // Redirection vers la page bienvenue.php
                header("Location: bienvenue.php");
                exit(); // Toujours appeler exit() après header pour éviter tout code supplémentaire.
            } else {
                echo "<p class='error'>Erreur lors de l'enregistrement de vos informations.</p>";
            }
        } catch (PDOException $e) {
            echo "<p class='error'>Erreur de base de données : " . $e->getMessage() . "</p>";
        }
    } else {
        $erreur = "Veuillez remplir tous les champs.";
        echo "<p class='error'>$erreur</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <style>
        body {
            background-image: linear-gradient(to right bottom, #a280b0, #a37dac, #a37ba8, #a378a3, #a3769f);
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #FAF2EA;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.3);
            width: 400px;
            text-align: center;
            margin-top: 30px;
            margin-bottom: 30px;
            height: auto;
        }

        h2 {
            text-align: center;
            color:#8E7AB5;
            font-size: 40px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-size: 18px;
            color: #333;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color:  #8E7AB5;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: hotpink;
        }

        .error {
            color: deeppink;
            text-align: center;
            margin-top: 10px;
        }

        .logo {
            width: 100%;
            margin-bottom: 10px;
            margin-top: 5px;
        }
        img {
            border-radius:
                    50% 50% 50% 50% ;
        }
    </style>
</head>
<body>
<div class="login-container">
    <img src="logo.png.jpg" alt="Logo" class="logo">
    <h2>Connexion</h2>
    <form method="POST" action="">
        <label for="login">Nom d'utilisateur</label>
        <input type="text" name="login" id="login" required>
        <label for="pass">Mot de passe</label>
        <input type="password" name="pass" id="pass" required>
        <button type="submit" name="valider">Se connecter</button>
    </form>
</div>
</body>
</html>