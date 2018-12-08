<?php

namespace Modules\Podcast\Model;

use Lightning\Model\Object;
use Lightning\Model\URL;
use Lightning\Tools\Configuration;
use Lightning\Tools\Database;
use Lightning\Tools\IO\FileManager;
use Modules\ImageManager\Model\Image;

class Episode extends Object {
    const TABLE = 'podcast_episode';
    const PRIMARY_KEY = 'episode_id';

    public static function loadByUrl($url) {
        if ($data = Database::getInstance()->selectRow(static::TABLE, ['url' => $url])) {
            return new static($data);
        } else {
            return null;
        }
    }

    public function getHeaderImage() {
        $fileHandler = FileManager::getFileHandler('', 'images');
        $image = !empty($this->image)
            ? $fileHandler->getWebURL($this->image)
            : Configuration::get('modules.podcast.metadata.image');
        return Image::getImage($image, 500, \Lightning\Tools\Image::FORMAT_JPG);
    }

    public function getLink() {
        return '/podcast/' . $this->url;
    }

    public function getURL() {
        return URL::getAbsolute($this->getLink());
    }

    public static function getSitemapUrls() {
        $episodes = static::loadAll();

        $urls = [];
        foreach($episodes as $e) {
            $date = explode('/', jdtogregorian($e->date));
            $urls[] = [
                'loc' => URL::getAbsolute('/podcast/' . $e->url),
                'lastmod' => $date[2] . '-' . strpad($date[0], 2, '0', STR_PAD_LEFT) . '-' . strpad($date[1], 2, '0', STR_PAD_LEFT)
                'changefreq' => 'yearly',
                'priority' => .3,
            ];
        }
        return $urls;
    }
}
