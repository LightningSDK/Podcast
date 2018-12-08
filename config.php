<?php

return [
    'routes' => [
        'static' => [
            'podcasts.xml' => \Modules\Podcast\API\RSS::class,
            'admin/podcast' => \Modules\Podcast\Pages\Admin\Episodes::class,
        ],
        'dynamic' => [
            '^podcast(/.*)?$' => \Modules\Podcast\Pages\Podcasts::class,
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
        \Modules\Podcast\Model\Episode::class,
    ],
];
