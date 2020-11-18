<?php
require_once __DIR__ . '/src/HJSON/HJSONException.php';
require_once __DIR__ . '/src/HJSON/HJSONParser.php';
require_once __DIR__ . '/src/HJSON/HJSONStringifier.php';
require_once __DIR__ . '/src/HJSON/HJSONUtils.php';

use HJSON\HJSONStringifier;

$data = [];

for ($i=1;$i<=300;$i++)
{
    $data['key'.$i] = [
        'name' => 'name'.$i,
        'value' => 'value'.$i,
        'other' => 'other'.$i,
    ];
}

$json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
file_put_contents(__DIR__.'/tests/assets/large_file_test.json', $json);

$stringifier = new HJSONStringifier;
$hjson = $stringifier->stringify($data);
file_put_contents(__DIR__.'/tests/assets/large_file_result.hjson', $json);
