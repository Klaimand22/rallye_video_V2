<?php

include("./components/session-start.php");
require_once "session-verif.php";
include("./components/header.php");
if ($_SESSION["role"] != 'admin' || !isset($_SESSION["role"])) {
?>
    <script>
        window.location.href = "index.php";
    </script>
<?php
}
?>

<body>
    <h1 class="title">Liste des vidéos</h2>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Nom de la vidéo</th>
                    <th scope="col">Nombre de vote</th>
                    <th scope="col">Equipe</th>
                    <th scope="col">Action</th>

                </tr>
            </thead>
            <tbody>
                <?php
                $request = "SELECT * FROM rallyevideo_depot INNER JOIN rallyevideo_team ON rallyevideo_depot.depot_team = rallyevideo_team.idteam";
                $sql = mysqli_query($CONNEXION, $request);
                while ($row = mysqli_fetch_array($sql)) {
                    $depot_nom = $row['depot_nom'];
                    $depot_vote = $row['depot_vote'];
                    $nom_equipe = $row['nom_equipe'];
                    $depot_id = $row['depot_id'];
                ?>
                    <tr>
                        <td><?php echo $depot_nom; ?></td>
                        <td><?php echo $depot_vote; ?></td>
                        <td><?php echo $nom_equipe; ?></td>
                        <td>
                            <form method="POST" action="video.php">
                                <input type="hidden" name="depot_id" value="<?php echo $depot_id; ?>">
                                <button type="submit" name="supprimer" class="btn btn-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php
                }

                ?>

            </tbody>
        </table>





        <?php

        if (isset($_POST['supprimer'])) {
            $depot_id = $_POST['depot_id'];
            $request = "DELETE FROM rallyevideo_depot WHERE depot_id = '$depot_id'";
            $sql = mysqli_query($CONNEXION, $request);
            if ($sql) {
                echo "Video supprimée";
        ?>
                <script>
                    window.location.href = "video.php"
                </script>
        <?php

            } else {
                echo 'Erreur SQL : ' . mysqli_error($CONNEXION);
            }
            mysqli_close($CONNEXION);
        }
        ?>

</body>