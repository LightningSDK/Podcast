<h1><?= $episode->title; ?></h1>
<div class="responsive-embed widescreen">
    <?= \lightningsdk\core\View\Video\HTML5::render('podcast', ['widescreen' => true]); ?>
</div>
<p><?= $episode->description; ?></p>
<?= \lightningsdk\core\View\SocialMedia\Share::render($episode->getURL()); ?>
