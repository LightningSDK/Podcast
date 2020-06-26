<?php

return [
    'routes' => [
        'static' => [
            'podcasts.xml' => \lightningsdk\podcast\API\RSS::class,
            'admin/podcast' => \lightningsdk\podcast\Pages\Admin\Episodes::class,
        ],
        'dynamic' => [
            '^podcast(/.*)?$' => \lightningsdk\podcast\Pages\Podcasts::class,
        ],
    ],
    'markup' => [
        'renderers' => [
            'podcast' => \lightningsdk\podcast\View\Podcast::class,
        ],
    ],
    'modules' => [
        'podcast' => [
            'container' => [
                'storage' => 'media/podcasts',
                'url' => '/media/podcasts/',
            ],
            'filehandler' => '',
        ],
    ],
    'sitemap' => [
        \lightningsdk\podcast\Model\Episode::class,
    ],
];
