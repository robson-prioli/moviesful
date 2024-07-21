<?php
ob_start();
require_once('../_app/Config.ini.php');

$GetData = filter_input_array(INPUT_GET, FILTER_DEFAULT);

$controller = new MovieController();
$controller->handleRequest('v1', $GetData);

header('Content-Type: application/json');
echo json_encode($controller->getResult());

ob_end_flush();

