<?php

/**
 * 坐标记录
 */
define("BASEPATH", dirname(__FILE__) . '/');
include_once BASEPATH . 'config/system.php';
include_once BASEPATH . 'config/conf.php';
include_once BASEPATH . 'config/database.php';
include_once INCLUDE_PATH . 'libraries/Auth.class.php';

$input = new CI_Input();
$username = trim($input->get_post('user'));
$imei = trim($input->get_post('imei'));
$udid = trim($input->get_post('udid'));

$auth = Auth::getInstance($dbconfig['mainuser']);
$reVal = array('content' => '', 'status' => 103);
//if (empty($username) || empty($udid) || empty($imei)) {
if (empty($username) || empty($imei)) {
    $reVal['content'] = _display_error('102');
    $reVal['status'] = 102;
} elseif (!$auth->verify()) {
    $reVal['content'] = _display_error('101');
    $reVal['status'] = 101;
} else {
	$temp_1 = array();
//    $query = $auth->_main_user_db->query("select info from T_imeixy_log where imei='" . $imei . "'");
	  $query = $auth->_main_user_db->query("select info from `T_imeixy_log` where `imei`='" . $imei . "' and `addtime` >=  NOW() - interval 1 day");
	if ($query && $query->num_rows() > 0) {
		$result = $query->result_array();
		foreach ($result as $k => $v) {
			$data = unserialize($v['info']);
//			foreach ($data as $val) {
				$temp_1[$k] = $data;
//			}
		}
		$reVal['status'] = 0;
		$reVal['xylist'] = $temp_1;
	}
	else{
		$reVal['content'] = _display_error('901');
		$reVal['status'] = 901;
	}
    unset($query);
}
echo json_encode($reVal);
