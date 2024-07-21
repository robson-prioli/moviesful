<?php
require_once('../_app/Config.ini.php');

$payload = [
    'iat' => time(), // Timestamp de quando o token foi emitido
    'exp' => time() + 3600, // Timestamp de expiração (1 hora no futuro)
    'sub' => 12345, // ID do usuário
    'name' => 'John Doe', // Nome do usuário
    'role' => 'admin' // Papel ou função do usuário
];

$jwt = new JWT();
echo $jwt->encode($payload);
