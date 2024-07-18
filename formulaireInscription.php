<?php
ob_start();
// formulaireInscription.php
session_start();
$db = new SQLite3('petanqueLPP.db');

// Création des tables si elles n'existent pas encore
$db->exec("CREATE TABLE IF NOT EXISTS adherents (id INTEGER PRIMARY KEY, nom TEXT, prenom TEXT, email TEXT, date_inscription TEXT, matricule INTEGER)");
$db->exec("CREATE TABLE IF NOT EXISTS tournois (id INTEGER PRIMARY KEY, nom TEXT, date TEXT, time TEXT, nom_joueurs_max INT, type TEXT, etat INTEGER)");
$db->exec("CREATE TABLE IF NOT EXISTS participants (id INTEGER PRIMARY KEY, adherentId INTEGER, tournoiId1 INTEGER, tournoiId2 INTEGER, tournoiId3 INTEGER, tournoiId4 INTEGER)");

if ($_SERVER["REQUEST_METHOD"] === "POST")
{
    // Inscription d'un nouveau participant
    error_log("Inscription d'un nouveau participant");
    if(isset($_POST['nom'], $_POST['prenom'], $_POST['tournoiId1'], $_POST['tournoiId2'], $_POST['tournoiId3'], $_POST['tournoiId4'])) {
        error_log("Les données du formulaire sont présentes");  // Ajoutez cette ligne
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
    }
}

// Affichage des participants pour chaque tournoi
$result = $db->query("SELECT adherentId, COUNT(*) as count FROM participants GROUP BY adherentId");
error_log("Recuperation des participants pour chaque tournoi");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formulaire d'inscription</title>
    <style>
        body {
            background-color: black;
            color: white;
        }
        a {
            color: white;
        }
        .form-container {
            margin-top: 200px; /* Ajoutez une marge en haut pour éviter que le logo ne chevauche le formulaire */
            margin-left: 30.00%; /* Déplace le conteneur vers la droite de 2/3 de l'écran */
        }
        
        #error-message {
            display: none;
            color: red;
        }
        #success-message {
            display: none;
            background-color: lightgreen;
            color: darkgreen;
        }
        .disabled-link {
            pointer-events: none;
            color: grey;
        }
    </style>
    <script>
        function validateForm() {
            error_log("Validation forme appelée")
            var nom = document.getElementById('nom').value;
            var prenom = document.getElementById('prenom').value;
            var tournois = document.querySelectorAll('input[name^="tournoi"]:checked');
            var errorMessage = document.getElementById('error-message');
            if (nom == "" && prenom == "") {
                error_log("Le nom et le prénom n'ont pas été saisis")
                errorMessage.textContent = 'Veuillez saisir votre nom et prénom !';
                errorMessage.style.display = 'block';
            } else if (nom == "") {
                error_log("Le nom n'a pas été saisi")
                errorMessage.textContent = 'Veuillez saisir votre nom !';
                errorMessage.style.display = 'block';
            } else if (prenom == "") {
                error_log("Le prénom n'a pas été saisi")
                errorMessage.textContent = 'Veuillez saisir votre prénom !';
                errorMessage.style.display = 'block';
            } else if (tournois.length == 0) {
                error_log("Aucun tournoi n'a pas été coché")
                errorMessage.textContent = 'Veuillez cocher le tournoi ou les tournois désiré(s) !';
                errorMessage.style.display = 'block';
            } else {
                error_log("L'inscription est validée")
                // Le formulaire est valide
                errorMessage.style.display = 'Le formulaire est valide !';
                errorMessage.style.display = 'block';
               return true;
            }
            setTimeout(function() {
                errorMessage.style.display = 'none';
            }, 3000);
            return false;
        }
    </script>
</head>
<body>

    <div class="form-container">
        <?php
            $result = $db->query("SELECT id, nom FROM tournois WHERE etat=1");
            $tournois = [];
            while($row = $result->fetchArray()) {
                $tournois[] = $row;
            }
            echo '<h1>Formulaire d\'inscription</h1>';
            if (!empty($tournois)) {
                // Il y a des tournois ouverts
                echo '<form method="post" action="valideInscription.php" onsubmit="return validateForm()">
                    <label for="nom">Nom:</label><br>
                    <input type="text" id="nom" name="nom"><br>
                    <label for="prenom">Prénom:</label><br>
                    <input type="text" id="prenom" name="prenom"><br>
                    <label for="tournoi">Tournoi:</label><br>';
                error_log("Affichage des tournois ouverts"); // Ajoutez cette ligne
                foreach($tournois as $tournoi) {
                    $tournoiId = $tournoi['id'];
                    $participantCountResult = $db->query("SELECT COUNT(*) as count FROM participants WHERE tournoiId1='$tournoiId' OR tournoiId2='$tournoiId' OR tournoiId3='$tournoiId' OR tournoiId4='$tournoiId'");
                    $participantCountRow = $participantCountResult->fetchArray();
                    $participantCount = $participantCountRow['count'];
                    echo '<input type="checkbox" id="tournoi' . $tournoiId . '" name="tournoi" value="' . $tournoiId . '"><label for="tournoi' . $tournoiId . '">' . $tournoi['nom'] . ' (' . $participantCount . ' participants)</label><br>';
                }
                echo '<input type="submit" value="Je m\'inscris">
                </form>';
            } else {
                // Il n'y a pas de tournois ouverts
                echo '<p class="no-tournament-message">Vous ne pouvez pas vous inscrire pour l\'instant, il n\'y a pas de tournoi ouvert</p>';
            }
        ?>
        <div id="error-message"></div>
        <a href="https://xn--lesptanquistesputeaux-e5b.com/Tournois/">Retour à la page précédente</a>
        <?php
        if(isset($_SESSION['message']) && $_SESSION['message'] !== '') {
            echo '<div id="success-message" style="background-color: lightgreen; color: darkgreen;">' . $_SESSION['message'] . '</div>';
            unset($_SESSION['message']);
        }
        ?>
        <div>
            <?php
            while($row = $result->fetchArray()) {
                if(isset($row['adherentId']) && isset($row['count'])) {
                    echo "Adhérent ID: " . $row['adherentId'] . " - Nombre de tournois auxquels il participe: " . $row['count'] . "<br>";
                }
            }
            ?>
            <a href="listeParticipantsAuxTournois.php" class="<?php echo empty($tournois) ? 'disabled-link' : ''; ?>">Liste des participants aux tournois</a>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            var successMessage = document.getElementById('success-message');
            if (successMessage && successMessage.textContent !== '') {
                successMessage.style.display = 'block';
                setTimeout(function() {
                    successMessage.style.display = 'none';
                }, 5000);
            }
        });
    </script>
</body>
</html>
