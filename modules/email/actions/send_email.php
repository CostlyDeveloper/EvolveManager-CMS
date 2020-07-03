<?php
if(!isset($_POST['clientName']) || !isset($_POST['clientPhone']) || !isset($_POST['clientNote'])){ die_500(); }

echo $_POST['clientName'];
echo $_POST['clientPhone'];
echo $_POST['clientNote'];