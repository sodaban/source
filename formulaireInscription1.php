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
// Affichage des participants pour chaque tournoi
$result = $db->query("SELECT adherentId, COUNT(*) as count FROM participants GROUP BY adherentId");
error_log("Recuperation des participants pour chaque tournoi");
?>

<head>
    <title>Formulaire d'inscription</title>
    <style>
        body {
            background-color: black;
            color: white;
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
            var nombreDeCasesCochees = tournois.length;
            console.log("Nombre de cases cochées : " + nombreDeCasesCochees);


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
    <div id="error-message"></div>
    <form action="formulaireInscription1.php" method="POST">

        <?php
            $result = $db->query("SELECT id, nom FROM tournois WHERE etat=1");
            $tournois = [];
            while($row = $result->fetchArray()) {
                $tournois[] = $row;
            }
            echo '<h1>Formulaire d\'inscription</h1>';
            if (!empty($tournois)) {
                // Il y a des tournois ouverts
                echo '<form method="post" action="successInscription.html" onsubmit="return validateForm()">
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
    </form>

</body>
</html>
