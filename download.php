<?php
$target_dir = "uploads/"; // Répertoire où le fichier sera enregistré
$target_file = $target_dir . basename($_FILES["fileToDownload"]["name"]); // Chemin du fichier à télécharger

// Vérifiez si le fichier existe déjà
if (file_exists($target_file)) {
    echo "Désolé, le fichier existe déjà.";
} else {
    move_uploaded_file($_FILES["fileToDownload"]["tmp_name"], $target_file);
    echo "Le fichier a été téléchargé avec succès !";
}
?>

