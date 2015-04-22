<?php

class DataCache {

    var $_root = '/datacache/';
    var $_prefix = '/datacache/';
    var $_memcache = null;

    public function __construct($prefix = '', $server = '') {
        if (!empty($prefix)) {
            $this->_prefix = $this->_root . $prefix;
        }

        if (!empty($server)) {
            $servers = explode(',', $server);
        } elseif (defined('DATACACHE_STORE_PATH')) {
            $servers = explode(',', DATACACHE_STORE_PATH);
        } else {
            _logger(_LL_ERROR, "please check DATACACHE_STORE_PATH settings.\n");
        }

        $this->_memcache = new Memcache();
        foreach ($servers as $server) {
            $params = @parse_url($server);
            $host = $params['host'];
            $port = strval($params['port']);
            $this->_memcache->AddServer($host, $port);
        }
    }

    public function add($key, $value, $flag = false, $expire = 0) {
        if (!is_object($this->_memcache))
            return false;
        $key = $this->_prefix . $key;
        return $this->_memcache->add($key, serialize($value), $flag, $expire);
    }

    public function replace($key, $value, $flag = false, $expire = 0) {
        $key = $this->_prefix . $key;
        return $this->_memcache->replace($key, serialize($value), $flag, $expire);
    }

    public function set($key, $value, $flag = false, $expire = 0) {
        if (!is_object($this->_memcache))
            return false;
        $key = $this->_prefix . $key;
        return $this->_memcache->set($key, serialize($value), $flag, $expire);
    }

    public function get($key) {
        if (!is_object($this->_memcache))
            return null;
        if (is_array($key)) {
            for ($i = 0; $i < count($key); $i++) {
                $key[$i] = $this->_prefix . $key[$i];
            }
        } else {
            $key = $this->_prefix . $key;
        }
        $result = $this->_memcache->get($key);
        if (is_array($result)) {
            foreach ($result as $key => $val) {
                $result [$key] = $val === false ? false : unserialize($val);
            }
        } elseif ($result !== false) {
            $result = unserialize($result);
        }
        return $result;
    }

    public function delete($key) {
        $key = $this->_prefix . $key;
        //return $this->_memcache->delete ( $key );
        return $this->_memcache->set($key, false, false, 1);
    }

}

?>