<?php

/**
 * Fetch paginated models for given user id
 */
function fetchModels($username, $cursor='') {
    $baseUrl = 'https://api.sketchfab.com/v3/models';
    $params = array(
        'user' => $username,
        'sort_by' => '-createdAt',
        'cursor' => $cursor
    );
    $url = $baseUrl . '?' . http_build_query($params);
    return fetchJson($url);
}

/**
 * Fetch all models for given user id
 */
function fetchAllModels($username) {

    set_time_limit (0);
    $cursor = '';
    $models = array();

    do {
        $response = fetchModels($username, $cursor);
        $params = array();

        // Extract cursor
        if ($response['next'] !== null) {
            $parsed = parse_url($response['next'], PHP_URL_QUERY);
            if($parsed !== null) {
                parse_str($parsed, $params);
                if (array_key_exists ('cursor', $params)) {
                    $cursor = $params['cursor'];
                }
            }
        }

        if (is_array($response) && array_key_exists('results', $response)) {
            $models = array_merge($models, $response['results']);
        } else {
            break;
        }

        sleep(5);

    } while ($response['next']);

    return $models;
}

/**
 * Save all user models to file
 */
function importModels($username, $filePath) {
    $models = fetchAllModels($username);
    makeDirForPath($filePath);
    return file_put_contents($filePath, json_encode($models));
}
