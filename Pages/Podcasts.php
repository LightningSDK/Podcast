<?php

namespace Modules\Podcast\Pages;

use Lightning\Tools\Configuration;
use Lightning\Tools\Image;
use Lightning\Tools\IO\FileManager;
use Lightning\Tools\Output;
use Lightning\Tools\Request;
use Lightning\Tools\Template;
use Lightning\View\Page;
use Lightning\View\Pagination;
use Lightning\View\Video\HTML5;
use Modules\Podcast\Model\Episode;

class Podcasts extends Page {
    public function hasAccess() {
        return true;
    }

    public function get() {
        $location = Request::getLocation();
        $location = explode('/', $location);
        $template = Template::getInstance();

        if (count($location) == 1 || $location[1] == 'page') {
            // This is the home list
            $rows_per_page = 25;

            $page = 1;
            if (count($location) == 3) {
                $page = intval($location[2]);
            }

            $episodes = Episode::loadByQuery([
                'order_by' => ['date' => 'DESC'],
                'limit' => $rows_per_page,
                'page' => $page
            ]);
            if (empty($episodes)) {
                Output::notFound();
            }

            $template->set('episodes', $episodes);

            // Create the pagination
            $pagination = new Pagination([
                'page' => $page,
                'rows_per_page' => $rows_per_page,
                'base_path_replace' => '/podcast/page/%%',
                'rows' => Episode::count(),
            ]);

            $template->set('pagination', $pagination);

            $this->page = ['episode_list', 'Podcast'];
        } else {
            // This is a specific page
            $episode = Episode::loadByUrl($location[1]);
            if (empty($episode)) {
                Output::notFound();
            }

            $fileHandler = FileManager::getFileHandler(Configuration::get('modules.podcast.filehandler'), Configuration::get('modules.podcast.container'));

            HTML5::add('podcast', [
                'aac' => $fileHandler->getWebURL($episode->file),
                'still' => $episode->getImage(),
            ]);

            $template->set('episode', $episode);

            $this->page = ['episode', 'Podcast'];
        }
    }
}
