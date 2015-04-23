<<<<<<< HEAD
<?php

/**
 * 接口授权类
 */
// Redis缓存类
include_once INCLUDE_PATH . 'libraries/Redis.class.php';

class Auth
{

	public $_auth_userid = '';
	public $_auth_token = '';
	public $_main_user_db = null;
	private $_public_token = "mobilephone2014";
	private $_enable_cache = false;
	private $_db_config = NULL;
	private static $_instance = NULL;
	private $_redis;
	private $_redis_auth_prefix = 'auth:';

	public function __construct(&$db_config)
	{
		// 初始化Redis缓存
		if (defined('REDIS_CACHE_SERVER')) {
			$this->_redis = new RedisInit();
			$this->_enable_cache = true;
		}
		$this->_db_config = $db_config;
		if (!is_object($this->_main_user_db)) {
			$this->_main_user_db = DB($this->_db_config, true);
		}
		$this->_auth_userid = isset($_SERVER['HTTP_API_USERID']) ? $_SERVER['HTTP_API_USERID'] : '';
		$this->_auth_token = isset($_SERVER['HTTP_API_TOKEN']) ? $_SERVER['HTTP_API_TOKEN'] : '';
//        echo $this->_auth_userid;exit;
//		$this->_auth_userid = isset($_SERVER['HTTP_USERID']) ? $_SERVER['HTTP_USERID'] : '';
//		$this->_auth_token = isset($_SERVER['HTTP_TOKEN']) ? $_SERVER['HTTP_TOKEN'] : '';
	}

	static public function getInstance(&$db_config)
	{
		if (is_null(self::$_instance) || !isset(self::$_instance)) {
			self::$_instance = new Auth($db_config);
		}
		return self::$_instance;
	}

	public function register_login($val = array())
	{
		$reVal = false;
		if (!empty($val) && is_array($val)) {
			//写注册设备数据记录
			$user_id = $this->_register_userinfo($val);
			if ($user_id) {
				$val['id'] = $user_id;
				$reVal = $this->_tokenCache($val);
			} else {
				$reVal = "202";
			}
		}
		return $reVal;
	}

	public function u_login($user, $password)
	{
		$reVal = false;
		if (!empty($user) && !empty($password)) {
			$query = $this->_main_user_db->query("select * from T_user_info where username='" . $user . "' and userpass='" . $password . "' ");
			if ($query->num_rows() > 0) {
				$val = $query->row_array();
				if (!empty($val)) {
					$reVal = $this->_tokenCache($val);
				}
			}
			unset($query);
		}
		return $reVal;
	}

	public function u_modifpass($userid, $oldpass, $newpass)
	{
		$reVal = false;
		if (!empty($userid) && !empty($oldpass)) {
			$query = $this->_main_user_db->query("select * from T_user_info where id=" . $userid . " and userpass='" . $oldpass . "'");
//			echo "select * from T_user_info where id=" . $userid . " and userpass='" . $oldpass . "'";exit;
//			var_dump($query);exit;
			if ($query->num_rows() > 0) {
				$val = $query->row_array();
				if (!empty($val)) {
					$this->_main_user_db->query("update T_user_info set userpass='" . $newpass . "' where id=" . $userid . " and userpass='" . $oldpass . "' ");
					if ($this->_main_user_db->affected_rows() > 0) {
						$val['user_pwd'] = $newpass;
						$reVal = $this->_tokenCache($val);
					}
				}
			}
		}
		return $reVal;
	}

	public function verify($userid = '', $token = '')
	{
		$reval = false;
//		$reval = true;
		$authVal = $this->_getCache(!empty($token) ? $token : $this->_auth_token);
		if (!empty($authVal)) {
			$val = json_decode($authVal, true);
			if (is_array($val)) {
				$query = $this->_main_user_db->query("select id from T_user_info where username='" . $val["username"] . "' and userpass='" . $val["password"] . "' ");
				if ($query->num_rows() > 0 && $val["userid"] == !empty($userid) ? $userid : $this->_auth_userid) {
					$reval = true;
				}
				unset($query);
			}
		}
		if ($reval === false) {
			header("HTTP/1.1 203");
		}
		return $reval;
	}

	private function _register_userinfo($val = array())
	{
		if (!is_object($this->_main_user_db)) {
			$this->_main_user_db = DB($this->_db_config, true);
		}
		if (is_array($val)) {
			$query = $this->_main_user_db->query("select id from T_user_info where username='" . $val["username"] . "' or (ip='" . $val["ip"] . "' and TIME_TO_SEC(TIMEDIFF(now(),addtime)) < 60) ");
			if ($query->num_rows() > 0) {
				return false;
			} else {
				if ($this->_main_user_db->insert('T_user_info', $val) && $this->_main_user_db->affected_rows() > 0) {
					return $this->_main_user_db->insert_id();
				}
			}
			unset($query);
		}
		return false;
	}

