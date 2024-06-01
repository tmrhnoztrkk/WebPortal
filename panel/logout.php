<?php

ob_start();
unset($_SESSION["admin"]["login"]);
unset($_SESSION["admin"]["username"]);
unset($_SESSION["admin"]["password"]);

header("Location: index.php");

?>