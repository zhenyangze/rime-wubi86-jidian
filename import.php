<?php
/**
 * Short description for import.php
 *
 * @package import
 * @author zhenyangze <zhenyangze@gmail.com>
 * @version 0.1
 * @copyright (C) 2023 zhenyangze <zhenyangze@gmail.com>
 * @license MIT
 */
ini_set("memory_limit", -1);
$file = $argv[1] ?? '';
if (!is_file($file)) {
    die("文件不存在");
}

function loadXmlData($file)
{
    $contents = file_get_contents($file);
    $lines = explode("\n", $contents);
    $wordList = [];
    foreach($lines as $line) {
        $data = explode("	", $line, 2);
        if (!empty($data[0]) && !empty($data[1])) {
            $wordList[] = $data[0];
        }
    }

    return $wordList;
}


$newFileContents = file_get_contents($file);
$newFileList = explode("\n", $newFileContents);

$dictList = loadXmlData("wubi86_jidian.dict.yaml");
$extList = loadXmlData("wubi86_jidian_extra.dict.yaml");

$dictList = array_merge($dictList, $extList);

foreach($newFileList as $line) {
    $lineList = explode(' ', $line);
    $key = '';
    foreach($lineList as $index => $item) {
        $item = trim($item);
        if ($index == 0) {
            $key = $item;
            continue;
        }

        if (!in_array($item, $dictList)) {
            echo trim($item) . "¦  " . $key . "\n";
        }
    }
}