<?php

$dom = new DOMDocument();
$theSite = $argv[1];

$linksQueue = array($theSite => 0);
$visitedUrls = array(
    $theSite => 0,
);
$currentLevel = 0;

while (0 != count($linksQueue)) {
    $currentUrl = key($linksQueue);
    $currentLevel = array_shift($linksQueue);

    echo 'FOUND:'.count($visitedUrls).' QUEUE:'.count($linksQueue).' LEVEL:'.$currentLevel.' '.$currentUrl.PHP_EOL;

    @$dom->loadHTMLFile($currentUrl);

    for ($i = 1; $i <= 6; ++$i ) {
        foreach ($dom->getElementsByTagName('h'.$i) as $title) {
            echo '    h'.$i.': '.trim($title->nodeValue).PHP_EOL;
        }
    }

    foreach ($dom->getElementsByTagName('a') as $link) {
        $newUrl = $link->getAttribute('href');
        // if in-site and not yet visited then follow
        if (substr($newUrl, 0, strlen($theSite)) == $theSite and !array_key_exists($newUrl, $visitedUrls)) {
            $linksQueue[$newUrl] = $currentLevel + 1;
            $visitedUrls[$newUrl] = $currentLevel + 1;
        }
    }
}

asort($visitedUrls);
echo '// Results ////////////////////////////////////////////'.PHP_EOL;
foreach ($visitedUrls as $key => $value) {
    echo 'DEPTH:'.$value.' '.$key.PHP_EOL;
}
echo 'Total URLs found: '.count($visitedUrls).PHP_EOL;
