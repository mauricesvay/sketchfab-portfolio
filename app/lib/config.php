<?php

function hasConfig() {
    $configPath = getConfigPath();
    return ($configPath !== "");
}

function getConfigPath() {
    $files = glob(__DIR__ . "/../../data/config-*.json");
    $configPath = "";

    foreach($files as $file) {
        $configPath = $file;
        break;
    }

    return $configPath;
}

function checkPassword($password) {
    $configPath = getConfigPath();
    $config = json_decode(file_get_contents($configPath), true);
    $hash = $config['password'];
    return password_verify ($password, $hash);
}
