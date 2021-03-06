<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/3/6
 * Time: 18:01
 */
class voip{

	public $main_db;
//	public $im_db;
//	public $create_date = '';
//	public $expired_date = '';

	function __construct(){
		$this->_connect_maindb();

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
	 * @param $username
	 * @param $imei
	 * @return mixed
	 *
	 */
	function delete_data($table,$where){
		$this->main_db->where($where);
		return $this->main_db->delete($table);
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

    public function delete_im_user($user){

        if (!empty($user)) {
            $this->im_db->where('uid', $user);
            $query = $this->im_db->delete('users');
        }
        return $query;
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