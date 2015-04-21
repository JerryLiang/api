<?php

/*
  获取老人机的信息
 */

define("BASEPATH", dirname(__FILE__) . '/');
include_once BASEPATH . 'config/system.php';
include_once BASEPATH . 'config/conf.php';
include_once BASEPATH . 'config/database.php';
include_once INCLUDE_PATH . 'libraries/Auth.class.php';

$input = new CI_Input();
$username = trim($input->get_post('user'));
$imei = trim($input->get_post('imei'));

$img_url_prefix = $url_prefixs[array_rand($url_prefixs)];
$auth = Auth::getInstance($dbconfig['mainuser']);
$reVal = array('content' => '', 'status' => 103);
if (empty($username) || empty($imei)) {
	$reVal['content'] = _display_error('102');
	$reVal['status'] = 102;
} elseif (!$auth->verify()) {
	$reVal['content'] = _display_error('101');
	$reVal['status'] = 101;
} else {
	$query = $auth->_main_user_db->query("select names,headimag,sex,mobile,birthday,info from `T_phone_info` WHERE `imei`='" . $imei . "' limit 1");
	if ($query && $query->num_rows() > 0) {
		$info = $query->row_array();
		$reVal['status'] = 0;
		$reVal['names'] = !empty($info['names']) ? $info['names'] : '';
		$reVal['sex'] = strlen($info['sex']) > 0 ? $info['sex'] : ''; //0是男，1是女
		$reVal['mobile'] = strlen($info['mobile']) > 0 ? $info['mobile'] : '';
		$reVal['images'] = !empty($info['headimag']) ? $img_url_prefix . $info['headimag'] : '';
		$reVal['birthday'] = !empty($info['birthday']) ? $info['birthday'] : '';
		if (!empty($info['info'])) {
			$temp = unserialize($info['info']);
			$reVal['info']['start'] = !empty($temp['start']) ? $temp['start'] : '';
			$reVal['info']['shutdown'] = !empty($temp['shutdown']) ? $temp['shutdown'] : '';
			$reVal['info']['x'] = !empty($temp['x']) ? $temp['x'] : '';
			$reVal['info']['y'] = !empty($temp['y']) ? $temp['y'] : '';
			$reVal['info']['kwh'] = !empty($temp['kwh']) ? $temp['kwh'] : '';
		}
	}
	unset($query);
	$query = $auth->_main_user_db->query("select isadmin from `T_group_info` WHERE `imei`='" . $imei . "' limit 1");
	if($query && $query->num_rows() > 0){
		$info = $query->row_array();
		if($info['isadmin'] == $username){
			$reVal['isadmin'] = 1;
		}
		else{
			$reVal['isadmin'] = 0;
		}
	}
}
echo json_encode($reVal);
?>