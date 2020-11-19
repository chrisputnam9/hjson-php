<?php
require_once __DIR__ . '/src/HJSON/HJSONException.php';
require_once __DIR__ . '/src/HJSON/HJSONParser.php';
require_once __DIR__ . '/src/HJSON/HJSONStringifier.php';
require_once __DIR__ . '/src/HJSON/HJSONUtils.php';

use HJSON\HJSONParser;

function l($data)
{
    static $last = 0;
    $current = microseconds();
    if ($last == 0) $last = $current;
    $elapsed = number_format(round($current - $last, 4), 4);

    echo date('H:i:s') . substr((string)microtime(), 1, 8) . ' (' . $elapsed . ') ... ' . $data . "\n";
    $last = $current;
}

function microseconds()
{
    list($usec, $sec) = explode(" ", microtime());
    return 1000 * ((float)$usec + (float)$sec);
}

echo "Loading file...\n";
$json = file_get_contents(__DIR__.'/tests/assets/large_file_test.json');
echo "DONE\n";

echo "json_decode...\n";
$data = json_decode($json);
echo "DONE\n";

echo "HJSON Parse...\n---------------------------------------------\n";
l("init1");
l("init2");
echo "---------------------------------------------\n";
$parser = new HJSONParser;
$data = $parser->parse($json);
echo "---------------------------------------------\nDONE\n";
