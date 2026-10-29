<?php
declare(strict_types=1);

require_once __DIR__ . '/funciones.php';

$nombre = '';
$correo = '';
$producto = '';
$mensaje = '';
$errores = [];
$enviado = false;
$productosPermitidos = [
    'Consolas',
    'Videojuegos',
    'Accesorios',
    'PC Gaming',
    'Muebles Complementarios',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = obtenerEntrada(INPUT_POST, 'nombre');
    $correo = obtenerEntrada(INPUT_POST, 'correo');
    $producto = obtenerEntrada(INPUT_POST, 'producto');
    $mensaje = obtenerEntrada(INPUT_POST, 'mensaje');

    if (!isset($_POST['nombre']) || empty($nombre)) {
        $errores[] = 'El nombre es obligatorio.';
    } elseif (strlen($nombre) > 120) {
        $errores[] = 'El nombre no puede superar los 120 caracteres.';
    }

    if (!isset($_POST['correo']) || empty($correo)) {
        $errores[] = 'El correo electrónico es obligatorio.';
    } elseif (strlen($correo) > 254 || filter_var($correo, FILTER_VALIDATE_EMAIL) === false) {
        $errores[] = 'Ingresa un correo electrónico válido.';
    }

    if (!isset($_POST['producto']) || !in_array($producto, $productosPermitidos, true)) {
        $errores[] = 'Selecciona un tipo de producto válido.';
    }

    if (!isset($_POST['mensaje']) || empty($mensaje)) {
        $errores[] = 'La consulta es obligatoria.';
    } elseif (strlen($mensaje) > 2000) {
        $errores[] = 'La consulta no puede superar los 2000 caracteres.';
    }

    $enviado = count($errores) === 0;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de productos | Skygames</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <main class="contenedor">
        <nav class="navegacion" aria-label="Navegación">
            <a href="index.php">Clase 5</a>
            <a href="busqueda_get.php">Búsqueda GET</a>
        </nav>
        <h1>Consulta de productos</h1>
        <p>Completa el formulario para enviar una consulta a Skygames.</p>

        <?php if ($enviado): ?>
            <div class="mensaje exito" role="status">
                Tu consulta fue validada correctamente. Este ejemplo no la guarda en una base de datos.
            </div>
        <?php elseif ($errores !== []): ?>
            <div class="mensaje error" role="alert">
                <p>Revisa los siguientes campos:</p>
                <ul>
                    <?php foreach ($errores as $error): ?>
                        <li><?= escapar($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="consulta_post.php" method="post">
            <label for="nombre">Nombre completo</label>
            <input id="nombre" name="nombre" type="text" maxlength="120" autocomplete="name" required value="<?= escapar($nombre) ?>">

            <label for="correo">Correo electrónico</label>
            <input id="correo" name="correo" type="email" maxlength="254" autocomplete="email" required value="<?= escapar($correo) ?>">

            <label for="producto">Tipo de producto</label>
            <select id="producto" name="producto" required>
                <option value="">Selecciona una opción</option>
                <?php foreach ($productosPermitidos as $opcion): ?>
                    <option value="<?= escapar($opcion) ?>"<?= $producto === $opcion ? ' selected' : '' ?>><?= escapar($opcion) ?></option>
                <?php endforeach; ?>
            </select>

            <label for="mensaje">Consulta o pedido</label>
            <textarea id="mensaje" name="mensaje" rows="5" maxlength="2000" required><?= escapar($mensaje) ?></textarea>

            <button type="submit">Enviar consulta</button>
        </form>
    </main>
</body>
</html>
