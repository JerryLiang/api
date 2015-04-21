<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class user_model
{

	public $main_db;
	public $create_date = '';
	public $expired_date = '';

	public function __construct()
	{
		/* if (defined('REDIS_CACHE_SERVER')) {
		  $this->_datacache = new RedisInit();
		  $this->_enable_cache = true;
		  } else {
		  die('undefined DATACACHE_STORE_PATH, please define in file ./config/conf.php');
		  } */
		$this->_connect_maindb();
	}

	public function get_userinfo($userid)
	{
		$reVal = false;
		if (!empty($userid)) {
			$this->main_db->where('id', $userid);
			$query = $this->main_db->get('T_user_info');
			if ($query && $query->num_rows() > 0) {
				$reVal = $query->row_array();
			}
		}
		return $reVal;
	}

	public function get_user_info($field, $value)
	{
		$reVal = false;
		if (!empty($field) && !empty($value)) {
			$this->main_db->where($field, $value);
			$this->main_db->order_by("id", "asc");
			$this->main_db->limit(1, 0);
			$query = $this->main_db->get('T_user_info');
			if ($query && $query->num_rows() > 0) {
				$reVal = $query->row_array();
			}
		}
		return $reVal;
	}

	public function check_user($user)
	{
		$reVal = false;
		if (!empty($user)) {
			$this->main_db->where('username', $user);
			$query = $this->main_db->get('T_user_info');
			if ($query && $query->num_rows() > 0) {
				$reVal = true;
			}
		}
		return $reVal;
	}

	public function check_record($sql, $reval = 'bool')
	{
		$reVal = false;
		if (!empty($sql)) {
			$query = $this->main_db->query($sql);
			if ($query && $query->num_rows() > 0) {
				switch ($reval) {
					case 'val':
						$reVal = $query->row()->id;
						break;
					case 'bool':
						$reVal = true;
						break;
				}
			}
			unset($query);
		}
		return $reVal;
	}

	/**
	 * @param $table
	 * @param $key
	 * @param $value
	 * @param $data
	 * @return mixed
	 * 更新用户信息同一列表
	 */
	function update_userinfo($table,$key,$value,$data){
		$this->main_db->where($key,$value);
		$this->main_db->update($table,$data);
		return $this->main_db->affected_rows();
	}

	/**
	 * @param $table
	 * @param $username
	 * @param $imei
	 * @return mixed
	 * 取消关注
	 */
	function cancel_user($table,$username,$imei){
		$this->main_db->where('username',$username);
		$this->main_db->where('imei',$imei);
		return $this->main_db->delete($table);
	}

	private function &_connect_maindb()
	{
		global $dbconfig;
		if (isset($this->main_db) && is_object($this->main_db)) {
			return $this->main_db;
		} else {
			// 连接用户数据库
			$this->main_db = DB($dbconfig['mainuser'], true);
			return $this->main_db;
		}
	}

}

?>
