<?php
ob_start();
require_once('../_app/Config.ini.php');

$GetData = filter_input_array(INPUT_GET, FILTER_DEFAULT);

// override @output
$GetData['output'] = $GetData['output'] ?? 'json';

$controller = new MovieController();
$controller->handleRequest('v2', $GetData);

if ($GetData['output'] === 'xml'):
    header('Content-Type: application/xml');
    echo $controller->getResult();
else:
    header('Content-Type: application/json');
    echo json_encode($controller->getResult());
endif;
ob_end_flush();