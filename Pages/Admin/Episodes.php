<?php

namespace Modules\Podcast\Pages\Admin;

use Lightning\Pages\Table;
use Lightning\Tools\ClientUser;
use Lightning\Tools\Configuration;

class Episodes extends Table {
    const TABLE = 'podcast_episode';
    const PRIMARY_KEY = 'episode_id';

    protected $preset = [
        'date' => 'date',
        'file' => [
            'type' => 'file',
            'replace' => true,
        ],
    ];

    public function hasAccess() {
        return ClientUser::requireAdmin();
    }

    public function initSettings() {
        parent::initSettings();
        $this->preset['file']['container'] = Configuration::get('modules.podcast.container');
    }
}
