<?php

require_once "functions.php";

function getUrl(array &$argv): string
{
    while (count($argv) !== 2 || empty($argv[1])) {
        $argv[1] = readline("m3u8 file> ");
    }
    return $argv[1];
}

$startTime = microtime(true);

$url = getUrl($argv);
downloadM3U8($url);

echo "\nDownload finished in " . (microtime(true) - $startTime) . " seconds.";
