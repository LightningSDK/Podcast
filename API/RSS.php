<?php

namespace lightningsdk\podcast\API;

use lightningsdk\core\Tools\Configuration;
use lightningsdk\core\Tools\IO\FileManager;
use lightningsdk\core\Tools\Output;
use lightningsdk\core\Tools\Template;
use lightningsdk\core\View\Page;
use lightningsdk\podcast\Model\Episode;

class RSS extends Page {

    protected $page = ['xml', 'lightningsdk/podcast'];

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
