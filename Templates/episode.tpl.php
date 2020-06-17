<h1><?= $episode->title; ?></h1>
<div class="responsive-embed widescreen">
    <?= \lightningsdk\core\View\Video\HTML5::render('podcast'); ?>
</div>
<p><?= $episode->description; ?></p>