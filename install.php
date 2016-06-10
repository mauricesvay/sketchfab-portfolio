<?php
// require dirname(__FILE__) . '/vendor/autoload.php';
require_once dirname(__FILE__) . '/vendor/twig/twig/lib/Twig/Autoloader.php';
Twig_Autoloader::register();
require dirname(__FILE__) . "/app/lib/api.php";
require dirname(__FILE__) . "/app/lib/config.php";

$loader = new Twig_Loader_Filesystem('app/templates');
$twig = new Twig_Environment($loader);
$data = array(
    'error' => null,
    'isInstalled' => hasConfig(),
);

if (!empty($_POST['username'])) {
    if (!isValidUsername($_POST['username'])) {
        $data['error'] = 'Username is not valid';
    } else {
        $config = array(
            'username' => $_POST["username"]
        );
        $filename = dirname(__FILE__) . '/data/config-' . uniqid() . '.json';
        $result = file_put_contents($filename, json_encode(array(
            'username' => $_POST["username"]
        )));
        if ($result !== false) {
            $data['error'] = null;
            $data['isInstalled'] = true;
        } else {
            $data['error'] = "Can't save configuration";
            $data['isInstalled'] = false;
        }
    }
}

echo $twig->render('install.html', $data);
