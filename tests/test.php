<?php

require_once __DIR__.'/../vendor/autoload.php'; // Autoload files using Composer autoload

$cwsDebug = new Cws\CwsDebug();
$cwsDebug->setDebugVerbose();
$cwsDebug->setEchoMode();

$cwsCurl = new Cws\CwsCurl(new Cws\CwsDebug());

// Start CwsShareCount
$cwsShareCount = new Cws\CwsShareCount($cwsDebug, $cwsCurl);

$result = $cwsShareCount->getAll('https://www.google.com/');
