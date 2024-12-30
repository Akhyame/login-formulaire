<?php
session_start();

// Vérifier si l'utilisateur est autorisé
if (!isset($_SESSION["autoriser"]) || $_SESSION["autoriser"] !== "oui") {
    // Si non, rediriger vers la page de connexion
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bienvenue</title>
    <style>
        body {
            background-image: linear-gradient(to right bottom, #a280b0, #a37dac, #a37ba8, #a378a3, #a3769f);
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            flex-direction: column;
        }

        .content {
            text-align: center;
            padding: 30px;
            border-radius: 10px;
            background-color: #FAF2EA;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.3);
            margin-bottom: 20px;
        }

        h1 {
            color: #8E7AB5;
        }

        p {
            color: black;
        }

        .menu {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        .menu button {
            padding: 10px 20px;
            background-color: #8E7AB5;
            color: white;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-size: 16px;
        }

        .menu button:hover {
            background-color: deeppink;
        }

        a {
            text-decoration: none;
            color: white;
        }

        .logout button{
            margin-top: 20px;
            background-color: pink;
            width: 20%;
            color:black;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-size: 14px;
            height: 20px;




        }
    </style>
</head>
<body>

<div class="content">
    <h1>Welcome to your space !</h1>
    <p>Congratulations, you are now logged in.</p>

    <div class="menu">
        <a href="afficher_etudiant.php">
            <button>Afficher étudiants</button>
        </a>
        <a href="afficher_etablissement.php">
            <button>Afficher établissements</button>
        </a>
        <a href="ajouter_etudiant.php">
            <button>Ajouter étudiant</button>
        </a>
        <a href="ajouter_etablissement.php">
            <button>Ajouter établissement</button>
        </a>
    </div>

    <div class="logout">
        <a href="deconnexion.php">
            <button>Log out</button>
        </a>
    </div>
</div>

</body>
</html>