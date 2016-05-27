<?php
use GuzzleHttp\Client;

function makeDirForPath($filePath) {
    $dirname = dirname($filePath);
    if (!is_dir($dirname)) {
        mkdir($dirname, 0755, true);
    }
}

function isValidUsername($str) {
    return preg_match('/^[a-zA-Z0-9_\-\.]{2,}$/', $str);
}

function isValidUserId($str) {
    return preg_match('/[a-f0-9]+/', $str);
}

function getIdFromUsername($username) {

    if (!isValidUsername($username)) {
        return false;
    }

    $profileUrlTemplate = 'https://sketchfab.com/';
    $urlTemplate = 'https://sketchfab.com/%s';
    $regexId = '/data-profile-user=\"([a-f0-9]+)\"/';

    $url = sprintf($urlTemplate, $username);
    $client = new Client();
    $response = $client->get($url);
    if ($response->getStatusCode() === 200) {
        $profileHtml = $response->getBody();
        preg_match($regexId, $profileHtml, $parts);
        if (count($parts)) {
            return $parts[1];
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function getProfile($id) {

    if (!isValidUserId($id)) {
        return false;
    }

    $urlTemplate = 'https://sketchfab.com/v2/users/%s';
    $url = sprintf($urlTemplate, $id);
    $client = new Client();
    $response = $client->get($url);
    if ($response->getStatusCode() === 200) {
        return json_decode($response->getBody(), true);
    } else {
        return false;
    }
}

function importProfile($username, $filePath) {
    $uid = getIdFromUsername($username);
    $profile = getProfile($uid);
    if ($profile) {
        makeDirForPath($filePath);
        return file_put_contents($filePath, json_encode($profile, JSON_PRETTY_PRINT));
    } else {
        return false;
    }
}

function getModels($userId, $offset=0) {
    $url = 'https://sketchfab.com/v2/models';
    $params = array(
        'query' => array(
            'user' => $userId,
            'offset' => $offset
        )
    );

    $client = new Client();
    $response = $client->request('GET', $url, $params);
    if ($response->getStatusCode() === 200) {
        return json_decode($response->getBody(), true);
    } else {
        return false;
    }
}

function getAllModels($userId) {
    $offset = 0;
    $models = array();

    do {
        $response = getModels($userId, $offset);
        $models = array_merge($models, $response['results']);
        $offset = $offset + $response['count'];
    } while ($response['next']);

    return $models;
}

function importModels($uid, $filePath) {
    $models = getAllModels($uid);
    makeDirForPath($filePath);
    return file_put_contents($filePath, json_encode($models, JSON_PRETTY_PRINT));
}
