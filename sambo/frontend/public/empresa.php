<?php 
session_start();
if (!isset($_SESSION["tipo"]) || isset($_SESSION["tipo"])!="empresa") {
    header("Location: index.php");
    exit();
}
?>
<h1>HOLAA EMPRESA</h1>