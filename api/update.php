<?php

/*
  更新升级接口
 */

define("BASEPATH", dirname(__FILE__) . '/');
include_once BASEPATH . 'config/system.php';
include_once BASEPATH . 'config/conf.php';
include_once BASEPATH . 'config/database.php';
include_once INCLUDE_PATH . 'libraries/Auth.class.php';
include_once BASEPATH . 'model/api.php';

$auth = Auth::getInstance($dbconfig['mainuser']);
$reVal = array('content' => '','status' => 103);
if (!$auth->verify()) {
    $reVal['content'] = _display_error('101');
    $reVal['status'] = 101;
} else {
    $version = CLIENT_VERSION; 
    $api = new api_model();
    $upinfo = $api->get_upgrate();
    if (!empty($upinfo) && is_array($upinfo)) {
        $reVal['status'] = 0;
        $reVal['upgrate'] = $upinfo;
    } else {
        $reVal['status'] = 154;
        $reVal['content'] = _display_error('154') . "(" . $version . ")";
    }
    unset($upinfo);
}
echo json_encode($reVal);
?>
