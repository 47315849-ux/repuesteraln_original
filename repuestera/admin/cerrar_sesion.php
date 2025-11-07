<?php
// Iniciamos o retomamos la sesión
session_start();

// Borramos todas las variables de sesión
session_unset();

// Destruimos la sesión
session_destroy();

// Redirigimos al login (administrador.php)
header("Location: administrador.php");

// Detenemos la ejecución del script
exit();
?>
<html>
    <body>
    </body>
</html>