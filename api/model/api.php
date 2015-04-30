<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class api_model
{

	public $main_db;
	public $create_date = '';
	public $expired_date = '';

	public function __construct()
	{
		global $dbconfig;
		$this->main_db = DB($dbconfig['mainuser'], true);
		$this->contact_db = DB($dbconfig['contacts'], true);
		$this->im_db = DB($dbconfig['imserver'], true);
	}

	public function get_upgrate($lang='cn',$ca='default',$platform='')
	{
		$reval = array();
		if (defined('CLIENT_PLATFORM') && CLIENT_PLATFORM !='' && defined('CLIENT_VERSION')) {
			$platform = (strtolower(CLIENT_PLATFORM) == 'iphone') ? 'iphone' : 'android';
			$version = CLIENT_VERSION;
		}

		$platform = !empty($platform) ? $platform : 'android';
//		$version = !empty($version) ? $version : '1.0.0';
		$lang = !empty($lang) ? $lang : 'cn';
		$ca = !empty($ca) ? $ca : 'default';
//		$where = "where platform='" . $platform . "'  and status = 1 and lang = '".$lang."' and ca = '".$ca."'";
		$where = "where platform='" . $platform . "'  and lang = '".$lang."' and ca = '".$ca."'";
//		echo $where;exit;
//		if (strtolower($platform) == 'iphone') {
			$sql = "select version,release_log as content,download_url as downloadurl,status as state,filesize as length from T_versions_info ".$where." order by last_modified desc limit 1";
//} elseif (strtolower($platform) == 'android') {
//			$sql = "select version,release_log as content,download_url as downloadurl,status as state,filesize as length from T_versions_info where   platform='" . $platform . "'  and version>'" . $version . "' order by last_modified desc limit 1";
//		}
		$query = $this->main_db->query($sql);
		if ($query->num_rows() > 0) {
			$reval = $query->row_array();
		}
//		print_r($reval);exit;
		return $reval;
	}

	public function get_phone_info($where){
		if(!empty($where))
			$this->main_db->where($where);
		$query = $this->main_db->get('T_phone_info');
		return $query->row_array();
	}


	public function get_sms_content($where){
		if(!empty($where))
			$this->main_db->where($where);
		$query = $this->main_db->get('T_sms_content');
		return $query->row_array();
	}

	public function get_userinfo($username){
		$this->main_db->where('username',$username);
		$query = $this->main_db->get('T_user_info');
		return $query->row_array();
	}

	public function get_num($table,$where){
		$this->contact_db->where($where);
		$query = $this->contact_db->get($table);
		return $query->num_rows();
	}

	function inserted($table,$data){
		 return $this->contact_db->insert($table,$data);
//		return $this->contact_db->insert_id();
	}

    function updated_db($table,$where,$data){
        $this->main_db->where($where);
        return $this->main_db->update($table,$data);
    }

    function inserted_db($table,$data){
        return $this->main_db->insert($table,$data);
    }

	function deleted($table,$where){
		$this->contact_db->where($where);
		return $this->contact_db->delete($table);
	}

	function get_short_url($base64_url){
		$this->main_db->where('base64_url',$base64_url);
		$query = $this->main_db->get('T_short_url');
		return $query->row_array();
	}

	function insert_short_url($data){
		return $this->main_db->insert('T_short_url',$data);
	}

    function get_im_info($table,$where){
        $this->im_db->where($where);
        $query = $this->im_db->get($table);
        return $query->result_array();
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
