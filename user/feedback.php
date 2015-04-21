<?php

/*
  用户反馈信息
 */

define("BASEPATH", dirname(__FILE__) . '/');
include_once BASEPATH . 'config/system.php';
include_once BASEPATH . 'config/conf.php';
include_once BASEPATH . 'config/database.php';
include_once BASEPATH . 'model/user.php';
include_once INCLUDE_PATH . 'libraries/Auth.class.php';

$input = new CI_Input();
$mode = trim($input->get_post('mode'));
$contact = trim($input->get_post('contact'));
$body = trim($input->get_post('body'));

$auth = Auth::getInstance($dbconfig['mainuser']);
$reVal = array('content' => '', 'status' => 103);
if (empty($contact) || empty($body)) {
	$reVal['content'] = _display_error('102');
	$reVal['status'] = 102;
} elseif (!$auth->verify()) {
	$reVal['content'] = _display_error('101');
	$reVal['status'] = 101;
} else {
	$user = new user_model();
	$info = $user->get_userinfo($auth->_auth_userid);
	$feedback_data = array(
		'userid' => isset($auth->_auth_userid) ? $auth->_auth_userid : '',
		'username' => (string)$info['username'],
		'platform' => CLIENT_PLATFORM . "(" . CLIENT_VERSION . ")",
		'modeinfo' => $mode,
		'contact' => $contact,
		'content' => $body
	);
	unset($info);
	$log_db = DB($dbconfig['mainuser'], true);
	$query = $log_db->query("select count(id) as sumcount from T_feedback_info where userid=" . $auth->_auth_userid . " and  DATE(`addtime`) = CURDATE()");
	if ($query->row()->sumcount < 2) {
		if ($log_db->insert('T_feedback_info', $feedback_data) && $auth->_main_user_db->affected_rows() > 0) {
			$reVal['status'] = 0;
			$reVal['content'] = _display_error('138');
		}
	} else {
		$reVal['status'] = 157;
		$reVal['content'] = _display_error('157');
	}
	unset($query);
}
echo json_encode($reVal);
?>
