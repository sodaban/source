<?php
$target_dir = "./"; // Répertoire où le fichier sera enregistré

// Create the "uploads" directory if it doesn't exist
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]); // Chemin du fichier à télécharger

// Vérifiez la taille du fichier (par exemple, 500 Ko)
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Désolé, votre fichier est trop volumineux.";
} else {
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
    echo "Le fichier a été téléchargé avec succès vers le site Web !";
}
?>
