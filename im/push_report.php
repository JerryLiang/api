<?php
define("BASEPATH", dirname(__FILE__) . '/');
include_once BASEPATH . 'config/system.php';
include_once BASEPATH . 'config/conf.php';
include_once BASEPATH . 'config/database.php';
include_once INCLUDE_PATH . 'libraries/Auth.class.php';
include_once BASEPATH . 'model/im.php';
include_once INCLUDE_PATH . 'libraries/Redis.class.php';


$input = new CI_Input();
$username = $input->get_post('user');
$message = $input->get_post('msg');
$url = $input->get_post('url');
$type = $input->get_post('type');
$conf = $input->get_post('conf');
$im = new im_model();
$redis = new RedisInit();


if(strlen($conf)>0){

$ret = $im->update_data('T_ios_token',array('username'=>$username),array('option'=>$conf));
    $reVal['status'] = 0;
    $reVal['content'] = '设置成功';
    echo json_encode($reVal);exit;
}

if ($type == 1) {
	$result = $im->get_items('T_ios_token');
//	print_r($result);exit;
	foreach ($result as $v) {
		push_report($v['username'], '您收到一条语音消息', $redis, $im,COM_PEM);
		push_report($v['username'], '您收到一条语音消息', $redis, $im,FUN_PEM);
	}
} else {
	$rel = push_report($username, '您收到一条语音消息', $redis, $im,COM_PEM);
	$rel = push_report($username, '您收到一条语音消息', $redis, $im,FUN_PEM);
	echo json_encode($rel);
	exit;
}
//foreach()

function push_report($username, $message, $redis, $im,$p)
{
	$login_status = $redis->redis()->get('login_status_' . $username);
// Put your device token here (without spaces):
//$deviceToken = '0f744707bebcf74f9b7c25d48e3358945f6aa01da5ddb387462c7eaf61bbad78';
//$data = base64_decode(urldecode($message));

//_logger(_LL_DEBUG, 'username:' . $username.'message:'.print_r($message,true));
	$reVal = array('content' => '', 'status' => 103);
	if (!empty($username) && !empty($login_status)) {
		$msg_num = $redis->redis()->get('msg_num_' . $username);
		$Token = $im->get_usertoken($username);
		$deviceToken = !empty($Token['token']) ? $Token['token'] : '';
		$type = !empty($Token['type']) ? $Token['type'] : '';
		$str = 'Token:' . $deviceToken . '   ';
//	$pem = $type == 'phone' ? FUN_PEM : IOS_PEM;
		$pem = $p;

//$deviceToken = '01270142c919c5115ccdf7ed084d733c7cd1683ac26f825c62ef0c23ab82cf7d';

// Put your private key's passphrase here:
		$passphrase = 'pushchat';

// Put your alert message here:
//$message = 'My first push notification!';
		$message = $message;


////////////////////////////////////////////////////////////////////////////////

		$ctx = stream_context_create();
		stream_context_set_option($ctx, 'ssl', 'local_cert', $pem);
		stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
// Open a connection to the APNS server
		if (!empty($deviceToken)) {
			$fp = stream_socket_client(
				'ssl://gateway.push.apple.com:2195', $err,
				$errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);

			if (!$fp) {
				_logger(_LL_DEBUG, 'username:' . $username . ',Failed to connect:' . $err . $errstr . PHP_EOL);
				exit("Failed to connect: $err $errstr" . PHP_EOL);
			}
			$str .= 'Connected to APNS' . PHP_EOL;

// Create the payload body
			if (!$msg_num) {
				$redis->redis()->set('msg_num_' . $username, 0, strtotime('+7 days'));
			}
			$msg_num = $redis->redis()->incr('msg_num_' . $username);

            $sound = empty($Token['option']) ? 'tips.wav' : '';
			$body['aps'] = array(
				'alert' => $message,
//			'data'  => $data,
				'badge' => $msg_num,
				'sound' => $sound,
			);

// Encode the payload as JSON
			$payload = json_encode($body);

// Build the binary notification
			$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

// Send it to the server
			$result = fwrite($fp, $msg, strlen($msg));
			if (!$result) {
				$str .= 'Message not delivered' . PHP_EOL;
//		echo 'Message not delivered' . PHP_EOL;
			} else {
				$str .= 'Message successfully delivered' . PHP_EOL;
//			echo 'Message successfully delivered' . PHP_EOL;
				$reVal['status'] = 0;
				$reVal['content'] = 'success';

			}
// Close the connection to the server
			fclose($fp);
		}
		_logger(_LL_DEBUG, 'username:' . $username . ',status:' . $str);
	} else {
		$reVal['status'] = 102;
		$reVal['content'] = _display_error('102');
        $language = CLIENT_LANGUAGE;
		_logger(_LL_DEBUG, 'language:'.$language.'username:' . $username . ',' . print_r($reVal, true));
//			exit;
	}
	return $reVal;
}