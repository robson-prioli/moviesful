<?php
ob_start();
require_once('../_app/Config.ini.php');

$GetData = filter_input_array(INPUT_GET, FILTER_DEFAULT);

$params = [
    'filter' => $GetData['filter'] ?? '',
    'sort' => $GetData['sort'] ?? API_SORT_DEFAULT,
    'page' => (int) ($GetData['page'] ?? API_PAGE_DEFAULT),
    'limit' => (int) ($GetData['limit'] ?? API_LIMIT_DEFAULT)
];

$controller = new MovieController();
$controller->handleRequest('v3', $params);

header('Content-Type: application/json');
echo json_encode($controller->getResult());
ob_end_flush();