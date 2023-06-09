<!-- es como el log out -->

<?php
session_start();
session_destroy();
header("Location:./login.php")

?>