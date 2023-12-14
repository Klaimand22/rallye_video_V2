<?php
include("./components/session-start.php");
require_once "session-verif.php";
$id = $_GET['id'];

$requete = mysqli_query($CONNEXION, "DELETE FROM rallyevideo_user_has_team WHERE user_iduser = '$id'");

if($requete){
    header('location: admin.php');

}else {
    echo "Erreur dans la suppresion";
}



?>