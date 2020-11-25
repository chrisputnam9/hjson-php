<?php

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
//$json = file_get_contents(__DIR__.'/tests/assets/large_file_test.json');
$json = file_get_contents(__DIR__.'/tests/assets/very_large_file.json');
echo "DONE\n";

l("init");
l("init");

/**
 * Process:
 *  - Got through string char by char
 *  - Count alphanumeric chars - just to have something to check
 */

l("1. preg_split, then foreach through array");
$count=0;
$chars = preg_split("//u", $json, null, PREG_SPLIT_NO_EMPTY);
foreach ($chars as $char)
{
    if (preg_match("/[a-z0-9]/i", $char)) $count++;
}
l("Done.  Count: $count");

// ----------------------------------------------------------

l("2. preg_split, then shift through array");
l(" - RULED OUT - VERY SLOW.");
/*
$count=0;
$chars = preg_split("//u", $json, null, PREG_SPLIT_NO_EMPTY);
$char = array_shift($chars);
while ($char !== null)
{
    if (preg_match("/[a-z0-9]/i", $char)) $count++;
    $char = array_shift($chars);
}
l("Done.  Count: $count");
 */

// ----------------------------------------------------------

l("3. preg_split, then Queue");
$count=0;
$chars = preg_split("//u", $json, null, PREG_SPLIT_NO_EMPTY);
$queue = new \Ds\Queue($chars);
while (!$queue->isEmpty())
{
    $char = $queue->pop();
    if (preg_match("/[a-z0-9]/i", $char)) $count++;
}
l("Done.  Count: $count");

// ----------------------------------------------------------

l("4. Pull off one character at a time");
l(" - RULED OUT - VERY SLOW.");
/*
$count=0;
$remainder = $json;
while ($remainder)
{
    $char = mb_substr($remainder,0, 1);
    $remainder = mb_substr($remainder, 1);
    if (preg_match("/[a-z0-9]/i", $char)) $count++;
}
l("Done.  Count: $count");
 */

// ----------------------------------------------------------

l("5. Original: mb_strcut, increment index");
l(" - RULED OUT - VERY SLOW.");
/*
$count=0;
$i=0;
while (strlen($json) > $i)
{
    $char = mb_substr(mb_strcut($json, $i), 0, 1);
    if (preg_match("/[a-z0-9]/i", $char)) $count++;
    $i++;
}
l("Done.  Count: $count");
 */

// ----------------------------------------------------------

l("6. One char at a time, via index & iterable function");
l(" - RULED OUT - VERY SLOW.");
/*
$count=0;
$gen = (function(string $str) {
    for ($i = 0, $len = mb_strlen($str); $i < $len; ++$i) {
        yield mb_substr($str, $i, 1);
    }
})($json);
foreach ($gen as $char)
{
    if (preg_match("/[a-z0-9]/i", $char)) $count++;
}
l("Done.  Count: $count");
 */
