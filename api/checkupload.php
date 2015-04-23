<?php

/*
  老人机定时上传，开机检测
 */

define("BASEPATH", dirname(__FILE__) . '/');
include_once BASEPATH . 'config/system.php';
include_once BASEPATH . 'config/conf.php';
include_once BASEPATH . 'config/database.php';

define('USER_PATH', realpath(BASEPATH . '../') . '/user/');
include_once USER_PATH . 'model/user.php';

$input = new CI_Input();
$imei = trim($input->get_post('imei'));
$action = trim($input->get_post('action'));
$format = trim($input->get_post('format'));
$user_db = '';
if ($format == 'json') {

} else {
	header("Content-Type: text/html;charset=utf-8");
	header("Content-Length: 3");
}
$format = !empty($format) ? $format :'txt';

//header("Cache-Control: no-cache");
//header("Pragma: no-cache");
if (empty($imei) || empty($action)) {
	sendput('102',$format);
	exit;
} else {
	$user = new user_model();
	switch ($action) {
		case 'check':
			//代理商
//			echo "dsadsa";exit;
			$agent = trim($input->get_post('agent'));
			$model = trim($input->get_post('model'));
			$info = $user->check_record("select id from `T_group_info` WHERE `imei`='" . $imei . "'");
			$url = 'http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
			_logger(_LL_DEBUG, "line:" . __LINE__ . "\n imei = " . $imei . "\n  checkdata ==" . print_r($info, true) . "   url =" . $url);

			if ($info) {
				sendput('200',$format);
			} else {
				sendput('201',$format);
			}
			if (!empty($agent)) {
				$item = $user->get_item('T_phone_info', array('imei' => $imei));
				if (empty($item['agent'])) {
					$checkdata = array('agent' => $agent, 'model' => $model, 'checktime' => date("Y-m-d H:i:s"));
					$user->update_userinfo('T_phone_info', 'imei', $imei, $checkdata);
				} elseif ($item['agent'] == $agent && $item['model'] == $model) {
				} else {
					$checkdata = array('agent' => $agent, 'model' => $model);
					$user->update_userinfo('T_phone_info', 'imei', $imei, $checkdata);
				}
			}
//			_logger(_LL_DEBUG, "line:".__LINE__."\n imei = ".$imei."\n   checkdata ==".print_r($info,true));
			unset($info);
			break;
		case 'upload':
			$location = trim($input->get_post('location'));
			//智能客户端传的x坐标
			$lat = trim($input->get_post('lat'));
			//智能客户端传的y坐标
			$lon = trim($input->get_post('lon'));
			$ta = trim($input->get_post('ta'));
			$start = trim($input->get_post('start'));
			$shutdown = trim($input->get_post('shutdown'));
			$kwh = trim($input->get_post('kwh'));
			_logger(_LL_DEBUG, "\n imei=".$imei."====location==" . $location . "===starttime===" . $start . "===endtime===" . $shutdown . "===kwh===" . $kwh);
//			if (empty($location) || strlen($kwh) == 0) {
			if (!empty($location)) {
//				echo '202';
//				exit;
//			} else {
				//获取xy
				$return = _fetch_api("http://minigps.net/as?x=" . $location . '&ta=' . $ta . '&p=1&mt=0&needaddress=0');
//				var_dump($return);exit;
//				echo "sdasd";exit;

				$result_arry = json_decode($return, true);
			} else {
				$result_arry = '';
				$result_arry['lat'] = $lat;
				$result_arry['lon'] = $lon;
				$result_arry['map'] = '';
			}
			//_logger(_LL_DEBUG, "\n map==".print_r($result_arry,true));
//				echo $location;exit;
			if (is_array($result_arry)) {
				$map = $result_arry['map'];
				$x = $result_arry['lat'];
				$y = $result_arry['lon'];
//					var_dump($result_arry);exit;
			} else {
				$map = $x = $y = '';
				_logger(_LL_DEBUG, "\n imei = " . $imei . 'return:' . $return);
				sendput('205',$format);
			}
			$data = array(
				'start' => $start,
				'shutdown' => $shutdown,
				'kwh' => $kwh,
				'x' => $x,
				'y' => $y
			);
//			print_r($data);exit;
			$user_db = DB($dbconfig['mainuser'], true);
			$imeiquery = $user_db->query("select id from `T_phone_info` WHERE  `imei`='" . $imei . "' limit 1");
			if ($imeiquery && $imeiquery->num_rows() > 0) {
				if ($data['x'] || $data['y'])
					$status = $user_db->query("update T_phone_info set info='" . serialize($data) . "' where imei='" . $imei . "'");
			} else {
//					$insertdata = array(
//						'imei' => $imei,
//						'info' => serialize($data)
//					);
//					$status = $user_db->insert('T_phone_info', $insertdata);
				sendput('205',$format);
				exit;
			}

			unset($imeiquery);
//			if (!empty($status) && $user_db->affected_rows() > 0) {
//			}
			unset($status);

			//日志
//				$query = $user_db->query("select info from `T_imeixy_log` where `imei`='" . $imei . "' and `addtime` >=  NOW() - interval 1 day");
//				if ($query && $query->num_rows() > 0) {
//					$info = unserialize($query->row()->info);
			$ret = array('time' => time(), 'x' => $data['x'], 'y' => $data['y']);
			$ret = serialize($ret);
//					if (is_array($info)) {
//						$info[] = array('time' => time(), 'x' => $x, 'y' => $y);
//						$user_db->query("update T_imeixy_log set info='" . serialize($info) . "' where imei='" . $imei . "'");
			$par = array('addtime' => date("Y-m-d H:i:s"), 'imei' => $imei, 'info' => $ret);
			if ($data['x'] || $data['y'])
				$user_db->insert('T_imeixy_log', $par);
//					}
//				} else {
//					$user_db->query("update T_imeixy_log set info='" . serialize(array('time' => time(), 'x' => $x, 'y' => $y)) . "',addtime=now() where imei='" . $imei . "'");
//				}
//			_logger(_LL_DEBUG, "\n imei = " . $imei . ",uploaddata ==" . print_r($data, true));
			unset($query);
//			}
			sendput('200',$format);
			break;
		case 'upload_imei':
			$pass = rand_string(6);
			if(!is_object($user_db)){
				$user_db = DB($dbconfig['mainuser'], true);
			}
			$data= array('imei'=>$imei,'pass'=>$pass);
			$user_db->where('imei',$imei);
			$query = $user_db->get('T_phone_info');
			if($query->num_rows() == 0){
				$user_db->insert('T_phone_info',$data);
				sendput('200',$format);
			}else{
				sendput('200',$format);
			}
			break;
//			}
	}

}

function _fetch_api($url, $data = array())
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	if (!empty($data) && is_array($data)) {
		foreach ($data as $key => $val) {
			$url .= '&' . $key . '=' . $val;
		}
	}
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// 设置连接超时时间 10 秒
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
	// 设置超时时间 30 秒
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	$out = curl_exec($ch);
	if ($out === false) {
		_logger(_LL_ERROR, 'Connect failed: ' . $url);
	} else {
		$out = trim($out);
	}
	curl_close($ch);
	return $out;
}


function rand_string($num = 6){
	$string ='0123456789';
	$pass = '';
	for($i=0;$i<$num;$i++){
		$pass .= substr($string,rand(1,10)-1,1);
	}
	return $pass;
}
//	echo "sdasd";exit;

?>
