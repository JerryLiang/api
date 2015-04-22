<?php

/*
  修改用户密码
 */
define("BASEPATH", dirname(__FILE__) . '/');
include_once BASEPATH . 'config/system.php';
include_once BASEPATH . 'config/conf.php';
include_once BASEPATH . 'config/database.php';
include_once INCLUDE_PATH . 'libraries/Auth.class.php';

$input = new CI_Input();
$oldpwd = trim($input->get_post('oldpwd')); //上传先加base64encode
$newpwd = trim($input->get_post('newpwd')); //上传先加base64encode
$auth = Auth::getInstance($dbconfig['mainuser']);
$reVal = array('content' => '', 'status' => 103);
//解密
$org_oldpwd = base64_decode($oldpwd);
$org_newpwd = base64_decode($newpwd);

if (empty($org_oldpwd) || empty($org_newpwd)) {
	$reVal['content'] = _display_error('102');
	$reVal['status'] = 102;
} elseif (!$auth->verify()) {
	$reVal['content'] = _display_error('101');
	$reVal['status'] = 101;
} elseif ($org_oldpwd == $org_newpwd) {
	$reVal['content'] = _display_error('137');
	$reVal['status'] = 137;
} else {
//	echo $auth->decrypt('00e49826a61697e5d9838085687882e2');exit;
	$modifinfo = $auth->u_modifpass($auth->_auth_userid, $auth->encrypt($org_oldpwd), $auth->encrypt($org_newpwd));
	if (!empty($modifinfo) && is_array($modifinfo)) {
		$reVal['status'] = 0;
		$reVal['content'] = _display_error('130');
		$reVal['token'] = $modifinfo['token'];
		$auth->_clearCache($auth->_auth_token);
	} else {
		$reVal['status'] = 131;
		$reVal['content'] = _display_error('131');
		$reVal['token'] = '';
	}
}
echo json_encode($reVal);
?>