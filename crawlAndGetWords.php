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

    // Removing scripts..
    while ($node = $dom->getElementsByTagName('script') and $node->length) {
        $node->item(0)->parentNode->removeChild($node->item(0));
    }
    // Removing styles..
    while ($node = $dom->getElementsByTagName('style') and $node->length) {
        $node->item(0)->parentNode->removeChild($node->item(0));
    }
    // Getting only the text content of the website..
    $content = $dom->textContent;
    $contentLines = explode(PHP_EOL, $content);
    $words = array();
    foreach ($contentLines as $line) {
        $wordsInLine = explode(' ', $line);
        foreach ($wordsInLine as $word) {
            $word = str_replace(PHP_EOL, '', trim($word));
            if (isset($words[$word])) {
                ++$words[$word];
            } else {
                $words[$word] = 1;
            }
        }
    }
    foreach ($words as $key => $value) {
        echo $key.' => '.$value.PHP_EOL;
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
