<?php
// Connexion à la base de données

include('../private/infodb.php');

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

// Récupération de toutes les activités
$sql = "SELECT * FROM activite";
$result = $conn->query($sql);
$activites = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $activites[$row['id_activite']] = $row['intitule'];
    }
}

// Traitement du formulaire de sélection d'activité
$selectedActiviteId = isset($_POST['activite_id']) ? $_POST['activite_id'] : null;

// Récupération des participants par événement sans répétition
$participants = array();
if ($selectedActiviteId) {
    if ($selectedActiviteId == "all") {
        $sql = "SELECT participant.*, activite.intitule AS activite FROM participant
                LEFT JOIN inscription ON participant.id_participant = inscription.id_participant
                LEFT JOIN activite ON inscription.id_activite = activite.id_activite
                ORDER BY participant.nom ASC";
    } else {
        $sql = "SELECT participant.*, activite.intitule AS activite FROM participant
                INNER JOIN inscription ON participant.id_participant = inscription.id_participant
                INNER JOIN activite ON inscription.id_activite = activite.id_activite
                WHERE activite.id_activite = $selectedActiviteId
                ORDER BY participant.nom ASC";
    }
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $participants[] = $row;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
    <title>Participants</title>

    <link rel="icon" type="image/png" href="../assets/simplon-logo.png">

</head>

<body>
    <nav class="navbar">
        <img src="../assets/simplon-logo.png" width="50" height="50" alt="">
        <a class="navbar-brand" href="../index.php">
            SIMPLON CI
        </a>
        <a href="index.php">
            < Enregistrer Un Participant />
        </a>
        <a href="#">
            < Voir la Liste des Participants />
        </a>
    </nav>
    <main>
        <h1 class="titre">
            < Les Participants />
        </h1>

        <form method="POST" class="formulaire">
            <label for="activite">Sélectionnez une activité :</label>
            <div class="selection">
                <select name="activite_id" id="activite">
                    <option value="all" <?php if ($selectedActiviteId == "all")
                        echo 'selected'; ?>>Toutes les activités
                    </option>
                    <?php foreach ($activites as $id => $intitule) { ?>
                        <option value="<?php echo $id; ?>" <?php if ($selectedActiviteId == $id)
                               echo 'selected'; ?>>
                            <?php echo $intitule; ?>
                        </option>
                    <?php } ?>
                </select>
                <input type="submit" value="Afficher les participants">
            </div>
        </form>

        <?php if (!empty($participants)) { ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Nom</th>
                        <th scope="col">Prénom</th>
                        <th scope="col">Téléphone</th>
                        <th scope="col">Email</th>
                        <?php if ($selectedActiviteId == "all") { ?>
                            <th scope="col">Activité d'inscription</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($participants as $participant) { ?>
                        <tr>
                            <td>
                                <?php echo $participant['nom']; ?>
                            </td>
                            <td>
                                <?php echo $participant['prenom']; ?>
                            </td>
                            <td>
                                <?php echo $participant['telephone']; ?>
                            </td>
                            <td>
                                <?php echo $participant['email']; ?>
                            </td>
                            <?php if ($selectedActiviteId == "all") { ?>
                                <td>
                                    <?php echo $participant['activite']; ?>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>Aucun participant trouvé pour cette activité.</p>
        <?php } ?>
    </main>
</body>

</html>