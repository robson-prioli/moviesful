<?php
ob_start();
require_once('../_app/Config.ini.php');

$GetData = filter_input_array(INPUT_GET, FILTER_DEFAULT);

$params = [
    'filter' => $GetData['filter'] ?? '',
    'sort' => $GetData['sort'] ?? 'asc',
    'page' => (int) ($GetData['page'] ?? 1), 
    'limit' => (int) ($GetData['limit'] ?? 10) 
];

$controller = new MovieController();
$controller->handleRequest('v1', $params);

header('Content-Type: application/json');
echo json_encode($controller->getResult());

ob_end_flush();

