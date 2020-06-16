<?php

namespace lightningsdk\podcast\View;

class Podcast {
    public static function renderMarkup($options, $vars) {
        if (array_key_exists('recent', $options)) {
            $episodes = \lightningsdk\podcast\Model\Episode::loadByQuery(['order_by' => ['date' => 'DESC'], 'limit' => 5]);
            $output = '';

            if (!empty($episodes)) {
                foreach ($episodes as $episode) {
                    $output .= "<li><a href='/podcast/{$episode->url}'>{$episode->title}</a></li>";
                }
                $output .= '<li><a href="/podcast">More ...</a></li>';
            }

            return $output;
        }
    }
}
