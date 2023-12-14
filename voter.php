<?php
include("./components/session-start.php");
require_once "session-verif.php";
include("./components/header.php");
?>

<body>
    <main>
        <div class="top">
            <h1 class="title">Toutes les realisations</h1>
            <?php
            $iduser = $_SESSION['iduser'];
            $token = mysqli_query($CONNEXION, "SELECT token_vote FROM rallyevideo_user WHERE iduser = '$iduser'");
            if(mysqli_num_rows($token) > 0){
            while($rowtoken = mysqli_fetch_assoc($token)){
                $tokenuser = $rowtoken['token_vote'];
            ?>
                <p id="token">Tu as <?=$tokenuser?> tokens de vote</p>
            <?php
            }
            }else {
                // si aucun resultat -> pb de connexion 
            }
            ?>
        </div>
        <div class="oeuvres">
            <ul class="oeuvre-item">
                <?php
            $oeuvres = mysqli_query($CONNEXION, "SELECT * FROM rallyevideo_depot INNER JOIN rallyevideo_team ON rallyevideo_depot.depot_team = rallyevideo_team.idteam");
            if(mysqli_num_rows($oeuvres) > 0){
                while($rowoeuvre=mysqli_fetch_assoc($oeuvres)){
                    $extension = substr($rowoeuvre['depot_chemin'], -3);
                    ?>
                    <li>
                            <video controls width="250"><source src="<?=$rowoeuvre['depot_chemin']?>" type="video/<?=$extension?>"></video>
                            <div class="oeuvre-list">
                            <h2>Équipe : <?=$rowoeuvre['nom_equipe']?></h2>
                            <h3>Nombre de votes : <?=$rowoeuvre['depot_vote']?></h3>
                            <h3>Membres de l'équipe :</h3>
                            <ul>
                               <?php
                                $teamid = $rowoeuvre['depot_team'];
                                $membresteam = mysqli_query($CONNEXION, "SELECT * FROM rallyevideo_user_has_team INNER JOIN rallyevideo_user ON rallyevideo_user_has_team.user_iduser = rallyevideo_user.iduser WHERE team_idteam = '$teamid' AND equipe = 1");
                                if(mysqli_num_rows($membresteam) > 0){
                                    while($rowmembresteam=mysqli_fetch_assoc($membresteam)){
                                        ?>
                                    <li><?=$rowmembresteam['prenom']?> <?=$rowmembresteam['nom']?></li>
                                        <?php

                                    }
                                }else {
                                    ?>
                                <li>Aucun membre</li>
                                    <?php
                                }

                               ?>
                            </ul>
                            <?php
                                if($tokenuser > 0){

                            ?>
                            <a href="traitement-vote.php?team=<?=$teamid?>">Voter pour cette équipe</a>

                            <?php
                                }
                            ?>
                        </div>
                    </li>

                    <?php

                
            }}else {
                // si aucune oeuvre
                ?>
                <h2>Aucune oeuvre encore déposé</h2>
                <?php
            }

                ?>
                </ul>
            </div>


    </main>
</body>


<?php
include("./components/footer.php");
?>