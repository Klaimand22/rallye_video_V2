<?php
include("./components/session-start.php");
require_once "session-verif.php";

$iduser = $_SESSION['iduser'];
$idteam = $_GET['team'];

$sqladdvote = mysqli_query($CONNEXION, "UPDATE rallyevideo_depot SET depot_vote = depot_vote + 1  WHERE depot_team = '$idteam'");

$sqltoken = mysqli_query($CONNEXION, "UPDATE rallyevideo_user SET token_vote = token_vote - 1 WHERE iduser = '$iduser'");


if($sqladdvote && $sqltoken){
    header('location: voter.php');
}


?>