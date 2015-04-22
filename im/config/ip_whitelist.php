<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$whilelist = array(
    '127.0.0.1' => 1,
    '121.40.144.58' => 1,
);
if (!isset($whilelist[$_SERVER["REMOTE_ADDR"]])) {
    header("HTTP/1.1 403 Forbidden");
    echo '403';
    exit;
}