<?php

include("./components/session-start.php");
require_once "session-verif.php";
if ($_SESSION["role"] != 'admin' || !isset($_SESSION["role"])) {
?>
<script>
window.location.href = "index.php";
</script>
<?php
}

phpinfo();
?>