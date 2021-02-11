<?php
// start a session
session_start();
 
// destroy everything in this session
 
unset($_SESSION);
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"],$params["httponly"]);
}
 
session_destroy();
die ("<script>window.location.href = 'index.php';</script>");
?>