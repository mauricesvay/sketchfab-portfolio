<?php

function compareImageSize($a, $b) {
    return $a['width'] > $b['width'];
}

$imageUrlFilter = new Twig_SimpleFilter('imageUrlSize', function ($images, $minSize) {
    usort($images, 'compareImageSize');

    foreach($images as $image) {
        if ($image['width'] >= $minSize) {
            return $image['url'];
        }
    }
});
