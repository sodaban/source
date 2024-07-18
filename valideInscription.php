<!DOCTYPE html>
<html>
<?php
ob_start();
// formulaireInscription1.php
session_start();
$db = new SQLite3('petanqueLPP.db');

// Création des tables si elles n'existent pas encore
$db->exec("CREATE TABLE IF NOT EXISTS adherents (id INTEGER PRIMARY KEY, nom TEXT, prenom TEXT, email TEXT, date_inscription TEXT, matricule INTEGER)");
$db->exec("CREATE TABLE IF NOT EXISTS tournois (id INTEGER PRIMARY KEY, nom TEXT, date TEXT, time TEXT, nom_joueurs_max INT, type TEXT, etat INTEGER)");
$db->exec("CREATE TABLE IF NOT EXISTS participants (id INTEGER PRIMARY KEY, adherentId INTEGER, tournoiId1 INTEGER, tournoiId2 INTEGER, tournoiId3 INTEGER, tournoiId4 INTEGER)");

if ($_SERVER["REQUEST_METHOD"] === "POST")
{
    error_log("Le formulaire a été soumis"); // Ajoutez cette ligne

    // Inscription d'un nouveau participant
    error_log("Inscription d'un nouveau participant");
    if(isset($_POST['nom'], $_POST['prenom'], $_POST['tournoiId1'], $_POST['tournoiId2'], $_POST['tournoiId3'], $_POST['tournoiId4'])) {
        error_log("Les données du formulaire sont présentes");  // Ajoutez cette ligne
        header("Location: successInscription.html");
        $nom = SQLite3::escapeString($_POST['nom']);
        $prenom = SQLite3::escapeString($_POST['prenom']);
        $tournoiId1 = SQLite3::escapeString($_POST['tournoiId1']);
        $tournoiId2 = SQLite3::escapeString($_POST['tournoiId2']);
        $tournoiId3 = SQLite3::escapeString($_POST['tournoiId3']);
        $tournoiId4 = SQLite3::escapeString($_POST['tournoiId4']);

        // Récupérer l'ID du membre à partir du nom et du prénom
        $adherentIdResult = $db->query("SELECT id FROM adherents WHERE nom='$nom' AND prenom='$prenom'");
        $adherentIdRow = $adherentIdResult->fetchArray();
        $adherentId = $adherentIdRow['id'];

        if($adherentId) {
            $db->exec("INSERT INTO participants (adherentId, tournoiId1, tournoiId2, tournoiId3, tournoiId4) VALUES ('$adherentId', '$tournoiId1', '$tournoiId2', '$tournoiId3', '$tournoiId4')");
            error_log("Insertion réussie"); // Ajoutez cette ligne
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();
        } else {
            $_SESSION['message'] = "Vous n'êtes pas dans la liste des adhérents";
            error_log("Adhérent non trouvé, message d'erreur défini."); // Ajoutez cette ligne
        }
        exit;
    } 
    else {
        // No checkbox is checked, display error message
        echo "<script>
            console.log('Aucun tournoi n\'a été coché');
            document.addEventListener('DOMContentLoaded', function() {
                var errorMessage = document.getElementById('error-message');
                if (errorMessage) {
                    errorMessage.textContent = 'Veuillez cocher le(s) tournoi(s) désiré(s) !';
                    errorMessage.style.display = 'block';
                }
            });
        </script>";
    }
}

// Affichage des participants pour chaque tournoi
$result = $db->query("SELECT adherentId, COUNT(*) as count FROM participants GROUP BY adherentId");
error_log("Recuperation des participants pour chaque tournoi");
?>


</html>