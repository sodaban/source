<!DOCTYPE html>
<html>
<?php
    // listeParticipantsAuxTournois.php
    $db = new SQLite3('petanqueLPP.db');

    // Récupération de la liste des tournois ouverts
    $result = $db->query("SELECT id, nom, date FROM tournois WHERE etat = 1");

    if ($result === false) {
        die("Erreur dans la requête SQL : " . $db->lastErrorMsg());
    }

    $tournois = array();
    while($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $tournois[] = $row;
    }
?>

<head>
    <style>
        body {
            background-color: black;
            color: white;
        }
        .icone {
            font-size: 24px;
            transition: transform 0.2s ease-in-out;
			display: inline-block;
        }
        .icone:hover {
            animation: pulse 0.5s alternate 3; /* Ajout de cette ligne */
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
            /* Style pour l'icône 9 */
        .icone9 img {
        max-height: 190px; /* Ajustez la hauteur selon vos besoins */
        max-width: 190px;  /* Ajustez la largeur selon vos besoins */
        margin-left: 15px;
        margin-bottom: -22px;
        }
        /* Style pour les nouveaux logos */
        .nouveaux-logos {
            display: flex;
            justify-content: center;
            align-items: center;
			margin-top: 80px; /* Ajoutez cette ligne pour augmenter l'espace entre les lignes */
        }
        .nouveaux-logos img {
            max-height: 160px; /* Ajustez la hauteur selon vos besoins */
            margin: 0 60px; /* Espacement entre les logos */
        }
        a {
            color: white;
        }
        table {
            border-collapse: collapse; /* Pour tracer des cadres du tableau */
        }
        th, td {
            border: 1px solid white; /* Pour tracer des cadres du tableau */
            padding: 10px;
        }
    </style>
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
	
        <!-- Texte sous les logos -->
        <p style="font-size: 50px; margin-top: 50px; margin-bottom: 50px">
            Liste des participants aux tournois.
        </p>
        
	<?php
    // Affichage des participants pour chaque tournoi
    foreach($tournois as $tournoi) {
        echo "<h2>" . $tournoi['nom'] . " (" . $tournoi['date'] . ")</h2>";
        $result = $db->query("SELECT m.nom, m.prenom FROM participants p JOIN adherents m ON p.adherentId = m.id WHERE p.tournoiId1='" . $tournoi['id'] . "' OR p.tournoiId2='" . $tournoi['id'] . "' OR p.tournoiId3='" . $tournoi['id'] . "' OR p.tournoiId4='" . $tournoi['id'] . "'");
        
        if ($result === false) {
            die("Erreur dans la requête SQL : " . $db->lastErrorMsg());
        }
        
        echo "<table>";
        echo "<tr><th>N°</th><th>Nom</th><th>Prénom</th></tr>";
        $ligne = 1;
        while($row = $result->fetchArray()) {
            echo "<tr><td>" . $ligne++ . "</td><td>" . $row['nom'] . "</td><td>" . $row['prenom'] . "</td></tr>";
        }
        echo "</table>";
    }
    ?>
</body>
</html>
