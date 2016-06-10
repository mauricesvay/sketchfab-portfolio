<?php

function fetchJson( $url ) {
    $response = Requests::get($url);
    if ($response->status_code === 200) {
        return json_decode($response->body, true);
    } else {
        return false;
    }
}

function makeDirForPath($filePath) {
    $dirname = dirname($filePath);
    if (!is_dir($dirname)) {
        mkdir($dirname, 0755, true);
    }
}
