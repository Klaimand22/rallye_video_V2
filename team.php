<?php
include("./components/session-start.php");
require_once "session-verif.php";
include("./components/header.php");

?>

<body>

    <h1 class="title">Membres de l'équipe <?php echo htmlspecialchars($_GET["nom_equipe"]); ?></h1>

    <main>
        <div>
            <?php

            $requetecrea = mysqli_query($CONNEXION, "SELECT * FROM rallyevideo_team INNER JOIN rallyevideo_user ON rallyevideo_team.idcreateur = rallyevideo_user.iduser WHERE nom_equipe = '" . $_GET["nom_equipe"] . "'");
            if (mysqli_num_rows($requetecrea) == 0) {
                echo "Erreur";
            } else {
                $rowcrea = mysqli_fetch_assoc($requetecrea);
            }
            ?>
            <h2>Équipe créé par : <?= $rowcrea["prenom"] ?> <?= $rowcrea["nom"] ?></h2>
        </div>
        <div> <a href="admin-delete.php?id=<?= $rowcrea['idteam'] ?>" class="button-main red">Supprimer l'équipe</a></div>
        <div>
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // SUPPRESSION D'UN MEMBRE DE L'EQUIPE
                    $nom_equipe = $_GET["nom_equipe"];
                    $idteam = $_GET['idteam'];


                    $requetemembre = mysqli_query($CONNEXION, "SELECT * FROM rallyevideo_user INNER JOIN rallyevideo_user_has_team ON rallyevideo_user.iduser = rallyevideo_user_has_team.user_iduser WHERE rallyevideo_user_has_team.team_idteam = '$idteam'");
                    if (mysqli_num_rows($requetemembre) > 0) {
                        while ($rowlist = mysqli_fetch_assoc($requetemembre)) {
                    ?>
                            <tr>
                                <td><?php echo htmlspecialchars($rowlist["nom"]); ?></td>
                                <td><?php echo htmlspecialchars($rowlist["prenom"]); ?></td>
                                <td>
                                    <a href="supprimer-membre.php?id=<?= $rowlist['iduser'] ?>" class="supprimer">Supprimer</a>
                                </td>
                            </tr>
                    <?php
                        }
                    }

                    ?>


                </tbody>
            </table>

        </div>
        <a id=deconnexion href="admin.php">Retour en arrière</a>

    </main>

    <?php include("./components/footer.php");
    ?>
</body>