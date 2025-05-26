<?php
session_start();
session_unset();
session_destroy();
header("Content-Type: application/json; charset=UTF-8");
echo json_encode(["exito" => true]);
exit();
?>
