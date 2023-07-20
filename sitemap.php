<?php
    header("Content-Type: text/xml;charset=utf-8");
    echo '<?xml version="1.0" encoding="UTF-8"?>';
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';
    echo '<url>';
    echo '<loc>https://discordid.nealvos.nl/</loc>';
    echo '<changefreq>weekly</changefreq>';
    echo '<priority>1.0</priority>';
    echo '<image:image>';
    echo '<image:loc>https://discordid.nealvos.nl/static/images/heroes/hero1.jpg</image:loc>';
    echo '</image:image>';
    echo '<image:image>';
    echo '<image:loc>https://discordid.nealvos.nl/static/images/icons/highres.png</image:loc>';
    echo '</image:image>';
    echo '</url>';
    echo '</urlset>';
?>
