<?php


session_start();

include('../private/infodb.php');

// Création de la connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}

// Récupération des données du formulaire
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$telephone = $_POST['telephone'];
$email = $_POST['email'];
$formations = $_POST['formations'];

try {
    // Insertion du participant dans la table "participant"
    $sql = "INSERT INTO participant (nom, prenom, telephone, email)
            VALUES ('$nom', '$prenom', '$telephone', '$email')";
    if ($conn->query($sql) === TRUE) {
        // Récupération de l'ID du participant inséré
        $participantId = $conn->insert_id;

        // Insertion des inscriptions aux formations dans la table "inscription"
        foreach ($formations as $formationId) {
            // Vérification si le participant est déjà inscrit à la formation
            $sql = "SELECT * FROM inscription WHERE id_participant = '$participantId' AND id_activite = '$formationId'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Le participant est déjà inscrit à la formation
                throw new Exception("Le participant est déjà inscrit à cette formation.");
            } else {
                // Insertion de l'inscription dans la table "inscription"
                $sql = "INSERT INTO inscription (id_participant, id_activite)
                        VALUES ('$participantId', '$formationId')";
                if ($conn->query($sql) !== TRUE) {
                    throw new Exception("Une erreur est survenue lors de l'enregistrement de l'inscription.");
                }
            }
        }
        $_SESSION['alert_message'] = "Enregistrement effectué avec succès.";
    } else {
        throw new Exception("Une erreur est survenue lors de l'enregistrement du participant.");
    }
    header("Location: index.php");
} catch (Exception $e) {
    $_SESSION['alert_message'] = "Erreur : " . $e->getMessage() . " Veuillez réessayer.";
    header("Location: index.php");
}

$conn->close();
?>