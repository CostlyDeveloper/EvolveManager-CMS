<?php
//session_destroy();
setcookie("ev_userid", '', time() - 1, "/");
setcookie("ev_tok", '', time() - 1, "/");
?>