	public function _setCache($key, $val, $timeout = 1)
	{
		return $this->_redis->set($this->_redis_auth_prefix . $key, $val, strtotime('+' . $timeout . ' days'));
	}

	public function _getCache($key)
	{
		return $this->_redis->get($this->_redis_auth_prefix . $key);
	}

	public function _clearCache($key)
	{
		if ($this->_enable_cache === true) {
			return $this->_redis->delete($this->_redis_auth_prefix . $key);
		}
		return false;
	}

	public function encrypt($original, $key = '')
	{
		return $this->_privateEndecrypt($original, 'encode', $key);
	}

	public function decrypt($original, $key = '')
	{
		return $this->_privateEndecrypt($original, 'decode', $key);
	}

	private function _privateEndecrypt($original, $mode, $key)
	{
		if (!empty($original)) {
			switch (strtolower($mode)) {
				case 'encode':
					$original = TEAServerEncrypt(!empty($key) ? $key : $this->_public_token, $original);
					break;
				case 'decode':
					$original = TEAServerDecrypt(!empty($key) ? $key : $this->_public_token, $original);
					break;
			}
		}
		return $original;
	}

	private function _tokenRule($val = array())
	{
		return md5(date("Y-m-d", time()) . $val["id"] . $val["udid"] . $val["userpass"]);
	}

	private function _tokenCache($val = array())
	{
		$reVal = false;
		if (is_array($val)) {
			$token = $this->_tokenRule($val);
			$mobile = isset($val["mobile"]) ? $val["mobile"] : '' ;
			$info = array('token' => $token, 'userid' => $val['id'], 'mobile' => $mobile);
			$cache_val = array(
				'userid' => $val['id'],
				'username' => $val["username"],
				'password' => $val["userpass"]
			);
			if ($this->_setCache($token, json_encode($cache_val))) {
				$reVal = $info;
//				print_r($reVal);exit;
			}
		}
		return $reVal;
	}

}

?>
=======
<?php

/**
 * 接口授权类
 */
// Redis缓存类
include_once INCLUDE_PATH . 'libraries/Redis.class.php';

class Auth
{

	public $_auth_userid = '';
	public $_auth_token = '';
	public $_main_user_db = null;
	private $_public_token = "mobilephone2014";
	private $_enable_cache = false;
	private $_db_config = NULL;
	private static $_instance = NULL;
	private $_redis;
	private $_redis_auth_prefix = 'auth:';

	public function __construct(&$db_config)
	{
		// 初始化Redis缓存
		if (defined('REDIS_CACHE_SERVER')) {
			$this->_redis = new RedisInit();
			$this->_enable_cache = true;
		}
		$this->_db_config = $db_config;
		if (!is_object($this->_main_user_db)) {
			$this->_main_user_db = DB($this->_db_config, true);
		}
		$this->_auth_userid = isset($_SERVER['HTTP_API_USERID']) ? $_SERVER['HTTP_API_USERID'] : '';
		$this->_auth_token = isset($_SERVER['HTTP_API_TOKEN']) ? $_SERVER['HTTP_API_TOKEN'] : '';
//        echo $this->_auth_userid;exit;
//		$this->_auth_userid = isset($_SERVER['HTTP_USERID']) ? $_SERVER['HTTP_USERID'] : '';
//		$this->_auth_token = isset($_SERVER['HTTP_TOKEN']) ? $_SERVER['HTTP_TOKEN'] : '';
	}

	static public function getInstance(&$db_config)
	{
		if (is_null(self::$_instance) || !isset(self::$_instance)) {
			self::$_instance = new Auth($db_config);
		}
		return self::$_instance;
	}

	public function register_login($val = array())
	{
		$reVal = false;
		if (!empty($val) && is_array($val)) {
			//写注册设备数据记录
			$user_id = $this->_register_userinfo($val);
			if ($user_id) {
				$val['id'] = $user_id;
				$reVal = $this->_tokenCache($val);
			} else {
				$reVal = "202";
			}
		}
		return $reVal;
	}

	public function u_login($user, $password)
	{
		$reVal = false;
		if (!empty($user) && !empty($password)) {
			$query = $this->_main_user_db->query("select * from T_user_info where username='" . $user . "' and userpass='" . $password . "' ");
			if ($query->num_rows() > 0) {
				$val = $query->row_array();
				if (!empty($val)) {
					$reVal = $this->_tokenCache($val);
				}
			}
			unset($query);
		}
		return $reVal;
	}

