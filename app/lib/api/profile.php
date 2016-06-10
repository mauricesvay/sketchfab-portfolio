<?php

/**
 * Check valid username
 */
function isValidUsername($str) {
    return preg_match('/^[a-zA-Z0-9_\-\.]{2,}$/', $str);
}

/**
 * Check valid user id
 */
function isValidUserId($str) {
    return preg_match('/[a-f0-9]+/', $str);
}

/**
 * Fetch user id for given username
 */
function fetchIdFromUsername($username) {

    if (!isValidUsername($username)) {
        return false;
    }

    $profileUrlTemplate = 'https://sketchfab.com/';
    $urlTemplate = 'https://sketchfab.com/%s';
    $regexId = '/data-profile-user=\"([a-f0-9]+)\"/';

    $url = sprintf($urlTemplate, $username);
    $response = Requests::get($url);
    if ($response->status_code === 200) {
        $profileHtml = $response->body;
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

/**
 * Fetch user profile
 */
function fetchProfile($id) {

    if (!isValidUserId($id)) {
        return false;
    }

    $urlTemplate = 'https://sketchfab.com/v2/users/%s';
    $url = sprintf($urlTemplate, $id);
    return fetchJson($url);

}

/**
 * Save user profile to file
 */
function importProfile($username, $filePath) {
    $uid = fetchIdFromUsername($username);
    $profile = fetchProfile($uid);
    if ($profile) {
        makeDirForPath($filePath);
        return file_put_contents($filePath, json_encode($profile));
    } else {
        return false;
    }
}
