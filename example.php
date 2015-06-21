<?php

// Download CwsDump at https://github.com/crazy-max/CwsDump
require_once '../CwsDump/class.cws.dump.php';
$cwsDump = new CwsDump();

// Download CwsDebug at https://github.com/crazy-max/CwsDebug
require_once '../CwsDebug/class.cws.debug.php';
$cwsDebug = new CwsDebug($cwsDump);
$cwsDebug->setDebugVerbose();
$cwsDebug->setEchoMode();

// Download CwsCurl at https://github.com/crazy-max/CwsCurl
require_once '../CwsCurl/class.cws.curl.php';
$cwsCurl = new CwsCurl(new CwsDebug($cwsDump));

require_once 'class.cws.sharecount.php';
$cwsShareCount = new CwsShareCount($cwsDebug, $cwsCurl);

$result = $cwsShareCount->getAll('https://www.google.com/');
