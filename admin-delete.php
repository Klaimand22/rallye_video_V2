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
$id = $_GET['id'];

$sql = mysqli_query($CONNEXION, "DELETE FROM rallyevideo_team WHERE idteam = '$id'");

if($sql){
    ?>
<script>
window.location.href = "admin.php";
</script>

<?php
}else {
    echo"Erreur de suppresion";
}


?>