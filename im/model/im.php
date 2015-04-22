<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class im_model {

    public $main_db;
    public $create_date = '';
    public $expired_date = '';

    public function __construct() {
        $this->_connect_maindb();
    }

	public function get_items($table){
		$query = $this->main_db->get($table);
		if ($query && $query->num_rows() > 0) {
			$reVal = $query->result_array();
		}
		return $reVal;
	}

    public function get_userinfo($table, $field, $values) {
        $reVal = false;
        if (!empty($field) && !empty($values) && !empty($table)) {
            $this->main_db->where($field, $values);
            $query = $this->main_db->get($table);
            if ($query && $query->num_rows() > 0) {
                $reVal = $query->row_array();
            }
            unset($query);
        }
        return $reVal;
    }

	public function get_usertoken($username){
//		$this->main_db->select('token');
		$this->main_db->where('username',$username);
		$query = $this->main_db->get('T_ios_token');
		return $query->row_array();
	}

    private function &_connect_maindb() {
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
