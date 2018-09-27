<?php

return [
    'routes' => [
        'static' => [
            'podcasts.xml' => \Modules\Podcast\API\RSS::class,
            'admin/podcast' => \Modules\Podcast\Pages\Admin\Episodes::class,
        ]
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
];
