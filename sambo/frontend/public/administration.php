<?php 
session_start();
if (!isset($_SESSION["tipo"]) || isset($_SESSION["tipo"])!="admin") {
    header("Location: index.php");
    exit();
}
?>
<h1>ADMINISTRADOR</h1>