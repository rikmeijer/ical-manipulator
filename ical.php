<?php

require __DIR__ . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";

function println(string $message) {
    fwrite(STDOUT, $message . PHP_EOL);
}

function debug(string $message) {
    fwrite(STDERR, $message . PHP_EOL);
    
}

function error(string $message) {
    debug($message);
    exit;
}

function parseDate(string $date) {
    return new DateTime($date);
}

if ($_SERVER['argc'] < 4) {
    error('Please enter at least 2 arguments (path, startdate)');
}


$vcalendar = Sabre\VObject\Reader::read(fopen($_SERVER['argv'][1],'r'));

$startdate = parseDate($_SERVER['argv'][2]);
$enddate = parseDate($_SERVER['argv'][3]);
debug("Printing all events where startdate between " . $startdate->format("d/m/Y") . " and " . $enddate->format("d/m/Y"));

foreach ($vcalendar->VEVENT as $event) {
    if ($event->DTSTART->getDateTime() < $startdate) {
        continue;
    } elseif ($event->DTSTART->getDateTime() > $enddate) {
        continue;
    }

    println(Sabre\VObject\Writer::write($event));
}

