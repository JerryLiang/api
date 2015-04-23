<?php

/*
 * 功能：im检测
 */

define("BASEPATH", dirname(__FILE__) . '/');
include_once BASEPATH . 'config/system.php';
include_once BASEPATH . 'config/conf.php';
include_once BASEPATH . 'config/database.php';
include_once BASEPATH . 'model/im.php';
//include_once BASEPATH . 'config/ip_whitelist.php';

$input = new CI_Input();
$imei = trim($input->get_post('imei'));
$reval = array('userid' => 0);
if (!empty($imei)) {
    $im = new im_model();
    $userinfo = $im->get_userinfo("T_user_info", "udid", $imei);
    if (!empty($userinfo['id'])) {
        $reval['userid'] = $userinfo['id'];
    }
    unset($userinfo);
}
echo json_encode($reval);
?>
