<?php
// Conexión a la base de datos
$host = 'localhost';
$dbname = 'repuestera';
$username = 'root';
$password = '';

try {
    $conexion = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];

    // Encriptar la contraseña (opcional pero recomendable)
    $claveHash = password_hash($clave, PASSWORD_DEFAULT);

    // Insertar el nuevo usuario
    $sql = "INSERT INTO usuarios (usuario, clave) VALUES (:usuario, :clave)";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':usuario', $usuario);
    $stmt->bindParam(':clave', $claveHash);

    if ($stmt->execute()) {
        echo "<p style='color: #0f0; font-size:20px;'> Usuario agregado correctamente.</p>";
    } else {
        echo "<p style='color: #f66;'> Error al agregar usuario.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar nuevo usuario</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1a1a1a, #444);
            color: beige;
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
            margin: 0;
        }

        h2 {
            color: beige;
            text-shadow: 0 0 10px rgba(255, 0, 0, 0.4);
            font-size: 28px;
            margin-bottom: 25px;
        }

        form {
            background-color: #111;
            border-radius: 20px;
            box-shadow: 0 0 25px rgba(255, 0, 0, 0.4);
            padding: 40px 50px;
            width: 380px;
            text-align: center;
            border: 2px solid red;
            transition: transform 0.3s;
        }

        form:hover {
            transform: scale(1.02);
        }

        label {
            font-size: 16px;
            font-weight: 500;
        }

        input[type="text"], input[type="password"] {
            width: 90%;
            padding: 10px;
            margin: 10px 0 20px 0;
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

        a {
            color: #ff4d4d;
            text-decoration: none;
            margin-top: 20px;
            display: inline-block;
            transition: color 0.3s;
            font-weight: 500;
        }

        a:hover {
            color: #ff9999;
        }
    </style>
</head>

<body>
    <h2>👤 Agregar nuevo usuario</h2>

    <form method="POST">
        <label>Usuario:</label><br>
        <input type="text" name="usuario" required><br>
        <label>Contraseña:</label><br>
        <input type="password" name="clave" required><br>
        <button type="submit">Guardar usuario</button>
    </form>

    <a href="panel.php">⬅ Volver al panel</a>
</body>
</html>