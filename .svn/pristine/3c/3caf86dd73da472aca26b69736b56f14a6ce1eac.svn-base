<?php

class RedisInit {

    private $redis; //redis对象

    /**
     * 初始化Redis 
     * $server = 'tcp://root:uhuacall2013@222.88.194.164:6379'
     * @param array $config 
     */
    public function __construct($server = '') {
        if (empty($server)) {
            if (defined('REDIS_CACHE_SERVER')) {
                $server = REDIS_CACHE_SERVER;
            } else {
                _logger(_LL_ERROR, "please check REDIS_CACHE_SERVER settings.\n");
            }
        }
        $params = @parse_url($server);
        $host = $params['host'];
        $port = strval($params['port']);
        $this->redis = new Redis();
        $this->redis->pconnect($host, $port);
        if (!empty($params['pass']) && !$this->redis->auth($params['pass'])) {
            _logger(_LL_ERROR, $params['pass']."Redis authenticate failed.\n");
        }
    }

    /**
     * 设置值 
     * @param string $key KEY名称 
     * @param string|array $value 获取得到的数据 
     * @param int $timeOut 时间 
     */
    public function set($key, $value, $timeOut = 0) {
        $value = json_encode($value);
        if ($timeOut > 0)
            $retRes = $this->redis->set($key, $value, $timeOut);
        else 
            $retRes = $this->redis->set($key, $value);
        return $retRes;
    }

    /**
     * 通过KEY获取数据 
     * @param string $key KEY名称 
     */
    public function get($key) {
        $result = $this->redis->get($key);
        return json_decode($result, TRUE);
    }

    /**
     * 删除一条数据 
     * @param string $key KEY名称 
     */
    public function delete($key) {
        return $this->redis->delete($key);
    }

    /**
     * 清空数据 
     */
    public function flushAll() {
        return $this->redis->flushAll();
    }

    /**
     * 数据入队列 
     * @param string $key KEY名称 
     * @param string|array $value 获取得到的数据 
     * @param bool $right 是否从右边开始入 
     */
    public function push($key, $value, $right = true) {
        $value = json_encode($value);
        return $right ? $this->redis->rPush($key, $value) : $this->redis->lPush($key, $value);
    }

    /**
     * 数据出队列 
     * @param string $key KEY名称 
     * @param bool $left 是否从左边开始出数据 
     */
    public function pop($key, $left = true) {
        $val = $left ? $this->redis->lPop($key) : $this->redis->rPop($key);
        return json_decode($val);
    }

    /**
     * 数据自增 
     * @param string $key KEY名称 
     */
    public function increment($key) {
        return $this->redis->incr($key);
    }

    /**
     * 数据自减 
     * @param string $key KEY名称 
     */
    public function decrement($key) {
        return $this->redis->decr($key);
    }

    /**
     * key是否存在，存在返回ture 
     * @param string $key KEY名称 
     */
    public function exists($key) {
        return $this->redis->exists($key);
    }

    ########################################
    ##          hash数据结构操作方法       ##
    ########################################
    /**
     * hash数据集set函数
     * @param type $key
     * @param type $skey
     * @param type $value
     */
    public function hSet($key, $hashKey, $value) {
        $value = json_encode($value);
        return $this->redis->hSet($key, $hashKey, $value);
    }
    
    public function hGet($key, $hashKey) {
        $result = $this->redis->hGet($key, $hashKey);
        return json_decode($result, TRUE);
    }
    
    public function hSetNx($key, $hashKey, $value) {
        $value = json_encode($value);
        return $this->redis->hSetNx($key, $hashKey, $value);
    }
    
    public function hLen($key) {
        return $this->redis->hLen($key);
    }
    
    public function hDel($key, $hashKey) {
        return $this->redis->hDel($key, $hashKey);
    }

    public function hKeys($key) {
        return $this->redis->hKeys($key);
    }
    
    public function hVals($key) {
        $result = $this->redis->hVals($key);
        if (!empty($result) && is_array($result)) {
            foreach ($result as &$val) {
                $val = json_decode($val, TRUE);
            }
        }
        return $result;
    }
    
    public function hGetAll($key) {
        $result = $this->redis->hGetAll($key);
        if (!empty($result) && is_array($result)) {
            foreach ($result as &$val) {
                $val = json_decode($val, TRUE);
            }
        }
        return $result;
    }
    
    public function hExists($key, $hashKey) {
        return $this->redis->hExists($key, $hashKey);
    }
    
    public function hIncrBy($key, $hashKey, $value) {
        return $this->redis->hIncrBy($key, $hashKey, $value);
    }
    
    public function hIncrByFloat($key, $hashKey, $value) {
        return $this->redis->hIncrByFloat($key, $hashKey, $value);
    }
    
    public function hMset($key, $KeyValue = array()) {
        if (!empty($KeyValue) && is_array($KeyValue)) {
            foreach ($KeyValue as &$val) {
                $val = json_encode($val);
            }
        }
        return $this->redis->hMset($key, $KeyValue);
    }
    
    public function hMget($key, $hashKeys = array()) {
        $result = $this->redis->hMGet($key, $hashKeys);
        if (!empty($result) && is_array($result)) {
            foreach ($result as &$val) {
                $val = json_decode($val, TRUE);
            }
        }
        return $result;
    }
    
    /**
     * 返回redis对象 
     * redis有非常多的操作方法，我们只封装了一部分 
     * 拿着这个对象就可以直接调用redis自身方法 
     */
    public function redis() {
        return $this->redis;
    }

}
?>
