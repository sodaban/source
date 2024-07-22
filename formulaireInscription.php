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

if (isset($_SESSION['message']) && basename($_SERVER['PHP_SELF']) !== 'valideInscription.php') {
    echo '<div id="error-message">' . $_SESSION['message'] . '</div>';
    unset($_SESSION['message']);
}


?>

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
            margin-top: 200px;
            /* Ajoutez une marge en haut pour éviter que le logo ne chevauche le formulaire */
            margin-left: 30.00%;
            /* Déplace le conteneur vers la droite de 2/3 de l'écran */
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

        /* Style pour l'effet d'impulsion */
        .icone {
            font-size: 24px;
            transition: transform 0.2s ease-in-out;
            display: inline-block;
        }

        .icone:hover {
            animation: pulse 0.5s alternate 3;
            /* Ajout de cette ligne */
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        /* Style pour l'icône 9 */
        .icone9 img {
            max-height: 190px;
            /* Ajustez la hauteur selon vos besoins */
            max-width: 190px;
            /* Ajustez la largeur selon vos besoins */
            margin-left: 15px;
            margin-bottom: -22px;
        }

        /* Style pour les nouveaux logos */
        .nouveaux-logos {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 80px;
            /* Ajoutez cette ligne pour augmenter l'espace entre les lignes */
        }

        .nouveaux-logos img {
            max-height: 160px;
            /* Ajustez la hauteur selon vos besoins */
            margin: 0 60px;
            /* Espacement entre les logos */
        }
    </style>
    <script>
        window.onload = function() {
            document.querySelector('form').addEventListener('submit', validateForm);
        }
    </script>
    <script>
        function validateForm(event) {
            event.preventDefault(); // Prevent form submission
            console.log("Validation forme appelee");
            var nom = document.getElementById('nom').value;
            var prenom = document.getElementById('prenom').value;
            var tournois = document.querySelectorAll('input[name^="tournoi"]:checked');
            var nombreDeCasesCochees = tournois.length;
            // Duration in mS of the setTimeout function 
            var msgduration = 1000;
            console.log("Nombre de cases cochees : " + nombreDeCasesCochees);

            var errorMessage = document.getElementById('error-message');
            if (nom == "" && prenom == "") {
                errorMessage.textContent = 'Veuillez saisir votre nom et prénom !';
                errorMessage.style.display = 'block';
                setTimeout(function() {
                    errorMessage.style.display = 'none';
                }, msgduration);
                return false; // Add this line to return false when there is an error
            } else if (nom == "") {
                errorMessage.textContent = 'Veuillez saisir votre nom !';
                errorMessage.style.display = 'block';
                setTimeout(function() {
                    errorMessage.style.display = 'none';
                }, msgduration);
                return false; // Add this line to return false when there is an error
            } else if (prenom == "") {
                errorMessage.textContent = 'Veuillez saisir votre prénom !';
                errorMessage.style.display = 'block';
                setTimeout(function() {
                    errorMessage.style.display = 'none';
                }, msgduration);
                return false; // Add this line to return false when there is an error
            } else if (tournois.length == 0) {
                errorMessage.textContent = 'Veuillez cocher le tournoi ou les tournois désiré(s) !';
                setTimeout(function() {
                    errorMessage.style.display = 'none';
                }, msgduration);
                errorMessage.style.display = 'block';
                return false; // Add this line to return false when there is an error
            } else {
                // Le formulaire est valide
                // afficher les données du formulaire: nom, prénom et les tournois sélectionnés
                console.log("Nom : " + nom + " Prénom : " + prenom);
                for (var i = 0; i < tournois.length; i++) {
                    console.log("Tournoi " + (i + 1) + " : " + tournois[i].value);
                }
                // mettre dans la variable super globale le nom et prénom du participant qu'il a saisi
                // pour pouvoir les utiliser dans la page verifierMembre.php et la page valideInscription.php


                // ici le formulaire est valide, il faut vérifier si le participant est un membre du club, pour cela il le vérifier dans la table adherents

                // je vais utiliser une requête AJAX pour vérifier si le participant est un membre du club
                // si le participant est un membre du club, je vais soumettre le formulaire
                // sinon, je vais afficher un message d'erreur

                // Code AJAX pour vérifier si le participant est un membre du club
                var xhr = new XMLHttpRequest();
                console.log("Vérification de l'existence du membre : " + nom + " " + prenom);
                var url = 'verifierMembre.php?nom=' + encodeURIComponent(nom) + '&prenom=' + encodeURIComponent(prenom);
                xhr.open('GET', url, true); // Assuming that 'verifierMembre.php' is located in the 'source' folder
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.membre) {
                            // Le participant est un membre du club, soumettre le formulaire
                            document.querySelector('form').submit();
                        } else {
                            // Le participant n'est pas un membre du club, afficher un message d'erreur
                            var errorMessage = document.getElementById('error-message');
                            errorMessage.textContent = 'Vous devez être membre du club pour vous inscrire.';
                            errorMessage.style.display = 'block';
                            setTimeout(function() {
                                errorMessage.style.display = 'none';
                            }, 2000);
                        }
                    }
                };
                xhr.send();
            }
        }
    </script>
