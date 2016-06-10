<?php
namespace Core;

return array(
    'service_manager' => array(
        'invokables' => array(
            'Image\Imagine' => 'Imagine\Gd\Imagine',
        ),
        'factories' => array(
            'Image\Service\Image' => 'Image\Service\ImageFactory'
        )
    ),
);
