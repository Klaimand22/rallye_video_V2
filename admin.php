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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./css/global.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/footer.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <h1 class="title">Dashboard</h1>
    <main>
        <div class="parent">
            <!-- listes des équipes -->
            <div class="div1">
                <h2>Liste des équipes</h2>
                <ul>
                    <?php
                    require_once('connexion_db.php');
                    $sql = mysqli_query($CONNEXION, "SELECT idteam, nom_equipe FROM rallyevideo_team");
                    if (mysqli_num_rows($sql) > 0) {
                        while ($row = mysqli_fetch_assoc($sql)) {
                    ?>
                    <li><a id="test"
                            href='team.php?idteam=<?= $row["idteam"] ?>&nom_equipe=<?= $row["nom_equipe"] ?>'><?= $row["nom_equipe"] ?></a>
                    </li>
                    <?php

                        }
                    } else {
                        ?>
                    <h2>Aucune équipe.</h2>
                    <?php
                    }
                    ?>
                </ul>
            </div>
            <div class="flex-main div4">
                <div class="flex-child">
                    <h2>Membres par équipes</h2>
                </div>
                <div class="flex-child">
                    <div>
                        <canvas id="membresequipes"></canvas>
                    </div>
                </div>
            </div>
            <div class="div3">
                <a id="test" href="user.php">Liste des membres</a>
            </div>
        <div class="div5">
            <a id="test" href="video.php">Liste des vidéos</a>
        </div>
       </div>
    </main>

    <?php
    $iduser = $_SESSION['iduser'];

    $requetechart = mysqli_query($CONNEXION, "SELECT *,count(rallyevideo_team.idteam) FROM rallyevideo_user_has_team INNER JOIN rallyevideo_team ON rallyevideo_user_has_team.team_idteam = rallyevideo_team.idteam WHERE equipe = 1 GROUP BY rallyevideo_user_has_team.team_idteam");
    if (mysqli_num_rows($requetechart) > 0) {
        $idteam = array();
        $noms = array();
        while ($row = mysqli_fetch_assoc($requetechart)) {
            $idteam[] = $row['count(rallyevideo_team.idteam)'];
            $noms[] = $row['nom_equipe'];
        }
    }

    ?>


</body>
<script>
const idteam = <?php echo json_encode($idteam); ?>;
const noms = <?php echo json_encode($noms); ?>;

const data = {
    labels: noms,
    datasets: [{
        label: 'Nombre de membres par équipes',
        data: idteam,
        borderWidth: 1
    }]
};

const config = {
    type: 'bar',
    data,
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
};


const myChart = new Chart(
    document.getElementById('membresequipes'),
    config
);
</script>

</html>