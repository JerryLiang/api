<?php

/*
  获取个人的信息
 */

define("BASEPATH", dirname(__FILE__) . '/');
include_once BASEPATH . 'config/system.php';
include_once BASEPATH . 'config/conf.php';
include_once BASEPATH . 'config/database.php';
include_once INCLUDE_PATH . 'libraries/Auth.class.php';

$input = new CI_Input();
$username = trim($input->get_post('user'));

$img_url_prefix = $url_prefixs[array_rand($url_prefixs)];
$auth = Auth::getInstance($dbconfig['mainuser']);
$reVal = array('content' => '', 'status' => 103);
if (empty($username)) {
	$reVal['content'] = _display_error('102');
	$reVal['status'] = 102;
} elseif (!$auth->verify()) {
	$reVal['content'] = _display_error('101');
	$reVal['status'] = 101;
} else {
	$query = $auth->_main_user_db->query("select names,headimag,sex,birthday from `T_user_info` WHERE `username`='" . $username . "' limit 1");
	if ($query && $query->num_rows() > 0) {
		$info = $query->row_array();
		$reVal['status'] = 0;
		$reVal['names'] = !empty($info['names']) ? $info['names'] : '';
		$reVal['sex'] = strlen($info['sex']) > 0 ? $info['sex'] : '';
		$reVal['images'] = !empty($info['headimag']) ? $img_url_prefix . $info['headimag'] : '';
		$reVal['birthday'] = !empty($info['birthday']) ? $info['birthday'] : '';
	}
	unset($query);
}
echo json_encode($reVal);
?>