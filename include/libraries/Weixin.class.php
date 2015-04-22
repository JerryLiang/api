<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/2/27
 * Time: 11:27
 */

include_once INCLUDE_PATH . 'libraries/Redis.class.php';

define('TOKEN','ALiGuLi20150227');
define('APPID','wxbe93e413df6f5d6c');
define('APPSECRET','b4015428d5fa8e4a32446302e403ff6c');

class weixin_api{

	var $signature,$timestamp,$nonce,$echostr;
	var $access_token,$_db_config,$table;
	public $_main_user_db = null;
	private static $_instance = NULL;
	private $weixin_token = NULL;

	public function __construct(&$db_config){

		if (defined('REDIS_CACHE_SERVER')) {
			$this->_redis = new RedisInit();
			$this->_enable_cache = true;
		}
		$this->_db_config = $db_config;
		if (!is_object($this->_main_user_db)) {
			$this->_main_user_db = DB($this->_db_config, true);
		}

		$this->table = 'T_thirdpart_status';

		$this->weixin_token = $this->_redis->redis()->get('weixin_token');
		if(!$this->weixin_token){
			$result = $this->get_access_token();
			$v = json_decode($result,true);
			$this->_redis->redis()->set('weixin_token',$v['access_token'],$v['expires_in']);
			$data = array('type'=>'weixin','access_token'=>$v['access_token'],'expires'=>$v['expires_in'],'created'=>date("Y-m-d H:i:s"));
			$query = $this->_main_user_db->insert($this->table,$data);
			$this->weixin_token = $v['access_token'];
		}
//		echo $this->weixin_token;exit;
	}

	static public function getInstance(&$db_config)
	{
		if (is_null(self::$_instance) || !isset(self::$_instance)) {
			self::$_instance = new weixin_api($db_config);
		}
		return self::$_instance;
	}

	function valide($signature='',$timestamp='',$nonce='',$echostr=''){
		$this->signature = $signature;
		$this->timestamp = $timestamp;
		$this->nonce = $nonce;
		$this->echostr = $echostr;
		if($this->check_signature()){
			echo $this->echostr;exit;
		}
	}

	function check_signature(){

		if (!defined("TOKEN")) {
			throw new Exception('TOKEN is not defined!');
		}
		$token = TOKEN;
		$tmpArr = array($token, $this->timestamp, $this->nonce);
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );

		if( $tmpStr == $this->signature ){
			return true;
		}else{
			return false;
		}
	}

	function get_access_token(){
		$url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.APPID.'&secret='.APPSECRET;
		$return = httpfetch($url);
//		print_r($return);exit;
		return $return;
	}

	/**
	 * HTTP内容请求辅助函数
	 * string $url 请求的url地址
	 * array $data POST数据
	 * array $headers 发送的http头信息
	 * array $options curl的参数
	 */
	function httpfetch($url, $data = null, $headers = array(), $options = array()) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		if (!empty($options)) {
			curl_setopt_array($ch, $options);
		}

		if (!empty($headers))
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		if (!empty($data)) {
			curl_setopt($ch, CURLOPT_POST, 1);

			if (is_array($data)) {
				$postdata = '';
				foreach ($data as $key => $val) {
					//$postdata .= $key . '=' . urlencode($val) . '&';
					$postdata .= $key . '=' . $val . '&';
				}
				$data = trim($postdata, '&');
			}

			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// 设置连接超时时间 2 秒
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		// 设置超时时间 10 秒
		curl_setopt($ch, CURLOPT_TIMEOUT, 20);
		$out = curl_exec($ch);
		if ($out === false) {
			_logger(_LL_ERROR, 'Connect failed: ' . $url);
		} else {
			$out = trim($out);
		}
		curl_close($ch);
		// _logger(_LL_DEBUG, "content: $url, RESULT: $out");
		// $out = json_decode($out, true);
		return $out;
	}


}