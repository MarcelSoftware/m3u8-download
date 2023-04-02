<?php

const PART_FOLDER = 'files';

function downloadM3U8(string $url): void
{
    $list = extractSegmentUrls($url);
    downloadSegmentFiles($list);
    mergeFiles(PART_FOLDER);
}

function extractSegmentUrls(string $streamUrl): array
{
    $m3u8file = file_get_contents($streamUrl);
    $lines = explode("\n", $m3u8file);
    $lines = array_slice($lines, 5, -2);

    return array_filter($lines, static fn($key, $i) => $i % 2 === 1, ARRAY_FILTER_USE_BOTH);
}

function downloadSegmentFiles(array $list): void
{
    foreach ($list as $n => $key) {
        $number = str_pad($n, 5, "0", STR_PAD_LEFT);
        echo "Fetching $key..." . PHP_EOL;
        file_put_contents(PART_FOLDER . "/part." . $number . ".ts", fopen($key, 'rb'));
    }
}

function mergeFiles(string $dirName): void
{
    $handle = opendir($dirName);
    if ($handle === null) {
        throw new RuntimeException("Parts folder could not be opened");
    }
    while (false !== ($file = readdir($handle))) {
        if (str_contains($file, ".ts")) {
            $part = PART_FOLDER . "/" . $file;
            echo "Appending part $part..." . PHP_EOL;
            file_put_contents("movie.ts", file_get_contents($part), FILE_APPEND);
            unlink($part);
        }
    }
    closedir($handle);
    rmdir(PART_FOLDER);
}

