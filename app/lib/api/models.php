<?php

/**
 * Fetch paginated models for given user id
 */
function fetchModels($userId, $offset=0) {
    $baseUrl = 'https://api.sketchfab.com/v2/models';
    $params = array(
        'user' => $userId,
        'offset' => $offset
    );
    $url = $baseUrl . '?' . http_build_query($params);
    return fetchJson($url);
}

/**
 * Fetch all models for given user id
 */
function fetchAllModels($userId) {
    $offset = 0;
    $models = array();

    do {
        $response = fetchModels($userId, $offset);
        $models = array_merge($models, $response['results']);
        $offset = $offset + $response['count'];
    } while ($response['next']);

    return $models;
}

/**
 * Save all user models to file
 */
function importModels($uid, $filePath) {
    $models = fetchAllModels($uid);
    makeDirForPath($filePath);
    return file_put_contents($filePath, json_encode($models));
}
