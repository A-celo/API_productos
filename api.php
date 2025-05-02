<?php
// api.php

/*
API que consulta la base de datos 'tienda' y regresa los productos en formato JSON.

Tabla: productos
Campos:
- id (INT, primary key)
- nombre (VARCHAR)
- precio (DECIMAL)
- imagen (VARCHAR)

Ejemplo de respuesta:
[
    {
        "id": 1,
        "nombre": "Cien años de soledad",
        "precio": "19.99",
        "imagen": "cien_anos_de_soledad.jpg"
    },
    ...
]
*/

$host = 'localhost';
$db   = 'tienda';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error en la conexión: ' . $e->getMessage()]);
    exit;
}

try {
    $stmt = $pdo->query('SELECT * FROM productos');
    $productos = $stmt->fetchAll();

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($productos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
} catch (\PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error al consultar los productos: ' . $e->getMessage()]);
}

