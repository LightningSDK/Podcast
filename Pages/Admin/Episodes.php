<?php

namespace Modules\Podcast\Pages\Admin;

use Lightning\Pages\Table;
use Lightning\Tools\ClientUser;
use Lightning\Tools\Configuration;
use Lightning\Tools\IO\FileManager;

class Episodes extends Table {
    const TABLE = 'podcast_episode';
    const PRIMARY_KEY = 'episode_id';

    protected $preset = [
        'date' => 'date',
        'file' => [
            'type' => 'file',
            'replace' => true,
        ],
        'duration' => [
            'type' => 'hidden',
        ],
    ];

    protected $fieldOrder = [
        'date',
        'title',
        'description',
        'keywords',
        'file',
        'duration',
    ];

    protected $sort = ['date' => 'desc'];

    public function hasAccess() {
        return ClientUser::requireAdmin();
    }

    public function initSettings() {
        parent::initSettings();
        $this->preset['file']['container'] = Configuration::get('modules.podcast.container');
    }

    /**
     * @TODO: This should be moved to a media module
     */
    protected function processFieldValues(&$row) {
        $fileHandler = FileManager::getFileHandler(Configuration::get('modules.podcast.filehandler'), Configuration::get('modules.podcast.container'));
        $localFile = $fileHandler->getAbsoluteLocal($row['file']);

        $output = shell_exec('ffmpeg -i ' . escapeshellarg($localFile) . ' 2>&1');
        $output = explode("\n", $output);
        foreach ($output as $line) {
            $matches = [];
            if (preg_match('/Duration: ([0-9:.]+)/', $line, $matches)) {
                $duration = explode(':', $matches[1]);
                $row['duration'] = (intval($duration[0]) * 3600) + (intval($duration[1]) * 60) + intval($duration[2]);
                return true;
            }
        }

        return true;
    }
}
