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
if (empty($imei) || empty($action)) {
	echo '102';
	exit;
} else {
	$user = new user_model();
	switch ($action) {
		case 'check':
			//代理商
			$agent = trim($input->get_post('agent'));
			$info = $user->check_record("select id from `T_group_info` WHERE `imei`='" . $imei . "'");
			if ($info) {
				echo '200';
			} else {
				echo '201';
			}
			if(!empty($agent)){
				$user->update_userinfo('T_phone_info','imei',$imei,array('agent'=>$agent));
			}
			_logger(_LL_DEBUG, "\n imei = ".$imei."checkdata ==".print_r($info,true));
			unset($info);
			break;
		case 'upload':
			$location = trim($input->get_post('location'));
			$start = trim($input->get_post('start'));
			$shutdown = trim($input->get_post('shutdown'));
			$kwh = trim($input->get_post('kwh'));
			//_logger(_LL_DEBUG, "\n location==" . $location . "===starttime===" . $start . "===endtime===" . $shutdown . "===kwh===" . $kwh);
			if (empty($location) || strlen($kwh) == 0) {
				echo '202';
				exit;
			} else {
				//获取xy
				$return = _fetch_api("http://minigps.net/as?x=" . $location);
				$result_arry = json_decode($return, true);
				//_logger(_LL_DEBUG, "\n map==".print_r($result_arry,true));
//				echo $location;exit;

				if (is_array($result_arry)) {
					$map = $result_arry['map'];
					$x = $result_arry['lat'];
					$y = $result_arry['lon'];
//					var_dump($result_arry);exit;
				}
				else{
					$map = $x = $y ='';
				}
				$data = array(
					'start' => $start,
					'shutdown' => $shutdown,
					'kwh' => $kwh,
					'x' => $x,
					'y' => $y
				);
				$user_db = DB($dbconfig['mainuser'], true);
				$imeiquery = $user_db->query("select id from `T_phone_info` WHERE  `imei`='" . $imei . "' limit 1");
				if ($imeiquery && $imeiquery->num_rows() > 0) {
					$status = $user_db->query("update T_phone_info set info='" . serialize($data) . "' where imei='" . $imei . "'");
				} else {
					$insertdata = array(
						'imei' => $imei,
						'info' => serialize($data)
					);
					$status = $user_db->insert('T_phone_info', $insertdata);
				}
				unset($imeiquery);
				if ($status && $user_db->affected_rows() > 0) {
					echo '200';
				}
				unset($status);
				//日志
//				$query = $user_db->query("select info from `T_imeixy_log` where `imei`='" . $imei . "' and `addtime` >=  NOW() - interval 1 day");
//				if ($query && $query->num_rows() > 0) {
//					$info = unserialize($query->row()->info);
					$ret = array('time' => time(),'x' => $data['x'], 'y' => $data['y']);
					$ret =serialize($ret);
//					if (is_array($info)) {
//						$info[] = array('time' => time(), 'x' => $x, 'y' => $y);
//						$user_db->query("update T_imeixy_log set info='" . serialize($info) . "' where imei='" . $imei . "'");
						$par = array('addtime'=>date("Y-m-d H:i:s"),'imei'=>$imei,'info'=>$ret);
						$user_db->insert('T_imeixy_log', $par);
//					}
//				} else {
//					$user_db->query("update T_imeixy_log set info='" . serialize(array('time' => time(), 'x' => $x, 'y' => $y)) . "',addtime=now() where imei='" . $imei . "'");
//				}
				_logger(_LL_DEBUG, "\n uploaddata ==".print_r($data,true));
				unset($query);
//			}
				break;
			}
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

?>
