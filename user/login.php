<?php

/*
  登陆认证接口
 */

define("BASEPATH", dirname(__FILE__) . '/');
include_once BASEPATH . 'config/system.php';
include_once BASEPATH . 'config/conf.php';
include_once BASEPATH . 'config/database.php';
include_once INCLUDE_PATH . 'libraries/Auth.class.php';

$input = new CI_Input();
$username = trim($input->get_post('user'));
$upass = trim($input->get_post('upass'));

$reVal = array('content' => '', 'userid' => '', 'token' => '', 'status' => 103);
if (empty($username) || empty($upass)) {
	$reVal['content'] = _display_error('102');
	$reVal['status'] = 102;
} else {
	$auth = Auth::getInstance($dbconfig['mainuser']);
	$loginfo = $auth->u_login($username, $auth->encrypt($upass));
	if (!empty($loginfo) && is_array($loginfo)) {
		$reVal['status'] = 0;
		$reVal['content'] = 'success';
		$reVal['userid'] = $loginfo['userid'];
		$reVal['token'] = $loginfo['token'];
		$reVal['imei'] = $loginfo['imei'];
	} else {
		$reVal['content'] = _display_error('104');
		$reVal['status'] = 104;
	}
}
echo json_encode($reVal);
?>