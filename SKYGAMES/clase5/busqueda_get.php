<?php
declare(strict_types=1);

require_once __DIR__ . '/funciones.php';

$consolasPermitidas = [
    'PlayStation 5',
    'Xbox Series X',
    'Nintendo Switch',
];
$inventario = [
    ['nombre' => 'PlayStation 5 Slim', 'consola' => 'PlayStation 5', 'stock' => 7],
    ['nombre' => 'Mando DualSense', 'consola' => 'PlayStation 5', 'stock' => 12],
    ['nombre' => 'Xbox Series X 1TB', 'consola' => 'Xbox Series X', 'stock' => 4],
    ['nombre' => 'Mando inalámbrico Xbox', 'consola' => 'Xbox Series X', 'stock' => 9],
    ['nombre' => 'Nintendo Switch OLED', 'consola' => 'Nintendo Switch', 'stock' => 6],
    ['nombre' => 'Joy-Con', 'consola' => 'Nintendo Switch', 'stock' => 10],
];

$busqueda = '';
$consola = '';
$errores = [];
$resultados = [];
$seBusco = $_SERVER['REQUEST_METHOD'] === 'GET' && (isset($_GET['buscar']) || isset($_GET['q']) || isset($_GET['consola']));

if ($seBusco) {
    $busqueda = obtenerEntrada(INPUT_GET, 'q');
    $consola = obtenerEntrada(INPUT_GET, 'consola');

    if (!isset($_GET['q']) || empty($busqueda)) {
        $errores[] = 'Escribe un término para buscar.';
    } elseif (strlen($busqueda) > 100) {
        $errores[] = 'La búsqueda no puede superar los 100 caracteres.';
    }

    if (isset($_GET['consola']) && !is_string($_GET['consola'])) {
        $errores[] = 'Selecciona una consola válida.';
    } elseif ($consola !== '' && !in_array($consola, $consolasPermitidas, true)) {
        $errores[] = 'Selecciona una consola válida.';
    }

    if ($errores === []) {
        foreach ($inventario as $articulo) {
            $coincideNombre = stripos($articulo['nombre'], $busqueda) !== false;
            $coincideConsola = $consola === '' || $articulo['consola'] === $consola;

            if ($coincideNombre && $coincideConsola) {
                $resultados[] = $articulo;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Búsqueda de consolas | Skygames</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <main class="contenedor">
        <nav class="navegacion" aria-label="Navegación">
            <a href="index.php">Clase 5</a>
            <a href="consulta_post.php">Consulta POST</a>
        </nav>
        <h1>Búsqueda rápida de stock</h1>
        <p>Busca un producto y, si quieres, limita los resultados a una consola.</p>

        <?php if ($errores !== []): ?>
            <div class="mensaje error" role="alert">
                <ul>
                    <?php foreach ($errores as $error): ?>
                        <li><?= escapar($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="busqueda_get.php" method="get">
            <label for="q">Producto</label>
            <input id="q" name="q" type="search" maxlength="100" required value="<?= escapar($busqueda) ?>">

            <label for="consola">Consola (opcional)</label>
            <select id="consola" name="consola">
                <option value="">Todas las consolas</option>
                <?php foreach ($consolasPermitidas as $opcion): ?>
                    <option value="<?= escapar($opcion) ?>"<?= $consola === $opcion ? ' selected' : '' ?>><?= escapar($opcion) ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit" name="buscar" value="1">Buscar</button>
        </form>

        <?php if ($seBusco && $errores === []): ?>
            <section aria-live="polite">
                <h2>Resultados</h2>
                <?php if ($resultados === []): ?>
                    <p>No se encontraron productos con esos criterios.</p>
                <?php else: ?>
                    <ul class="resultados">
                        <?php foreach ($resultados as $articulo): ?>
                            <li>
                                <strong><?= escapar($articulo['nombre']) ?></strong>
                                <span><?= escapar($articulo['consola']) ?> — Stock: <?= (int) $articulo['stock'] ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </section>
        <?php endif; ?>
    </main>
</body>
</html>
