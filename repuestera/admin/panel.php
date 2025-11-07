<?php
session_start();

// Si el usuario no está logueado, lo mandamos al login
if (!isset($_SESSION["usuario"])) {
    header("Location: administrador.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Panel de Control</title>
<style>
body {
    font-family: Arial, sans-serif;
    background: linear-gradient(135deg, #4a4848ff, #511717ff);
    color: white;
    text-align: center;
    margin: 0;
    padding-top: 100px;
}
h1 { margin-bottom: 20px; }
.botones {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 15px;
}
a {
    display: inline-block;
    width: 250px;
    padding: 12px;
    background: white;
    color: #d84b28ff;
    border-radius: 10px;
    text-decoration: none;
    font-weight: bold;
    transition: 0.3s;
}
a:hover {
    background: #e3e3e3;
}
.logout {
    background-color: #dc3545;
    color: white;
}
.logout:hover {
    background-color: #b52a37;
}
</style>
</head>
<body>
<h1>⚙️ Panel de Control</h1>
<p>Bienvenido, <b><?= htmlspecialchars($_SESSION["usuario"]) ?></b></p>
<p>Seleccioná qué sección querés editar:</p>
<div class="botones">
    <a href="editILUMINACION.php">🪔 Editar Iluminación</a>
    <a href="editPRODUCTOS.php">🛠️ Editar Productos</a>
    <a href="editTOXICSHEIN.php">🧼 Editar Toxic Shein</a>
    <a href="nuevo_usuario.php">Agregar Usuario</a>
    <a href="cerrar_sesion.php" class="logout">🚪 Cerrar Sesión</a>
</div>
</body>
</html>