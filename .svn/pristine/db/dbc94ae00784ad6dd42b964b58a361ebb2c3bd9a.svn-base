<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2014/11/18
 * Time: 15:00
 */

define("BASEPATH", dirname(__FILE__) . '/');
include_once BASEPATH . 'config/system.php';
include_once BASEPATH . 'config/conf.php';
include_once BASEPATH . 'config/database.php';
include_once INCLUDE_PATH . 'libraries/Router.class.php';


define('USER_PATH', realpath(BASEPATH . '../') . '/user/');
include_once BASEPATH . 'model/api.php';
$input = new CI_Input();
$cache = new DataCache();
//$urldata = urlencode('e+a1i+ivlTE6MTM4ODg4ODg4ODgs5rWL6K+VMToxMzg4ODg1NTU1MizmtYvor5UxOjEzMjU4NTQ4NjM1LOa1i+ivlTI6MTMyNDg1ODc0MjMs5rWL6K+VMzoxMzI1NDc4NTIxNCzmtYvor5U0OjEzMjQ1MjU0NzE4LOa1i+ivlTU6MTI1NDcxMjM2OTgs5rWL6K+VNjoxMjU4NzQ1MjM2OSzmtYvor5U3OjE1NDc1MjM4MjI1LOivleS4gOS4i+iDveWQpua3u+WKoDoxMDA4NjEwMDg2fQ==');
//echo 'http://api.uwhom.cn/api/contacts.php?user=008613249449911&contacts='.$urldata;exit;
//$ret = array('name'=>'1344333111','name1'=>'33333333');
//echo json_encode($ret);exit;

$contacts = $input->get_post('contacts');
//echo $contacts;exit;
$username = $input->get_post('user');
//$lang = $input->get_post('lang');
$api = new api_model();
$route = new Router();
_logger(_LL_DEBUG, "\n username = " . $username . ',contacts:' . $contacts);

//解码参数
$contacts = base64_decode($contacts);
print_r($contacts);exit;

$contacts = json_decode($contacts,true);

//检验参数
if (empty($contacts) || !is_array($contacts)) {
	$data['errno'] = '102';
	$data['content'] = 'no contacts';
	_logger(_LL_ERROR, "contacts is empty. ".$username);
	echo json_encode($data);
	exit;
}
//获得用户信息
$userinfo = $api->get_userinfo($username);
if (count($userinfo) > 0) {
	$country = $userinfo['country'];
} else {
	$data['errno'] = '404';
	$data['content'] = '该用户不存在';
	echo json_encode($data);
	exit;
}
//判断联系人是否重复上传
ksort($contacts);
$sign = md5(json_encode($contacts));
$_cache = new DataCache('/relationship_tmp/');
$signinfo = $cache->get($username . '_' . $sign);
//var_dump($signinfo); exit;
if (1 && is_array($signinfo)) {
	$data['content'] = '通讯录已经上传';
}
else{
	//将通讯录上传记录写入缓存
	$cache->set($username .'_'. $sign, $contacts, false, strtotime('+14 days'));
	$table = $route->routerTable($username,'contacts_');
//	echo $table;exit;
	$signinfo = $cache->get($username . '_' . $sign);
	$ret = $api->get_num($table,array('username'=>$username));
	if($ret > 0){
		$api->deleted($table,array('username'=>$username));

	}
foreach($contacts as $n => $v){
	//$n是联系人名称，$v是电话号码
	$api->inserted($table,array('username'=>$username,'contactname'=>$n,'contacts'=>$v));
//	echo $id;exit;
}
	$data['content'] = '通讯录上传完毕';
}
	$data['status'] = 0;
//	$data['contacts'] = $signinfo;

	echo json_encode($data);exit;