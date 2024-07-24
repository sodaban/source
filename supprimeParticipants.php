<?php
$db = new SQLite3('petanqueLPP.db');

$id = $_GET['id'];
$db->exec("DELETE FROM participants WHERE id='$id'");
header("Location: modifieSupprimeParticipants.php");
?>
