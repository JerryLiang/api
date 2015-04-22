<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2014/11/25
 * Time: 11:48
 */

class ImServerApi{
	var $cache;
	function __construct(){
		include_once INCLUDE_PATH . 'libraries/Redis.class.php';
		$this->cache = new RedisInit();
	}

	function get_server($serverlist){
//		$serverlist =array();
//		$serverlist = $sips_server_config;
		foreach($serverlist as $key => $val) {
			//根据在线人数和服务器状态选择
			$status = $this->poccess_online($val);
			if($status)
			$weight[$key] = $val['weight'];
		}
		$hid = $this->__roll($weight);
		$server = $serverlist[$hid];
		return $server;
	}

	 function __roll($weight){
		$roll = rand ( 1, array_sum ( $weight ));
		$_tmpW = 0;
		$rollnum = 0;
		foreach ( $weight as $k => $v ) {
			$min = $_tmpW;
			$_tmpW += $v;
			$max = $_tmpW;
			if ($roll > $min && $roll <= $max) {
				$rollnum = $k;
				break;
			}
		}
		return $rollnum;
	}

	private function poccess_online($server){
		$result = array();
		$key = $server['ip'].':'.$server['port'];
		$con = $this->cache->redis()->get($key);
		$con = explode(',',$con);
		foreach($con as $v){
			$c = explode(':',$v);
			$result[$c[0]] = $c[1];
		}
		if($result['state'] && $result['now'] < $result['max']){
			return true;
		}
		return false;
	}
}