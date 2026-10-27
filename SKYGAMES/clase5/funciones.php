<?php
declare(strict_types=1);

function escapar(string $valor): string
{
    return htmlspecialchars($valor, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function obtenerEntrada(int $origen, string $nombre): string
{
    $valor = filter_input($origen, $nombre, FILTER_UNSAFE_RAW);

    return is_string($valor) ? trim($valor) : '';
}
