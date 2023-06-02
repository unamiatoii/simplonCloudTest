<?php
session_start();

if (isset($_SESSION['alert_message'])) {
    echo '<script>alert("'.$_SESSION['alert_message'].'");</script>';
    unset($_SESSION['alert_message']);
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">
<script src="script.js"></script>

    <title>Plateforme d'enregistrement Simplon</title>
    
    <link rel="icon" type="image/png" href="../assets/simplon-logo.png">
    
</head>

<body>
     <nav class="navbar">
        <img src="assets/simplon-logo.png" width="50" height="50" alt="">
        <a class="navbar-brand" href="index.php">
            SIMPLON CI
        </a>
        <a href="#">< Enregistrer Un Participant /></a>
        <a href="enregistrement.php">< Voir la Liste des Participants /></a>
    </nav>

<main>
<h1 class="titre">< Enregistrez Vous Ici ! /></h1>

<div class="container-fluid">
    
    <form method="POST" action="enregistrer.php" class="form">
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" required><br>

        <label for="prenom">Prénom:</label>
        <input type="text" id="prenom" name="prenom" required><br>

        <label for="telephone">Téléphone:</label>
        <input type="tel" id="telephone" name="telephone" class="form-control" required><br>

        <label for="email">Adresse email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="evenement">Evenements:</label><br>
        <div class="list-formation">

        <?php
         
         
        // Connexion à la base de données
        include('../private/infodb.php');
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Vérification de la connexion
        if ($conn->connect_error) {
            die("La connexion a échoué: " . $conn->connect_error);
        }

        // Récupération des formations depuis la base de données
        $sql = "SELECT * FROM activite";
        
        $result = $conn->query($sql);
        
        // Affichage des cases à cocher pour chaque formation
        
        if ($result->num_rows > 0) {
             while ($row = $result->fetch_assoc()) {
                echo '<div class="formation-div">';
                echo '<input type="checkbox" id="formation' . $row['id_activite'] . '" name="formations[]" value="' . $row['id_activite'] . '">';
                echo '<label for="formation'  . $row['id_activite'] . '">' . $row['intitule'] . '</label><br>';
                echo '</div>';
            }
        }   
             $conn->close();
            
        ?>

        </div>
        
        <input type="submit" value="Enregistrer" class="submit" onclick="showAlert()">
    </form>
</div>

</main>

<script>
function showAlert() {
    alert("Valider vos choix. Vous ne pourrez plus revenir en arriere");
}
</script>
</body>

<footer>
<a href="https://japhetpierrekonan.netlify.app">
        @unamiatoii
</a>
</footer>
   
</html>
