<?php

namespace Modules\Podcast\API;

use Lightning\Tools\Configuration;
use Lightning\Tools\IO\FileManager;
use Lightning\Tools\Output;
use Lightning\Tools\Template;
use Lightning\View\Page;
use Modules\Podcast\Model\Episode;

class RSS extends Page {

    protected $page = ['xml', 'Podcast'];

    public function hasAccess() {
        return true;
    }

    public function get() {
        $episodes = Episode::loadAll([], [], 'ORDER BY date DESC');

        $template = Template::getInstance();
        $template->set('episodes', $episodes);
        $template->set('podcast', Configuration::get('modules.podcast.metadata'));
        $fileHandler = FileManager::getFileHandler(Configuration::get('modules.podcast.filehandler'), Configuration::get('modules.podcast.container'));
        $template->set('fileHandler', $fileHandler);

        Output::setContentType('application/xml');
        Configuration::set('debug', false);
        echo $template->render($this->page);
        exit;
    }
}
