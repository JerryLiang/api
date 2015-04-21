<?php

/*
  找回密码信息
 */
define("BASEPATH", dirname(__FILE__) . '/');
include_once BASEPATH . 'config/system.php';
include_once BASEPATH . 'config/conf.php';
include_once BASEPATH . 'config/database.php';
include_once BASEPATH . 'model/user.php';
include_once INCLUDE_PATH . 'libraries/Auth.class.php';
include_once INCLUDE_PATH . 'libraries/SmsGateway.class.php';

$input = new CI_Input();
$mobile = trim($input->get_post('mobile'));
//$udid = trim($input->get_post('udid'));

$auth = Auth::getInstance($dbconfig['mainuser']);
$reVal = array('content' => '', 'status' => 103);

//if (empty($mobile) || empty($udid)) {
if (empty($mobile)) {
	$reVal['content'] = _display_error('102');
	$reVal['status'] = 102;
} elseif (preg_match("/^1[0-9]{10}$/", $mobile)) {
	$reVal['content'] = _display_error('120');
	$reVal['status'] = 120;
} else {
	$user = new user_model();
	$usertinfo = $user->get_user_info("username", $mobile);
	if (!empty($usertinfo)) {
		$sms = new SmsGateway();
		$msg = "您的阿哩咕哩账号：" . $usertinfo['username'] . " ，密码：" . $auth->decrypt($usertinfo['userpass']) . " 请您妥善保管好！";
		$result = $sms->send_sms($mobile, "hztk", $msg);
		if ($result) {
			$reVal['status'] = 0;
			$reVal['content'] = _display_error('126');
		} else {
			$reVal['status'] = 127;
			$reVal['content'] = _display_error('127');
		}
	} else {
		$reVal['status'] = 129;
		$reVal['content'] = _display_error('129');
	}
	unset($usertinfo);
}
echo json_encode($reVal);

