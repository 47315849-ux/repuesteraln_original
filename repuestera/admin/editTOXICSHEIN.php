<?php
$pdo = new PDO("mysql:host=localhost;dbname=repuestera;charset=utf8", "root", "");
$mensaje = "";

// --- Eliminar imagen ---
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $stmt = $pdo->prepare("SELECT ruta_imagen FROM imagenes WHERE id_imagen = ?");
    $stmt->execute([$id]);
    $imagen = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($imagen && file_exists($_SERVER['DOCUMENT_ROOT'] . $imagen['ruta_imagen'])) {
        unlink($_SERVER['DOCUMENT_ROOT'] . $imagen['ruta_imagen']);
    }

    $stmt = $pdo->prepare("DELETE FROM imagenes WHERE id_imagen = ?");
    $stmt->execute([$id]);
    $mensaje = " Imagen eliminada correctamente.";
}

// --- Subir imagen ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['imagen'])) {
    $carpeta = "/imagenes/";
    $rutaAbsoluta = $_SERVER['DOCUMENT_ROOT'] . $carpeta;

    if (!file_exists($rutaAbsoluta)) mkdir($rutaAbsoluta, 0777, true);

    $nombreArchivo = time() . "_" . basename($_FILES['imagen']['name']);
    $rutaCompleta = $rutaAbsoluta . $nombreArchivo;
    $rutaBD = $carpeta . $nombreArchivo;

    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaCompleta)) {
        // 🔹 Obtener el id_categoria correspondiente a "toxicshein"
        $stmt = $pdo->prepare("SELECT id_categoria FROM categoria WHERE nombre_categoria = 'toxicshein'");
        $stmt->execute();
        $categoria = $stmt->fetch(PDO::FETCH_ASSOC);
        $id_categoria = $categoria ? $categoria['id_categoria'] : null;

        // 🔹 Insertar la imagen con su categoría
        $stmt = $pdo->prepare("INSERT INTO imagenes (ruta_imagen, id_categoria) VALUES (?, ?)");
        $stmt->execute([$rutaBD, $id_categoria]);

        $mensaje = " Imagen subida correctamente.";
    } else {
        $mensaje = " Error al subir la imagen.";
    }
}

// --- Obtener todas las imágenes de la categoría "toxicshein" ---
$stmt = $pdo->prepare("
    SELECT i.id_imagen, i.ruta_imagen 
    FROM imagenes i
    INNER JOIN categoria c ON i.id_categoria = c.id_categoria
    WHERE c.nombre_categoria = 'toxicshein'
    ORDER BY i.id_imagen DESC
");
$stmt->execute();
$imagenes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Editar Productos de Limpieza</title>
<style>
body {
    background-color: #333;
    color: white;
    font-family: Arial, sans-serif;
    text-align: center;
    margin: 0;
    padding: 0;
}
h1 {
    background-color: #111;
    padding: 20px;
    border-radius: 10px;
}
.formulario {
    margin: 30px auto;
    background-color: #222;
    padding: 20px;
    width: 60%;
    border-radius: 12px;
}
input[type="file"] {
    margin-top: 10px;
    color: white;
}
button {
    margin-top: 15px;
    padding: 10px 20px;
    background-color: #28a745;
    border: none;
    color: white;
    font-weight: bold;
    border-radius: 8px;
    cursor: pointer;
}
button:hover {
    background-color: #218838;
}
.galeria {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 15px;
    margin-top: 30px;
}
.galeria div {
    background-color: #222;
    padding: 10px;
    border-radius: 10px;
}
.galeria img {
    width: 250px;
    height: 200px;
    border-radius: 8px;
    display: block;
}
a.eliminar {
    display: inline-block;
    margin-top: 10px;
    background-color: #dc3545;
    padding: 8px 12px;
    color: white;
    border-radius: 6px;
    text-decoration: none;
}
a.eliminar:hover {
    background-color: #b02a37;
}
a.volver {
    display: inline-block;
    margin-top: 20px;
    background-color: #007bff;
    padding: 10px 16px;
    color: white;
    border-radius: 6px;
    text-decoration: none;
}
a.volver:hover {
    background-color: #0056b3;
}
</style>
</head>
<body>

<h1>🧴 Panel de Edición - Productos de Limpieza (ToxicShein)</h1>

<?php if ($mensaje): ?>
    <p style="color: #0f0; font-weight: bold;"><?= htmlspecialchars($mensaje) ?></p>
<?php endif; ?>

<div class="formulario">
    <form method="post" enctype="multipart/form-data">
        <label>Seleccioná una imagen para subir:</label><br>
        <input type="file" name="imagen" accept="image/*" required><br>
        <button type="submit">Subir Imagen</button>
    </form>
</div>

<h2>📷 Imágenes actuales</h2>
<div class="galeria">
    <?php foreach ($imagenes as $img): ?>
        <div>
            <img src="<?= htmlspecialchars($img['ruta_imagen']) ?>" alt="Imagen">
            <br>
            <a class="eliminar" href="?eliminar=<?= $img['id_imagen'] ?>" onclick="return confirm('¿Seguro que querés eliminar esta imagen?')">Eliminar</a>
        </div>
    <?php endforeach; ?>
</div>

<a href="/paginas/limpieza.php" class="volver">← Volver a Limpieza</a>

</body>
</html>