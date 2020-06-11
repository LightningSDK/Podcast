<?php

namespace lightningsdk\podcast\Pages\Admin;

use lightningsdk\core\Pages\Table;
use lightningsdk\core\Tools\ClientUser;
use lightningsdk\core\Tools\Configuration;
use lightningsdk\core\Tools\IO\FileManager;
use lightningsdk\core\Tools\Request;

class Episodes extends Table {
    const TABLE = 'podcast_episode';
    const PRIMARY_KEY = 'episode_id';

    protected $preset = [
        'date' => 'date',
        'file' => [
            'type' => 'file',
            'replace' => true,
        ],
        'image' => [
            'type' => 'image',
            'browser' => true,
            'container' => 'images',
            'format' => 'jpg',
        ],
        'duration' => [
            'type' => 'hidden',
        ],
        'url' => [
            'type' => 'url',
            'unlisted' => true
        ],
    ];

    protected $action_fields = [
        'view' => [
            'display_name' => 'View',
            'type' => 'html',
        ],
    ];

    protected $fieldOrder = [
        'date',
        'title',
        'url',
        'description',
        'keywords',
        'file',
        'image',
        'duration',
    ];

    protected $sort = ['date' => 'desc'];

    public function hasAccess() {
        return ClientUser::requireAdmin();
    }

    public function initSettings() {
        parent::initSettings();
        $this->preset['file']['container'] = Configuration::get('modules.podcast.container');
        $this->preset['url']['submit_function'] = function(&$output) {
            $output['url'] = Request::post('url', Request::TYPE_URL) ?: Request::post('title', Request::TYPE_URL);
        };

        $this->action_fields['view']['html'] = function($row) {
            return '<a href="/podcast/' . $row['url'] . '"><img src="/images/lightning/resume.png" /></a>';
        };
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
