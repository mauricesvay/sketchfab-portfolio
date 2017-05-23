<?php
require_once dirname(__FILE__) . '/../../vendor/twig/twig/lib/Twig/Autoloader.php';
Twig_Autoloader::register();

function compareImageSize($a, $b) {
    return $a['width'] > $b['width'];
}

function imageUrlSizeFilter($images, $minSize) {

    if (!is_array($images)) {
        return '';
    }

    usort($images, 'compareImageSize');

    foreach($images as $image) {
        if ($image['width'] >= $minSize) {
            return $image['url'];
        }
    }
}

$imageUrlFilter = new Twig_SimpleFilter('imageUrlSize', 'imageUrlSizeFilter');
