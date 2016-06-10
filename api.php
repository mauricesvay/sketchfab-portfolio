<?php
require dirname(__FILE__) . '/app/boot.php';

$method = $_SERVER['REQUEST_METHOD'];
$resource = $_GET['resource'];
$action = $_GET['action'];

function respondJson($array) {
    header('Content-type: application/json');
    echo json_encode($array);
    die;
}

if ($method === 'GET') {
    if ($resource === 'models') {
        respondJson($models);
    }
    if ($resource === 'profile') {
        respondJson($profile);
    }
}

if ($method === 'POST') {
    if ($resource === 'models' && $action === 'reload') {
        header('Content-type: application/json');
        $profileResult = importProfile($username, $profilePath);
        $modelsResult = importModels($profile['uid'], $modelsPath);
        $result = array(
            'result' => $profileResult && $modelsResult
        );
        respondJson($result);
    }
}
