<?php
ob_start();
require_once('../_app/Config.ini.php');

$GetData = filter_input_array(INPUT_GET, FILTER_DEFAULT);
$PostData = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$endpoint = ($GetData['endpoint'] == 'register') ? 'register' : 'v3';
$params = ($endpoint == 'register') ? $PostData : $GetData;


$controller = new Controller();
$controller->handleRequest($endpoint, $params);

header('Content-Type: application/json');
echo json_encode($controller->getResult());
ob_end_flush();