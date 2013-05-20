<?php

include('class.cws.sharecount.php');

// Download CwsCurl at https://github.com/crazy-max/CwsCurl
include('class.cws.curl.php');

$cwsShareCount = new CwsShareCount();
$cwsShareCount->debug_verbose = CWSSC_VERBOSE_DEBUG; // default : CWSSC_VERBOSE_QUIET

$result = $cwsShareCount->getAll("http://plus.google.com");

?>