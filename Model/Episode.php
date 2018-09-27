<?php

namespace Modules\Podcast\Model;

use Lightning\Model\Object;

class Episode extends Object {
    const TABLE = 'podcast_episode';
    const PRIMARY_KEY = 'episode_id';
}
