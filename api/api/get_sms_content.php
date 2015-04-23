<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2014/11/10
 * Time: 10:57
 */
/**
 * 获取老人机短信内容
 */

define("BASEPATH", dirname(__FILE__) . '/');
include_once BASEPATH . 'config/system.php';
include_once BASEPATH . 'config/conf.php';
include_once BASEPATH . 'config/database.php';
include_once INCLUDE_PATH . 'libraries/Auth.class.php';

define('USER_PATH', realpath(BASEPATH . '../') . '/user/');
include_once BASEPATH . 'model/api.php';

$input = new CI_Input();
//$imei = $input->get_post('imei');
$mobile = $input->get_post('mobile');
$username = $input->get_post('user');
$country = $input->get_post('country');
$ca = $input->get_post('ca');
$format = $input->get_post('format');
$lang = CLIENT_LANGUAGE;
$lang = !empty($lang) ? $lang : $input->get_post('lang');
$api = new api_model();

//$iphone_info = $api->get_phone_info(array('imei' => $imei));

if(!empty($mobile)){
	$upinfo = $api->get_phone_info('mobile = '.$mobile);
}
$downloadurl = BASE_URL.'api/get_download_url.php?lang='.$lang.'&ca='.$ca;
//	$sms_link = httpfetch('http://www.rdcnzz.com/v1/data/link_conv/rd_dispatcher.php?orig_link=' . urlencode($downloadurl));
//	$sms_link = 'http://api.uwhom.cn/api/get_download_url.php';
$base64_url = base64_encode($downloadurl);
$result = $api->get_short_url($base64_url);
print_r($result);exit;
if(!empty($result)){
	$sms_link = $result['short_url'];
}
else{
	$t= time()-86400;
	$header =array('Referer: http://dwz.aidmin.cn/','User-Agent:Mozilla/5.0 (Windows NT 6.3; WOW64; rv:35.0) Gecko/20100101 Firefox/35.0','Cookie:Hm_lvt_fd97a926d52ef868e2d6a33de0a25470='.$t.'; PHPSESSID=l0ko5a7vpd11u7upmf24snqfa4; Hm_lpvt_fd97a926d52ef868e2d6a33de0a25470='.time());
	$ret = httpfetch('http://dwz.aidmin.cn/api.php?url='.base64_encode($downloadurl).'&site=t','',$header);
	$ret = json_decode($ret,true);
//		print_r($ret);exit;
	if($ret['result'] == 'ok'){
		$data = array('long_url'=>$downloadurl,'short_url'=>$ret['data']['short_url'],'base64_url'=>$base64_url,'type'=>'sina','created'=>date("Y-m-d H:i:s"));
		$result = $api->insert_short_url($data);
		$sms_link = $ret['data']['short_url'];
	}
	else{
		$sms_link = $downloadurl;
	}
}
//	$sms_link = 'http://t.cn/RZFax6e';//http://api.uwhom.cn/api/get_download_url.php的新浪短地址
$userid = !empty($upinfo['id']) ? $upinfo['id'] : '';
$pass = !empty($upinfo['pass']) ? $upinfo['pass'] : '';

if ($format == 'txt') {
	$list = 'status:0,ca:' . $ca . ',lang:' . $lang . ',content:' . output(_display_phone_error('1001',$lang),$sms_link,$mobile);
	$c = strlen($list);
	header("Content-Length:" . $c);
	echo $list;
	exit;
} elseif ($format == 'json') {
	$ret = array('status' => 0, 'ca' => $ca, 'lang' => $lang, 'content' =>  output(_display_error('1001'),$sms_link,$mobile));
    $list = json_encode($ret);
	echo $list;
	exit;
}else{
	echo '102';exit;
}

//临时拼接注册必要参数upass,mac,$pwd,$udid
//$pwd != md5($udid . $mac . $username . $upass . "#1QWE")

$udid = 'temp_udid';
$mac = 'temp_mac';
$upass = '123456';
$pwd = md5($udid . $mac . $username . $upass . "#1QWE");

//$auth = Auth::getInstance($dbconfig['mainuser']);
//$upinfo = $api->get_upgrate($lang,$ca);
//$downloadurl = $upinfo['downloadurl'];

$para = "imei=" . $imei . "&user=" . $username . "&udid=" . $udid . "&mac=" . $mac . "&upass=" . $upass . "&pwd=" . $pwd;
$url = "http://api.uwhom.cn/user/register.php?" . $para;
$url = urlencode($url);
//echo $url;exit;
$return = httpfetch('http://www.rdcnzz.com/v1/data/link_conv/rd_dispatcher.php?orig_link=' . $url);
$sms_link = $return;
echo $sms_link;

//$short = bdUrlAPI(1,$url);
//$where = '';
//$ca = !empty($ca) ? $ca : 'default';
//$lang = !empty($lang) ? $lang : 'cn';
//$where .= "ca = '".$ca."' and lang='".$lang."'";
//$ret = $api->get_sms_content($where);
//$content = $ret['content'];
//$content .='快速注册地址：'.$sms_link;
//$reVal = array('code'=>200,'ca'=>$ret['ca'],'lang'=>$ret['lang'],'content'=>$content);
//echo json_encode($reVal);exit;
//echo "注册成功！/n 帐号：".$username."/n 密码：".$upass."/n 建议您尽快更换密码。";
//echo 'status:0,ca:'.$reVal['ca'].',lang:'.$reVal['lang'].',content:'.$reVal['content'] ;exit;
