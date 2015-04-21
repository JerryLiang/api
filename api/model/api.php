<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class api_model {

    public $main_db;
    public $create_date = '';
    public $expired_date = '';

    public function __construct() {
        $this->_connect_maindb();
    }

    public function get_upgrate() {
        $reval = array();
        if (defined('CLIENT_PLATFORM') && defined('CLIENT_VERSION')) {
            $platform = (strtolower(CLIENT_PLATFORM) == 'android') ? 'android' : 'iphone';
            $version = CLIENT_VERSION;
        }
        $platform = !empty($platform) ? $platform : 'android';
        $version = !empty($version) ? $version : '1.0.0';
        if (strtolower($platform) == 'iphone') {
            $sql = "select version,release_log as content,download_url as downloadurl,status as state,filesize as length from T_versions_info where   platform='" . $platform . "'  and version>'" . $version . "' order by last_modified desc limit 1";
        } elseif (strtolower($platform) == 'android') {
            $sql = "select version,release_log as content,download_url as downloadurl,status as state,filesize as length from T_versions_info where   platform='" . $platform . "'  and version>'" . $version . "'  order by last_modified desc limit 1";
        }
        $query = $this->main_db->query($sql);
        if ($query->num_rows() > 0) {
            $reval = $query->row_array();
        }
        return $reval;
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
