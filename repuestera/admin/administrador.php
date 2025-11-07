<?php
$pdo = new PDO("mysql:host=localhost;dbname=repuestera;charset=utf8", "root", ""); // Conexión a la base de datos
$mensaje = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = trim($_POST["usuario"]);
    $clave = trim($_POST["clave"]);
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = ?");
    $stmt->execute([$usuario]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && $user["clave"] === $clave) {
        session_start();
        $_SESSION["usuario"] = $usuario;
        header("Location: panel.php");
        exit;
    } else {
        $mensaje = " Usuario o contraseña incorrectos.";    
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Administrador - Login</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
<style>
    body {
        background: linear-gradient(135deg, #1a1a1a, #444);
        color: beige;
        font-family: 'Poppins', sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }
    .login-container {
        background-color: #111;
        border-radius: 20px;
        box-shadow: 0 0 25px rgba(255, 0, 0, 0.4);
        padding: 40px 50px;
        width: 380px;
        text-align: center;
        border: 2px solid red;
        transition: transform 0.3s;
    }
    .login-container:hover {
        transform: scale(1.02);
    }
    h2 {
        font-size: 28px;
        color: beige;
        margin-bottom: 20px;
        text-shadow: 0 0 10px rgba(255, 0, 0, 0.4);
    }
    input[type="text"], input[type="password"] {
        width: 90%;
        padding: 10px;
        margin: 10px 0;
        border: none;
        border-radius: 8px;
        background-color: #222;
        color: beige;
        font-size: 15px;
        outline: none;
        transition: box-shadow 0.3s;
    }
    input[type="text"]:focus, input[type="password"]:focus {
        box-shadow: 0 0 8px red;
    }
    button {
        background-color: red;
        color: beige;
        border: none;
        padding: 12px 30px;
        border-radius: 10px;
        font-weight: bold;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.2s;
    }
    button:hover {
        background-color: #ff3333;
        transform: scale(1.05);
        box-shadow: 0 0 12px rgba(255, 0, 0, 0.6);
    }
    .mensaje {
        color: #ff6b6b;
        background-color: rgba(255, 0, 0, 0.15);
        padding: 10px;
        border-radius: 8px;
        margin-bottom: 15px;
        border: 1px solid rgba(255, 0, 0, 0.3);
    }
    .footer {
        margin-top: 25px;
        font-size: 13px;
        color: #aaa;
    }
    .footer span {
        color: red;
    }
</style>
</head>

<body>
    <div class="login-container">
        <h2>🔐 Iniciar Sesión</h2>
        <?php if ($mensaje): ?>
            <p class="mensaje"><?= htmlspecialchars($mensaje) ?></p>
        <?php endif; ?>
        <form method="POST">
            <label>Usuario</label><br>
            <input type="text" name="usuario" placeholder="Ingrese su usuario" required><br>
            <label>Contraseña</label><br>
            <input type="password" name="clave" placeholder="Ingrese su contraseña" required><br><br>
            <button type="submit">Entrar</button>
        </form>
        <div class="footer">
            <p>© 2025 <span>Repuestera La Nueva</span></p>
        </div>
    </div>
</body>
</html>