<?php

namespace lightningsdk\podcast\Pages;

use lightningsdk\core\Tools\Configuration;
use lightningsdk\core\Tools\IO\FileManager;
use lightningsdk\core\Tools\Output;
use lightningsdk\core\Tools\Request;
use lightningsdk\core\Tools\Template;
use lightningsdk\core\View\Page;
use lightningsdk\core\View\Pagination;
use lightningsdk\core\View\Video\HTML5;
use lightningsdk\podcast\Model\Episode;

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

            $this->page = ['episode_list', 'lightningsdk/podcast'];
        } else {
            // This is a specific page
            $episode = Episode::loadByUrl($location[1]);
            if (empty($episode)) {
                Output::notFound();
            }

            $fileHandler = FileManager::getFileHandler(Configuration::get('modules.podcast.filehandler'), Configuration::get('modules.podcast.container'));

            $image = $episode->getHeaderImage();

            HTML5::add('podcast', [
                'aac' => $fileHandler->getWebURL($episode->file),
                'still' => $image,
            ]);

            $this->setMeta('image', $image);
            $this->setMeta('keywords', $episode->keywords);
            $this->setMeta('description', $episode->description);
            $this->setMeta('title', $episode->title);

            $template->set('episode', $episode);

            $this->page = ['episode', 'lightningsdk/podcast'];
        }
    }
}
