<?php $episodes = \Modules\Podcast\Model\Episode::loadByQuery(['order_by' => ['date' => 'DESC'], 'limit' => 5]); ?>
<?php if (!empty($episodes)): ?>
<ul>
    <?php foreach ($episodes as $episode): ?>
        <li><a href="/podcast/<?= $episode->slug ?>"><?= $episode->title; ?></a></li>
    <?php endforeach; ?>
    <li><a href="/podcast">More ...</a></li>
</ul>
<?php endif; ?>
