<?php
session_destroy();
setcookie("userid","",time() - (1000 * 1000));
setcookie("password","",time() - (1000 * 1000));
header('Location: index.php');
?>