</head>

<body>
    <?php
    // Liens à exécuter (remplacez par vos propres URLs)
    $lien1 = 'https://lespétanquistesputeaux.com';
    $lien2 = 'https://lespétanquistesputeaux.com/A-propos/';
    $lien3 = 'https://lespétanquistesputeaux.com/Charte/';
    $lien4 = 'https://lespétanquistesputeaux.com/Contacts/';
    $lien5 = 'https://lespétanquistesputeaux.com/LPP/source/tournoi.php';
    $lien6 = 'https://lespétanquistesputeaux.com/Liste-Partenaires/';
    $lien7 = 'https://lespétanquistesputeaux.com/INFOS/';
    $lien8 = 'https://lespétanquistesputeaux.com/LES/';
    $lien9 = 'https://lespétanquistesputeaux.com/SPONSORS/';


    // Icônes (remplacez par les icônes de votre choix)
    $icone1 = '<a href="' . $lien1 . '"><i class="icone"><img src="../images/accueilUrl.jpg" alt="Icône1"></i></a>';
    $icone2 = '<a href="' . $lien2 . '"><i class="icone"><img src="../images/aproposUrl.jpg" alt="Icône2"></i></a>';
    $icone3 = '<a href="' . $lien3 . '"><i class="icone"><img src="../images/charteUrl.png" alt="Icône3"></i></a>';
    $icone4 = '<a href="' . $lien4 . '"><i class="icone"><img src="../images/contactUrl.jpg" alt="Icône4"></i></a>';
    $icone5 = '<a href="' . $lien5 . '"><i class="icone"><img src="../images/tournoisUrl.jpg" alt="Icône5"></i></a>';
    $icone6 = '<a href="' . $lien6 . '"><i class="icone"><img src="../images/partenairesUrl.png" alt="Icône6"></i></a>';
    $icone7 = '<a href="' . $lien7 . '"><i class="icone"><img src="../images/infosUrl.jpg" alt="Icône7"></i></a>';
    $icone8 = '<a href="' . $lien8 . '"><i class="icone"><img src="../images/lesplusUrl.gif" alt="Icône8"></i></a>';

    // Icône 9 avec la classe spécifique
    $icone9 = '<a href="' . $lien9 . '"><i class="icone icone9"><img src="../images/sponsorsUrl.jpg" alt="Icône9"></i></a>';


    // Affichage des icônes avec les liens
    echo $icone1 . $icone2 . $icone3 . $icone4 . $icone5 . $icone6 . $icone7 . $icone8 . $icone9;
    echo '<br>'; // Saut de ligne

    ?>

    <div id="error-message"></div>
    <form method="post" action="valideInscription.php">
        <?php
        error_log("Debut de la page formulaireInscription.php"); // Ajoutez cette ligne
        // Nombre de tournois ouverts
        $result = $db->query("SELECT id, nom FROM tournois WHERE etat=1");
        $tournois = [];

        while ($row = $result->fetchArray()) {
            $tournois[] = $row;
        }
        // Code to post the variable to another page
        if (!empty($_POST['tournois'])) {
            $tournois = $_POST['tournois'];
        }
        echo '<h1>Formulaire d\'inscription</h1>';
        if (!empty($tournois)) {
            // Il y a au moins un tournoi ouvert
            echo '<form method="post" action="valideInscription.php">
                    <label for="nom">Nom:</label><br>
                    <input type="text" id="nom" name="nom"><br>
                    <label for="prenom">Prénom:</label><br>
                    <input type="text" id="prenom" name="prenom"><br>
                    <label for="tournoi">Tournoi:</label><br>              
                    ';
            error_log("Affichage des donnees du formulaire pour l'inscription"); // Ajoutez cette ligne
            // Ajouter une variable pour stocker le nombre de tournois ouverts
            $nombreTournoisOuverts = count($tournois);
            $i = 0;
            // Afficher les tournois ouverts
            error_log("Nombre de tournois ouverts : " . $nombreTournoisOuverts); // Ajoutez cette ligne
            // Récupérer le nom et le prénom du participant dans l'url


            // Est ce utile de récupérer le nom et le prénom du participant dans l'url ?
            // $nom = isset($_GET['nom']) ? $_POST['nom'] : ''; // Assuming that 'nom' is the name of the input field for the name
            // $prenom = isset($_GET['prenom']) ? $_POST['prenom'] : ''; // Assuming that 'prenom' is the name of the input field for the first name
            // // error_log("nom : " . $nom . " prenom : " . $prenom); // Ajoutez cette ligne
            foreach ($tournois as $tournoi) {
                $tournoiId = $tournoi['id'];

                // loguer le nombre de participants pour chaque tournoi
                $participantCountResult = $db->query("SELECT COUNT(*) as count FROM participants WHERE tournoiId1='$tournoiId' OR tournoiId2='$tournoiId' OR tournoiId3='$tournoiId' OR tournoiId4='$tournoiId'");
                $participantCountRow = $participantCountResult->fetchArray();
                $participantCount = $participantCountRow['count'];
                $dateResult = $db->query("SELECT date FROM tournois WHERE id='$tournoiId'");
                $dateRow = $dateResult->fetchArray();
                $date = $dateRow['date'];

                if ($i == 0) {
                    $tournoiId1 = $tournoiId;
                    error_log("Tournoi ID : " . $tournoiId . " - Nom du tournoi : " . $tournoi['nom'] . " Date : " . $date . " Inscrits : " . $participantCount); // Ajoutez cette ligne
                    echo '<input type="checkbox" id="tournoi' . $tournoiId1 . '" name="tournoi[]" value="' . $tournoiId1 . '"><label for="tournoi' . $tournoiId . '">' . $tournoi['nom'] . ' (' . $date . ') (' . $participantCount . ' inscrits)</label><br>';
                }
                if ($i == 1) {
                    $tournoiId2 = $tournoiId;
                    error_log("Tournoi ID : " . $tournoiId . " - Nom du tournoi : " . $tournoi['nom'] . " Date : " . $date . " Inscrits : " . $participantCount); // Ajoutez cette ligne
                    echo '<input type="checkbox" id="tournoi' . $tournoiId2 . '" name="tournoi[]" value="' . $tournoiId2 . '"><label for="tournoi' . $tournoiId . '">' . $tournoi['nom'] . ' (' . $date . ') (' . $participantCount . ' inscrits)</label><br>';
                }
                if ($i == 2) {
                    $tournoiId3 = $tournoiId;
                    error_log("Tournoi ID : " . $tournoiId . " - Nom du tournoi : " . $tournoi['nom'] . " Date : " . $date . " Inscrits : " . $participantCount); // Ajoutez cette ligne
                    echo '<input type="checkbox" id="tournoi' . $tournoiId3 . '" name="tournoi[]" value="' . $tournoiId3 . '"><label for="tournoi' . $tournoiId . '">' . $tournoi['nom'] . ' (' . $date . ') (' . $participantCount . ' inscrits)</label><br>';
                }
                if ($i == 3) {
                    $tournoiId4 = $tournoiId;
                    error_log("Tournoi ID : " . $tournoiId . " - Nom du tournoi : " . $tournoi['nom'] . " Date : " . $date . " Inscrits : " . $participantCount); // Ajoutez cette ligne
                    echo '<input type="checkbox" id="tournoi' . $tournoiId4 . '" name="tournoi[]" value="' . $tournoiId4 . '"><label for="tournoi' . $tournoiId . '">' . $tournoi['nom'] . ' (' . $date . ') (' . $participantCount . ' inscrits)</label><br>';
                }
                $i++;
            }
        } else {
            // Il n'y a pas de tournois ouverts
            echo '<p class="no-tournament-message">Vous ne pouvez pas vous inscrire pour l\'instant, il n\'y a pas de tournoi ouvert</p>';
        }

        ?>
        <!-- Vos champs de formulaire ici -->
        <button type="submit">Je m'inscris</button>
    </form>
    <p style='text-align: left; font-size: 25px;'><a href='listeParticipantsAuxTournois.php'>Liste des participants aux tournois</a></p>
</body>

</html>