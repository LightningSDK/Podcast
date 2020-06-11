<div class="blog-container">
    <?php use lightningsdk\core\View\SocialMedia\Links; ?>

    <?= $pagination->render(); ?>
    <?php foreach ($episodes as $episode): ?>
        <div class="article">
                <?php if ($image = $episode->getHeaderImage()): ?>
                    <a href="<?=$episode->getLink();?>"><div class="blog-header-image" style="background-image:url(<?=$image;?>);"></div></a>
                <?php endif; ?>
                <h2><a href='<?=$episode->getLink();?>'><?=$episode->title;?></a></h2>

            <div class="date">
                <?= date('F j, Y', strtotime(jdtogregorian($episode->date))); ?></div>
            <div class="body-wrapper">
                <div class="body">
                    <?= \lightningsdk\core\View\Text::shorten($episode->description); ?>
                </div>
                <?= Links::render($episode->getURL()); ?>
            </div>
        </div>
    <?php endforeach; ?>
    <?= $pagination->render(); ?>
</div>
