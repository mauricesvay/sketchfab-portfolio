<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/lib/PortfolioTwigExtension.php';
require __DIR__ . '/lib/api.php';
require __DIR__ . '/lib/config.php';

//Config
if (hasConfig()) {
    $configPath = getConfigPath();
    $config = json_decode(file_get_contents($configPath), true);
    $username = $config['username'];
    if ( !array_key_exists('username', $config) || !isValidUsername($config['username']) ) {
        die("Configuration is invalid");
    }
} else {
    header('Location: install.php', true, 302);
    die();
}

// Content
$profilePath = __DIR__ . "/../data/cache/{$username}_profile.json";
$modelsPath = __DIR__ . "/../data/cache/{$username}_models.json";

if (!is_file($profilePath)) {
    importProfile($username, $profilePath);
}
$profile = json_decode(file_get_contents($profilePath), true);

if (!is_file($modelsPath)) {
    importModels($profile['uid'], $modelsPath);
}

$models = json_decode(file_get_contents($modelsPath), true);

// Should show portfolio models only?
$showTaggedOnly = false;
foreach($models as $model) {
    if (in_array('portfolio', $model['tags'])) {
        $showTaggedOnly = true;
        break;
    }
}
if ($showTaggedOnly) {
    $models = array_filter($models, function($model){
        return in_array('portfolio', $model['tags']);
    });
}
