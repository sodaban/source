<?php
session_start();
ob_start();
?>
<!DOCTYPE html>
<html>


<!-- <body>
    <form method="POST" action="valideInscription.php">
        <label for="nom">Nom:</label>
        <input type="text" name="nom" id="nom" required>
        <br>
        <label for="prenom">Prénom:</label>
        <input type="text" name="prenom" id="prenom" required>
        <br>
        <label for="tournoiId1">Tournoi 1:</label>
        <input type="checkbox" name="tournoiId1" id="tournoiId1" value="11">
        <br>
        <label for="tournoiId2">Tournoi 2:</label>
        <input type="checkbox" name="tournoiId2" id="tournoiId2" value="12">
        <br>
        <label for="tournoiId3">Tournoi 3:</label>
        <input type="checkbox" name="tournoiId3" id="tournoiId3" value="13">
        <br>
        <label for="tournoiId4">Tournoi 4:</label>
        <input type="checkbox" name="tournoiId4" id="tournoiId4" value="1" <?php if (isset($_POST['tournoiId4']) && $_POST['tournoiId4'] == '0') echo 'checked'; ?>>
        <br>
        <input type="submit" value="Submit">
    </form> -->

    <?php
    // Debugging code
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    error_log("Debut de la page valideInscription.php"); // Ajoutez cette ligne

    // Récupère les valeurs passées en paramètres dans l'URL
    // $nom = isset($_GET['nom']) ? $_GET['nom'] : '';
    // $prenom = isset($_GET['prenom']) ? $_GET['prenom'] : '';
    
    // formulaireInscription.php

    if (isset($_POST['nom']) && isset($_POST['prenom'])) {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
    }

    error_log("nom: $nom, prénom: $prenom"); // Ajoutez cette ligne

    // $nom = isset($_POST['nom']) ? $_POST['nom'] : 0;
    // $prenom = isset($_POST['prenom']) ? $_POST['prenom'] : 0;
    // $tournoiId1 = isset($_POST['tournoiId1']) ? $_POST['tournoiId1'] : 0;
    // $tournoiId2 = isset($_POST['tournoiId2']) ? $_POST['tournoiId2'] : 0;
    // $tournoiId3 = isset($_POST['tournoiId3']) ? $_POST['tournoiId3'] : 0;
    // $tournoiId4 = isset($_POST['tournoiId4']) ? $_POST['tournoiId4'] : 0;
    $tournois = [];
    $tournois = isset($_POST['tournoi']) ? $_POST['tournoi'] : 0;
    error_log("Tournois sélectionnés : " . print_r($tournois, true)); // Ajoutez cette ligne
    // error_log("nom: $nom, prénom: $prenom, tournoiId1: $tournoiId1, tournoiId2: $tournoiId2, tournoiId3: $tournoiId3, tournoiId4: $tournoiId4"); // Ajoutez cette ligne
    $db = new SQLite3('petanqueLPP.db');

    // Création des tables si elles n'existent pas encore
    $db->exec("CREATE TABLE IF NOT EXISTS adherents (id INTEGER PRIMARY KEY, nom TEXT, prenom TEXT, email TEXT, date_inscription TEXT, matricule INTEGER)");
    $db->exec("CREATE TABLE IF NOT EXISTS tournois (id INTEGER PRIMARY KEY, nom TEXT, date TEXT, time TEXT, nom_joueurs_max INT, type TEXT, etat INTEGER)");
    $db->exec("CREATE TABLE IF NOT EXISTS participants (id INTEGER PRIMARY KEY, adherentId INTEGER, tournoiId1 INTEGER, tournoiId2 INTEGER, tournoiId3 INTEGER, tournoiId4 INTEGER)");

    if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] === "POST") {
        error_log("Le formulaire a ete soumis"); // Ajoutez cette ligne

        // Inscription d'un nouveau participant au tournoi
        error_log("Inscription d'un nouveau participant: " . print_r($_POST, true)); // Ajoutez cette ligne
        // mettre $_POST dans tournoiId1, tournoiId2, tournoiId3, tournoiId4 
        $tournoiId1 = $tournois[0];
        $tournoiId2 = $tournois[1];
        $tournoiId3 = $tournois[2];
        $tournoiId4 = $tournois[3];

        
        error_log("nom: $nom, prénom: $prenom, tournoiId1: $tournoiId1, tournoiId2: $tournoiId2, tournoiId3: $tournoiId3, tournoiId4: $tournoiId4"); // Ajoutez cette ligne

        // Récupérer l'ID de l'adhérent à partir du nom et du prénom
        $stmt = $db->prepare("SELECT id FROM adherents WHERE LOWER(nom) = LOWER(?) AND LOWER(prenom) = LOWER(?)");
        $stmt->bindValue(1, $nom, SQLITE3_TEXT);
        $stmt->bindValue(2, $prenom, SQLITE3_TEXT);
        $adherentIdResult = $stmt->execute();
        $adherentIdRow = $adherentIdResult->fetchArray();
        error_log("adherent result : " . print_r($adherentIdRow, true)); // Ajoutez cette ligne
        error_log("nom: $nom, prénom: $prenom, tournoiId1: $tournoiId1, tournoiId2: $tournoiId2, tournoiId3: $tournoiId3, tournoiId4: $tournoiId4"); // Ajoutez cette ligne

        // Vérifier si le participant aux tournois fait partie des adherents du club
        if ($adherentIdRow) {
            $adherentId = $adherentIdRow['id'];
            error_log("ID de l'adherent: $adherentId" . " Adherent trouve dans la table adherents"); // Adherent trouvé dans la base de données

            // Il faut vérifier si le participant est déjà inscrit à ces tournois
            $stmt = $db->prepare("SELECT * FROM participants WHERE adherentId = ?");
            $stmt->bindValue(1, $adherentId, SQLITE3_INTEGER);
            $participantResult = $stmt->execute();

            // Vérifier chaque enregistrement de la table participants
            while ($participantRow = $participantResult->fetchArray()) {
                // Afficher les colonnes de la table participants
                foreach ($participantRow as $key => $value) {
                    error_log("Colonne : $key, Valeur : $value"); // Ajoutez cette ligne
                }

                // Vérifier si l'adhérent est déjà inscrit aux tournois
                $stmt = $db->prepare("SELECT * FROM participants WHERE adherentId = ?");
                $stmt->bindValue(1, $adherentId, SQLITE3_INTEGER);
                $participantResult = $stmt->execute();

                // Vérifier si l'adhérent est déjà inscrit
                if ($participantRow = $participantResult->fetchArray()) {
                    error_log("Adherent deja inscrit aux tournois, prend en compte ses nouveaux choix"); // Ajoutez cette ligne
                    error_log("nom: $nom, prénom: $prenom, tournoiId1: $tournoiId1, tournoiId2: $tournoiId2, tournoiId3: $tournoiId3, tournoiId4: $tournoiId4"); // Ajoutez cette ligne
                    // Mettre à jour les tournois existants avec les nouvelles valeurs
                    $db->exec("UPDATE participants SET tournoiId1 = '$tournoiId1', tournoiId2 = '$tournoiId2', tournoiId3 = '$tournoiId3', tournoiId4 = '$tournoiId4' WHERE adherentId = '$adherentId'");
                    header("Location: successInscription.html");
                    $_SESSION['message'] = "Adherent deja inscrit, prend en compte ses nouveaux choix";
                    exit();
                } else {
                    error_log("Adherent inscrit pour la premiere fois, prend en compte ses tournois"); // Ajoutez cette ligne
                    error_log("nom: $nom, prénom: $prenom, tournoiId1: $tournoiId1, tournoiId2: $tournoiId2, tournoiId3: $tournoiId3, tournoiId4: $tournoiId4"); // Ajoutez cette ligne
                    // Insérer un nouvel enregistrement dans la table participants
                    $db->exec("INSERT INTO participants (adherentId, tournoiId1, tournoiId2, tournoiId3, tournoiId4) VALUES ('$adherentId', '$tournoiId1', '$tournoiId2', '$tournoiId3', '$tournoiId4')");
                    header("Location: successInscription.html");
                    exit();
                }
            }

            // Si l'adhérent n'est pas déjà inscrit, on ajoute un nouvel enregistrement dans la table participants
            error_log("Adherent inscrit pour la premiere fois, prend en compte ses tournois"); // Ajoutez cette ligne
            $db->exec("INSERT INTO participants (adherentId, tournoiId1, tournoiId2, tournoiId3, tournoiId4) VALUES ('$adherentId', '$tournoiId1', '$tournoiId2', '$tournoiId3', '$tournoiId4')");
            error_log("Insertion reussie"); // Ajoutez cette ligne
            header('Location: ' . $_SERVER['PHP_SELF']);
            header("Location: successInscription.html");
            exit();
        } else {
            $adherentId = null; // or handle the case when no row is found
            error_log("Adherent non trouve dans le base de donnee"); // Ajoutez cette ligne
            // ici il faut retourner à la page précédente avec un message d'erreur
            header("Location: formulaireInscription.php");
            $_SESSION['message'] = "Adherent non trouve dans le base de donnee";
            exit();
        }
        $_SESSION['message'] = "Adherent non trouve dans le base de donnee";
        error_log("ID de l'adherent: $adherentId"); // Ajoutez un participant avec les tournois sélectionnés
        if ($adherentId) {
            $db->exec("INSERT INTO participants (adherentId, tournoiId1, tournoiId2, tournoiId3, tournoiId4) VALUES ('$adherentId', '$tournoiId1', '$tournoiId2', '$tournoiId3', '$tournoiId4')");
            error_log("Insertion reussie"); // Ajoutez cette ligne
            header('Location: ' . $_SERVER['PHP_SELF']);
            header("Location: successInscription.html");
            exit();
        } else {
            header("Location: formulaireInscription.php");
            $_SESSION['message'] = "Insertion dans la base de donnees non reussie";
            error_log("Insertion dans la base de donnees non reussie"); // Ajoutez cette ligne
            exit();
        }
        exit;
    } else {
        $_SESSION['message'] = "Les donnees du formulaire ne sont pas valides";
        error_log("Les donnees du formulaire ne sont pas valides");  // Ajoutez cette ligne
    }
    ?>
</body>';

</html>