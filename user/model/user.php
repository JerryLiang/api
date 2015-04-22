<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class user_model
{

	public $main_db;
	public $im_db;
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

	/**
	 * @param $userid
	 * @return bool
	 * 依据用户id得到用户信息
	 */
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

	/**
	 * @param $field
	 * @param $value
	 * @return bool
	 *
	 */
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

    public function check_im_user($user){
        $reVal = false;
        if (!empty($user)) {
            $this->im_db->where('uid', $user);
            $query = $this->im_db->get('users');
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
	function cancel_user($table,$username,$mobile){
		$this->main_db->where('username',$username);
		$this->main_db->where('mobile',$mobile);
		return $this->main_db->delete($table);
	}

	/**
	 * @param $table
	 * @param $where
	 * @param $data
	 * @return mixed
	 * 更新数据
	 */
	function update_data($table,$where,$data){
		$this->main_db->where($where);
		return $this->main_db->update($table,$data);
	}

	/**
	 * @param $table
	 * @param $data
	 * @return mixed
	 * 插入数据
	 */
	function insert_data($table,$data){
		return $this->main_db->insert($table,$data);
	}

	/**
	 * @param $table
	 * @param $where
	 * @return mixed
	 * 判断记录个数
	 */
	function get_num($table,$where){
		$this->main_db->where($where);
		$query = $this->main_db->get($table);
		return $query->num_rows();
	}

	/**
	 * @param $table
	 * @param $where
	 * @return mixed
	 * 返回记录详情
	 */
	function get_item($table,$where){
		$this->main_db->where($where);
		$query = $this->main_db->get($table);
		return $query->row_array();
	}

	/**
	 * @param $data
	 * @return mixed
	 * 插入im数据库关注列表
	 */
	function insert_imserver($data){
		return $this->im_db->insert('groups',$data);
	}

	/**
	 * @return mixed
	 * 查询所有groups表内所有记录
	 */
	function select_imserver(){
		$query = $this->im_db->get('groups');
		return $query->result_array();
	}

	/**
	 * @param $data
	 * @return mixed
	 * 取消关注删除im关注数据
	 */
	function delete_imserver($data){
		$this->im_db->where($data);
		return $this->im_db->delete('groups');
	}


	public function get_upgrate($lang,$ca)
	{
		$reval = array();
		if (defined('CLIENT_PLATFORM') && defined('CLIENT_VERSION')) {
			$platform = (strtolower(CLIENT_PLATFORM) == 'android') ? 'android' : 'iphone';
			$version = CLIENT_VERSION;
		}
		$platform = !empty($platform) ? $platform : 'android';
		$version = !empty($version) ? $version : '1.0.0';
		$lang = !empty($lang) ? $lang : 'cn';

		$where = "where platform='" . $platform . "'  and status = 1 and lang = '".$lang."' and ca = '".$ca."'";
//		if (strtolower($platform) == 'iphone') {
		$sql = "select version,release_log as content,download_url as downloadurl,status as state,filesize as length from T_versions_info ".$where." order by last_modified desc limit 1";
//		} elseif (strtolower($platform) == 'android') {
//			$sql = "select version,release_log as content,download_url as downloadurl,status as state,filesize as length from T_versions_info where   platform='" . $platform . "'  and version>'" . $version . "' order by last_modified desc limit 1";
//		}
		$query = $this->main_db->query($sql);
		if ($query->num_rows() > 0) {
			$reval = $query->row_array();
		}
		return $reval;
	}

    function get_short_url($base64_url){
        $this->main_db->where('base64_url',$base64_url);
        $query = $this->main_db->get('T_short_url');
        return $query->row_array();
    }

    function insert_short_url($data){
        return $this->main_db->insert('T_short_url',$data);
    }

	private function &_connect_maindb()
	{
		global $dbconfig;
		if (isset($this->main_db) && is_object($this->main_db)) {
 			return $this->main_db;
		} else {
			// 连接用户数据库
			$this->main_db = DB($dbconfig['mainuser'], true);
			$this->im_db =   DB($dbconfig['imserver'], true);

			return $this->main_db;

		}
	}

}

?>
