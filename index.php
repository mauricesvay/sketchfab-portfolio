<?php
require dirname(__FILE__) . '/app/boot.php';

$loader = new Twig_Loader_Filesystem('app/templates');
$twig = new Twig_Environment($loader);
$twig->addFilter($imageUrlFilter);
echo $twig->render('index.html', array(
    'profile' => $profile,
    'models' => $models
));
