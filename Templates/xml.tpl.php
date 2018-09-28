<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0"
     xmlns:googleplay="https://www.google.com/schemas/play-podcasts/1.0/play-podcasts.xsd"
     xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd">
    <channel>
        <title><?= $podcast['title']; ?></title>
        <language><?= $podcast['language'] ?? 'en-US'; ?></language>
        <description><?= $podcast['description']; ?></description>
        <itunes:image href="<?= \Lightning\Model\URL::getAbsolute($podcast['image']); ?>" />
        <link><?= $podcast['link'] ?? \Lightning\Tools\Configuration::get('web_root'); ?></link>
        <googleplay:category><?= $podcast['google-category']; ?></googleplay:category>
        <author><?= $podcast['author']; ?></author>
        <itunes:explicit><?= !empty($podcast['explicit']) ? 'yes' : 'no'; ?></itunes:explicit>
        <itunes:category text="<?= \Lightning\Tools\Scrub::toHTML($podcast['itunes-category']); ?>" />
        <?php foreach ($episodes as $episode): ?>
            <item>
                <title><?= $episode->title; ?></title>
                <enclosure url="<?= \Lightning\Model\URL::getAbsolute($fileHandler->getWebURL($episode->file)); ?>" type="audio/mpeg" length="<?= $fileHandler->getSize($episode->file); ?>" />
                <description><?= $episode->description; ?></description>
                <pubDate><?= date('r', \Lightning\View\Field\Time::jdtounix($episode->date)); ?></pubDate>
            </item>
        <?php endforeach; ?>
    </channel>
</rss>
