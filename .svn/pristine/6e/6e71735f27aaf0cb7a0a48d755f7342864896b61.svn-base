<<<<<<< HEAD
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
include_once INCLUDE_PATH . 'libraries/Redis.class.php';


$input = new CI_Input();
$mode = trim($input->get_post('mode'));
$contact = trim($input->get_post('contact'));
$body = trim($input->get_post('body'));
$username = trim($input->get_post('user'));
$auth = Auth::getInstance($dbconfig['mainuser']);
$reVal = array('content' => '', 'status' => 103);
if (empty($contact) || empty($body)) {
	$reVal['content'] = _display_error('102');
	$reVal['status'] = 102;
} elseif (!$auth->verify()) {
	$reVal['content'] = _display_error('101');
	$reVal['status'] = 101;
} else {
	$redis = new RedisInit();

	$user = new user_model();
	$info = $user->get_user_info('username', $username);
	if (!empty($info['id'])){
		$feedback_data = array(
			'userid' => $info['id'],
			'username' => $username,
			'platform' => CLIENT_PLATFORM . "(" . CLIENT_VERSION . ")",
			'modeinfo' => $mode,
			'contact' => $contact,
			'content' => $body
		);
	unset($info);
	$log_db = DB($dbconfig['mainuser'], true);
//	$query = $log_db->query("select count(id) as sumcount from T_feedback_info where userid=" . $auth->_auth_userid . " and  DATE(`addtime`) = CURDATE()");
//	if ($query->row()->sumcount < 3) {
	$dis = strtotime(date("Y-m-d 23:59:59")) - time();
//	echo $dis;exit;
	$num = $redis->redis()->get('feedback_' . $username);
	$num = !empty($num) ? $num : 0;
	if ($num < 3) {

		if ($log_db->insert('T_feedback_info', $feedback_data) && $log_db->affected_rows() > 0) {
			$redis->redis()->set('feedback_'. $username, ++$num, $dis);
			$reVal['status'] = 0;
			$reVal['content'] = _display_error('138');
		}
	} else {
		$reVal['status'] = 157;
		$reVal['content'] = _display_error('157');
	}
}
	else{
		$reVal['content'] = _display_error('102');
		$reVal['status'] = 102;
	}
//	unset($query);
}
echo json_encode($reVal);
?>
=======
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
include_once INCLUDE_PATH . 'libraries/Redis.class.php';


$input = new CI_Input();
$mode = trim($input->get_post('mode'));
$contact = trim($input->get_post('contact'));
$body = trim($input->get_post('body'));
$username = trim($input->get_post('user'));
$auth = Auth::getInstance($dbconfig['mainuser']);
$reVal = array('content' => '', 'status' => 103);
if (empty($contact) || empty($body)) {
	$reVal['content'] = _display_error('102');
	$reVal['status'] = 102;
} elseif (!$auth->verify()) {
	$reVal['content'] = _display_error('101');
	$reVal['status'] = 101;
} else {
	$redis = new RedisInit();

	$user = new user_model();
	$info = $user->get_user_info('username', $username);
	if (!empty($info['id'])){
		$feedback_data = array(
			'userid' => $info['id'],
			'username' => $username,
			'platform' => CLIENT_PLATFORM . "(" . CLIENT_VERSION . ")",
			'modeinfo' => $mode,
			'contact' => $contact,
			'content' => $body
		);
	unset($info);
	$log_db = DB($dbconfig['mainuser'], true);
//	$query = $log_db->query("select count(id) as sumcount from T_feedback_info where userid=" . $auth->_auth_userid . " and  DATE(`addtime`) = CURDATE()");
//	if ($query->row()->sumcount < 3) {
	$dis = strtotime(date("Y-m-d 23:59:59")) - time();
//	echo $dis;exit;
	$num = $redis->redis()->get('feedback_' . $username);
	$num = !empty($num) ? $num : 0;
	if ($num < 3) {

		if ($log_db->insert('T_feedback_info', $feedback_data) && $log_db->affected_rows() > 0) {
			$redis->redis()->set('feedback_'. $username, ++$num, $dis);
			$reVal['status'] = 0;
			$reVal['content'] = _display_error('138');
		}
	} else {
		$reVal['status'] = 157;
		$reVal['content'] = _display_error('157');
	}
}
	else{
		$reVal['content'] = _display_error('102');
		$reVal['status'] = 102;
	}
//	unset($query);
}
echo json_encode($reVal);
?>
>>>>>>> 63b94a7e1b4167248a21999ae09c4dde81b786e9
