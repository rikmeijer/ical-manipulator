<?php

require __DIR__ . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

function error(string $message) {
    print $message;
    exit(PHP_EOL);
}

if ($_SERVER['argc'] < 2) {
    error('Please enter at least 1 argument');
}

$vcalendar = Sabre\VObject\Reader::read(fopen($_SERVER['argv'][1],'r'));
echo $vcalendar->VEVENT->SUMMARY;