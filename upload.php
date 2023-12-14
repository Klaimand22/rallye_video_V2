<?php
include("./components/session-start.php");
require_once "session-verif.php";
include("./components/header.php");


$_SESSION["iduser"] = intval($_SESSION["iduser"]);

$requetedepot = mysqli_query($CONNEXION, "SELECT * FROM rallyevideo_user INNER JOIN rallyevideo_team ON rallyevideo_user.iduser = rallyevideo_team.idcreateur WHERE rallyevideo_team.idcreateur = $_SESSION[iduser]");

$rowdepot = mysqli_fetch_assoc($requetedepot);

$idteam = $rowdepot["idteam"];


if (isset($_POST['submit'])) {
    $maxsize = 5242880; // 5mb en bytes

    if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != '') {
        $name = $_FILES['file']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . $name;




        // extension
        $extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // valid file extension
        $extension_arr = array('mp4', 'avi', '3gp', 'mov');

        // check extension
        if (in_array($extension, $extension_arr)) {

            if ($_FILES['file']['size'] >= $maxsize) {
                echo "Fichier trop lourd, max 5MB";
            } else {
                // upload
                if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
                    mysqli_query($CONNEXION, "INSERT INTO rallyevideo_depot VALUES(NULL, '$name', '$target_file', '0', '$idteam')");
                    echo "Envoi effectué !";
                    mysqli_query($CONNEXION, "UPDATE rallyevideo_team SET depot = 1 WHERE idteam = '$idteam'");
?>
                    <script>
                        window.location.href = "session-bienvenue.php"
                    </script>
<?php
                } else {
                    echo "Erreur lors de l'envoi";
                }
            }
        } else {
            echo "Extension du fichier non prise en compte : mp4, avi, 3gp, mov, mpeg";
        }
    } else {
        echo 'Séléctionnez un fichier';
    }
    // header('location: session-bienvenue.php');
    exit;
}


?>


<body>
    <main class="main">
        <h1 class="title">Déposer mon film</h1>
        <p id="token">500mb MAX</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="file" name="file" id="file">
            <input type="submit" name="submit" value="Envoyer">
            <a href="session-bienvenue.php" class="btn-card red">Retour</a>
        </form>


    </main>
    <?php
    include("./components/footer.php");
    ?>
</body>