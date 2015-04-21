<?php

/*
  关于我们
 */

define("BASEPATH", dirname(__FILE__) . '/');
include_once BASEPATH . 'config/system.php';
include_once BASEPATH . 'config/conf.php';
include_once BASEPATH . 'config/database.php';
include_once INCLUDE_PATH . 'libraries/Auth.class.php';

$auth = Auth::getInstance($dbconfig['mainuser']);
$reVal = array('content' => '', 'status' => 103);
if (!$auth->verify()) {
    $reVal['content'] = _display_error('101');
    $reVal['status'] = 101;
} else {
    $reVal['status'] = 0;
    $reVal['version'] = CLIENT_VERSION;
    $reVal['company'] = '啊哩咕哩';
    $reVal['contact'] = 'xxxx-xxxx';
}
echo json_encode($reVal);
?>
