<?php

/**
 * Check if app is configured
 */
function hasConfig() {
    $configPath = getConfigPath();
    return ($configPath !== "");
}

/**
 * Get path of config file
 */
function getConfigPath() {
    $files = glob(dirname(__FILE__) . "/../../data/config-*.json");
    $configPath = "";

    if ($files) {
        foreach($files as $file) {
            $configPath = $file;
            break;
        }
    }

    return $configPath;
}

function getConfig() {
    $configPath = getConfigPath();
    return json_decode(file_get_contents($configPath), true);
}
