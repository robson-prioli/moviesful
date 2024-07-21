<?php
ob_start();
require_once('../_app/Config.ini.php');

$GetData = filter_input_array(INPUT_GET, FILTER_DEFAULT);



$params = [
    'filter' => $_GET['filter'] ?? '',
    'sort' => $_GET['sort'] ?? 'asc',
    'page' => (int) ($_GET['page'] ?? 1),
    'pageMax' => (int) ($_GET['pageMax'] ?? 10),
    'output' => $_GET['output'] ?? 'json'
];

$controller = new MovieController();
$controller->handleRequest('v2', $params);

if ($params['output'] === 'xml'):
    header('Content-Type: application/xml');
    echo $controller->getResult();
else:
    header('Content-Type: application/json');
    echo json_encode($controller->getResult());
endif;
ob_end_flush();