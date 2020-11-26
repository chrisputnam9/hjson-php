<?php
require_once __DIR__ . '/src/HJSON/HJSONException.php';
require_once __DIR__ . '/src/HJSON/HJSONParser.php';
require_once __DIR__ . '/src/HJSON/HJSONStringifier.php';
require_once __DIR__ . '/src/HJSON/HJSONUtils.php';

use HJSON\HJSONParser;
use HJSON\HJSONStringifier;

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

l("Init timer");
l("Init timer - something silly happening here...");
echo "---------------------------------------------\n";

l("Loading file...");
$json = file_get_contents(__DIR__.'/tests/assets/large_file_test.json');
l("DONE");

l("json_decode...");
$data = json_decode($json);
l("DONE");

l("HJSON Parse...");
echo "---------------------------------------------\n";
l("Profile setting: " . ini_get('xdebug.profiler_enable') . " (use `php -d xdebug.profiler_enable=On` to enable)");
l("Profiling with output to: " . ini_get('xdebug.profiler_output_dir'));
echo "---------------------------------------------\n";
l("Parsing...");
$parser = new HJSONParser;
$data = $parser->parse($json);
l("Done parsing");
echo "---------------------------------------------\n";
print_r($data);
l("Stringifying...");
$stringifier = new HJSONStringifier;
$json = $stringifier->stringify($data);
l("Done stringifying");
echo "---------------------------------------------\nDONE\n";
