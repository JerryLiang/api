<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2014/12/15
 * Time: 14:27
 */
define("BASEPATH", dirname(__FILE__) . '/');
include_once BASEPATH . 'config/system.php';
include_once BASEPATH . 'config/conf.php';
include_once BASEPATH . 'config/aixintui_config.php';
include_once BASEPATH . 'config/database.php';
include_once INCLUDE_PATH . 'libraries/Auth.class.php';
include_once BASEPATH . 'model/im.php';

if(CLIENT_PLATFORM == 'iphone'){
	$app_config = $ios_aixintui;
//	$jsono = array("appkey"=>$app_config['appkey'],"token"=>'cafeb34c32c39bbe55b070aa45a95557534f79cb66ba20cc4e8dd87d3c36c748');
//	$skey = $app_config['secretkey'];
//	$ios_str = sign($jsono,$skey);
//	regist_token($ios_str,$app_config);
}
else $app_config = $android_aixintui;

//print_r($app_config);exit;
header("Content-Type:text/html;charset=utf-8");
//发送广播
function sendBroadcast($str,$app_config){
	$output = "";
	try{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $app_config['url']);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $str);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = curl_exec($ch);
		if(!$output){
			$httpCode = curl_getinfo($ch,CURLINFO_HTTP_CODE);
			$output = '{"desc":"发送失败,httpcode='.$httpCode.'!","msgid":-1,"result":-1}';
		}
		curl_close($ch);
	}catch(Exception $e){
		$output = '{"desc":"exception='.$e->getMessage().'","msgid":-1,"result":-1}';
	}
	_logger(_LL_DEBUG,'Broadcast:'.print_r($output,true));
	return $output;
}
//生成签名
function sign($json,$secretkey) {
	//按字典排序
	ksort($json);

	$jsonstring = json_encode($json,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);

	$sign = md5($jsonstring.$secretkey);
	//把签名放进去
	$json["sign"] = $sign;
	$jsonstring = json_encode($json,JSON_UNESCAPED_SLASHES);
	return $jsonstring;
}

//ios注册token

function regist_token($str,$app_config){
	$output = "";
	try{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $app_config['tokenurl']);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $str);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output = curl_exec($ch);
		if(!$output){
			$httpCode = curl_getinfo($ch,CURLINFO_HTTP_CODE);
			$output = '{"desc":"发送失败,httpcode='.$httpCode.'!","msgid":-1,"result":-1}';
		}
		curl_close($ch);
	}catch(Exception $e){
		$output = '{"desc":"exception='.$e->getMessage().'","msgid":-1,"result":-1}';
	}
	_logger(_LL_DEBUG,'token-debug:'.print_r($output,true));
	return $output;
}

//For example

//$jsono = array("appkey"=>$app_config['appkey'],"message"=>"testsign","period"=>86400,"is_notif"=>1,"token"=>'806781147000912530',"title"=>"test","sound"=>true,
//	"vibrate"=>false,"unremovable"=>false,"click_action"=>"open_app","open_app"=>true,"extra"=>"extrainfo");
if(!empty($type)){
    $jsono = array("appkey"=>$app_config['appkey'],"message"=>"您收到 一条语音消息","period"=>86400,"is_notif"=>1,"sound"=>true,
        "vibrate"=>false,"qps"=>10000,"click_action"=>"open_app","open_app"=>true);

}else{
    $jsono = array("appkey"=>$app_config['appkey'],"message"=>"您收到 一条语音消息");
}


$skey = $app_config['secretkey'];

$str = sign($jsono,$skey);
echo sendBroadcast($str,$app_config);