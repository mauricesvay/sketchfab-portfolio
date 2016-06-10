<?php
require_once dirname(__FILE__) . '/../vendor/twig/twig/lib/Twig/Autoloader.php';
Twig_Autoloader::register();

require dirname(__FILE__) . '/lib/api.php';
require dirname(__FILE__) . '/lib/config.php';
require dirname(__FILE__) . '/lib/PortfolioTwigExtension.php';

//Config
if (hasConfig()) {
    $config = getConfig();
    $username = $config['username'];
    if ( !array_key_exists('username', $config) || !isValidUsername($config['username']) ) {
        die("Configuration is invalid");
    }
} else {
    header('Location: install.php', true, 302);
    die();
}

// Content
$PROFILE_PATH = dirname(__FILE__) . "/../data/cache/{$username}_profile.json";
$MODELS_PATH = dirname(__FILE__) . "/../data/cache/{$username}_models.json";

if (!is_file($PROFILE_PATH)) {
    importProfile($username, $PROFILE_PATH);
}
$profile = json_decode(file_get_contents($PROFILE_PATH), true);

if (!is_file($MODELS_PATH)) {
    importModels($profile['uid'], $MODELS_PATH);
}
$models = json_decode(file_get_contents($MODELS_PATH), true);

// Should show portfolio models only?
function filterModels($model){
    return in_array('portfolio', $model['tags']);
}

$showTaggedOnly = false;
if (count($models)) {
    foreach($models as $model) {
        if (in_array('portfolio', $model['tags'])) {
            $showTaggedOnly = true;
            break;
        }
    }
    if ($showTaggedOnly) {
        $models = array_filter($models, 'filterModels');
    }
}
