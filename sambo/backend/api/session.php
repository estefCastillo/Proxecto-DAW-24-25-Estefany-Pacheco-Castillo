<?php
session_start();

header("Content-Type: application/json");

if (isset($_SESSION["rol"]) && isset($_COOKIE['t_reset'])) {
    echo json_encode(["activa" => true]);
    exit();
} else {
    session_unset();
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 3600, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
    setcookie('t_reset', '', time() - 3600);
    session_destroy();

    echo json_encode(["activa" => false]);
    exit();
}
