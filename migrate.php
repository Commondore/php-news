<?php

require_once __DIR__ . '/vendor/autoload.php';

foreach (glob(__DIR__ . '/database/migrations/*.php') as $filename) {
    require $filename;
}