	public function u_modifpass($userid, $oldpass, $newpass)
	{
		$reVal = false;
		if (!empty($userid) && !empty($oldpass)) {
			$query = $this->_main_user_db->query("select * from T_user_info where id=" . $userid . " and userpass='" . $oldpass . "'");
//			echo "select * from T_user_info where id=" . $userid . " and userpass='" . $oldpass . "'";exit;
//			var_dump($query);exit;
			if ($query->num_rows() > 0) {
				$val = $query->row_array();
				if (!empty($val)) {
					$this->_main_user_db->query("update T_user_info set userpass='" . $newpass . "' where id=" . $userid . " and userpass='" . $oldpass . "' ");
					if ($this->_main_user_db->affected_rows() > 0) {
						$val['user_pwd'] = $newpass;
						$reVal = $this->_tokenCache($val);
					}
				}
			}
		}
		return $reVal;
	}

	public function verify($userid = '', $token = '')
	{
		$reval = false;
//		$reval = true;
		$authVal = $this->_getCache(!empty($token) ? $token : $this->_auth_token);
		if (!empty($authVal)) {
			$val = json_decode($authVal, true);
			if (is_array($val)) {
				$query = $this->_main_user_db->query("select id from T_user_info where username='" . $val["username"] . "' and userpass='" . $val["password"] . "' ");
				if ($query->num_rows() > 0 && $val["userid"] == !empty($userid) ? $userid : $this->_auth_userid) {
					$reval = true;
				}
				unset($query);
			}
		}
		if ($reval === false) {
			header("HTTP/1.1 203");
		}
		return $reval;
	}

	private function _register_userinfo($val = array())
	{
		if (!is_object($this->_main_user_db)) {
			$this->_main_user_db = DB($this->_db_config, true);
		}
		if (is_array($val)) {
			$query = $this->_main_user_db->query("select id from T_user_info where username='" . $val["username"] . "' or (ip='" . $val["ip"] . "' and TIME_TO_SEC(TIMEDIFF(now(),addtime)) < 60) ");
			if ($query->num_rows() > 0) {
				return false;
			} else {
				if ($this->_main_user_db->insert('T_user_info', $val) && $this->_main_user_db->affected_rows() > 0) {
					return $this->_main_user_db->insert_id();
				}
			}
			unset($query);
		}
		return false;
	}

	public function _setCache($key, $val, $timeout = 1)
	{
		return $this->_redis->set($this->_redis_auth_prefix . $key, $val, strtotime('+' . $timeout . ' days'));
	}

	public function _getCache($key)
	{
		return $this->_redis->get($this->_redis_auth_prefix . $key);
	}

	public function _clearCache($key)
	{
		if ($this->_enable_cache === true) {
			return $this->_redis->delete($this->_redis_auth_prefix . $key);
		}
		return false;
	}

	public function encrypt($original, $key = '')
	{
		return $this->_privateEndecrypt($original, 'encode', $key);
	}

	public function decrypt($original, $key = '')
	{
		return $this->_privateEndecrypt($original, 'decode', $key);
	}

	private function _privateEndecrypt($original, $mode, $key)
	{
		if (!empty($original)) {
			switch (strtolower($mode)) {
				case 'encode':
					$original = TEAServerEncrypt(!empty($key) ? $key : $this->_public_token, $original);
					break;
				case 'decode':
					$original = TEAServerDecrypt(!empty($key) ? $key : $this->_public_token, $original);
					break;
			}
		}
		return $original;
	}

	private function _tokenRule($val = array())
	{
		return md5(date("Y-m-d", time()) . $val["id"] . $val["udid"] . $val["userpass"]);
	}

	private function _tokenCache($val = array())
	{
		$reVal = false;
		if (is_array($val)) {
			$token = $this->_tokenRule($val);
			$mobile = isset($val["mobile"]) ? $val["mobile"] : '' ;
			$info = array('token' => $token, 'userid' => $val['id'], 'mobile' => $mobile);
			$cache_val = array(
				'userid' => $val['id'],
				'username' => $val["username"],
				'password' => $val["userpass"]
			);
			if ($this->_setCache($token, json_encode($cache_val))) {
				$reVal = $info;
//				print_r($reVal);exit;
			}
		}
		return $reVal;
	}

}

?>
>>>>>>> 63b94a7e1b4167248a21999ae09c4dde81b786e9
