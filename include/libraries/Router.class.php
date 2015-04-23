<?php

/**
 * 路由总表
 * 根据手机号码或用户ID定位到不同的服务器、数据库、数据表
 *
 * 使用举例：
 * 实例化对象 $router = Router::getInstance();
 * 返回格式的号码 $return = $router->routerServer('88888888');
 */

class Router {
	private static $_instance = NULL;

	public function __construct() {
//		include_once INCLUDE_PATH . 'config/router.config.php';
//		$this->router_config = $router_list_config;
	}

	static public function getInstance() {
		if (is_null(self::$_instance) || !isset(self::$_instance)) {
			self::$_instance = new Router();
		}
		return self::$_instance;
	}
	//联系人 Redis
	public function routerServer($mobile) {
		$contactid = substr($mobile, -1);
		if(!isset($this->router_config['redis_contacts'][$contactid])) {
			return false;
		}
		$redis = $this->router_config['redis_contacts'][$contactid];

		return $redis;
	}
	//联系人数据库
	public function routerDatabase($mobile, $pre = '') {
		return $pre . substr($mobile, -2, 1);
	}
	//联系人表
	public function routerTable($mobile, $pre = '') {
		return $pre . substr($mobile, -5, 2);
	}
	//Opensips 服务器
	public function routerOpensips($userid) {
		$groupid = $this->routerGroup($userid);
		if(!isset($this->router_config['opensips_server'][$groupid])) {
			return false;
		}
		$opensips = $this->router_config['opensips_server'][$groupid];

		return $opensips;
	}
	//集群 Redis
	public function routerRedis($userid, $type = 'token') {
		$groupid = $this->routerGroup($userid);
		if($type == 'token') {
			if(!isset($this->router_config['redis_token'][$groupid])) {
				return false;
			}
			$redis = $this->router_config['redis_token'][$groupid];
		} else {
			if(!isset($this->router_config['redis_register'][$groupid])) {
				return false;
			}
			$redis = $this->router_config['redis_register'][$groupid];
		}

		return $redis;
	}
	//集群 MsgServer
	public function routerMsgServer($userid) {
		$groupid = $this->routerGroup($userid);
		if(!isset($this->router_config['message_server'][$groupid])) {
			return false;
		}
		$message_server = $this->router_config['message_server'][$groupid];

		return $message_server;
	}


	//集群路由列表
	public function routerGroup($userid) {
		if(strlen($userid) >= 10) {
			$usercode = substr($userid, 0, 3);
		} else {
			$usercode = '699';
		}
		if(!isset($this->router_config['group_list'][$usercode])) {
			return false;
		}
		$groupid = $this->router_config['group_list'][$usercode];

		return $groupid;
	}



	//集群 MySQL
	public function routerMySQL($userid) {
		$groupid = $this->routerGroup($userid);
		if(!isset($this->router_config['mysql_list'][$groupid])) {
			return false;
		}
		$mysql = $this->router_config['mysql_list'][$groupid];

		return $mysql;
	}
	//FreeSwitch 服务器
	public function routerFreeServer() {
		// 随机取freeswitch服务器
		$serveridss = $this->router_config['freeswitch_server'][0];
		$rand = rand(0,count($serveridss)-1);//随机数
		if(!isset($this->router_config['freeswitch_server'][0][$rand])) {
			return false;
		}
		$free = $this->router_config['freeswitch_server'][0][$rand];

		return $free;
	}
}
?>