<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Cache-control" content="max-age=1700" />
	<meta name="viewport" content="width=device-width" />
	<meta name="format-detection" content="telephone=no" />
	<meta name="keywords" content="ALIGULI 老人关爱 APP" />
	<meta name="description" content="aliguli" />
	<title>ALIGULI</title>
	<style type="text/css">
		* { margin: 0; padding: 0; }
		body { color: #5c5c5c; font-size: 12px; font-family: "微软雅黑","黑体","Lucida Grande",Verdana,sans-serif; background: url("../include/images/background.png") repeat-x }
		img { border: none; }
		ul, li, dl, dt, dd { list-style: none; margin: 0; padding: 0; }
		a { color: #FFFFFF; text-decoration: none; }
		a: hover { text-decoration: none; }
		/*.top { background:url(http://115.29.206.212/m.vhua.com/images/20140414bg.jpg) 	repeat-x }*/
		/*.top p { margin:0; padding:0 }*/
		.bar{height: 50px;}
		.bar img{height: 50px;width: auto;margin-right: 20px;}
		/*.top{margin-top: 50px;}*/
		.top span {margin-left:10px;font-size:30px; line-height:60px; font-weight:bold; font-family:"微软雅黑","黑体","Lucida Grande",Verdana,sans-serif; color:#000000 }
		.logo { width: 100% }
		.kuang-bian { width: 290px; padding: 0px 10px; text-align: left; margin: 0 auto;font-size: 20px; font-family:"微软雅黑","黑体","Lucida Grande",Verdana,sans-serif; color:#000000}
		.download{margin-top: 20px;}
	</style>
	<script type="text/javascript" src="../include/js/zepto.min.js"></script>
</head>
<script type="text/javascript">
	<!--
	var isMobile = {
		All: function () {
			return navigator.userAgent.match(/ipad|iphone os|android|windows mobile|windows phone|symbian|hpwos|blackberry|nokiabrowser|nokia|mqqbrowser|htc_sensation|K-Touch|AliyunOs|bingbot|Googlebot|EtaoSpider|YoudaoBot|spider|Baiduspider|360Spider/i) ? true : false;
		},
		any: function () {
			return (isMobile.All());
		}
	};
	if (!isMobile.any()) {
//		window.location.href = 'http://www.vhua.com/';
	}
	//-->
</script>
<body>
<div class="bar">
	<img src="../include/images/browser.png" alt="" style="float: right;"/>
</div>
<div class="top" align="center">
	<P>
		<img width="120" height="150" src="../include/images/logo.png">
		<span style="position:relative;top:-58px;">啊哩咕哩</span>
	</P>
	<div class="kuang-bian">专注家庭老人看护</div>
	<div class="kuang-bian">以硬件+云服务+APP方式服务于快乐家庭生活</div>
</div>
<?php
define("BASEPATH", dirname(__FILE__) . '/');
include_once BASEPATH . 'config/system.php';
include_once BASEPATH . 'config/conf.php';
include_once BASEPATH . 'config/database.php';
include_once INCLUDE_PATH . 'libraries/Auth.class.php';
include_once BASEPATH . 'model/api.php';

$input = new CI_Input();
$ca = trim($input->get_post('ca'));
$lang = trim($input->get_post('lang'));
$api = new api_model();
$lang_list = array('cn','en'); //目前支持语言
foreach($lang_list as $v) {
    $ret = stripos($lang, $v);
    if ($ret) {
        $lang = $v;
        break;
    }
}
$and_url = $api->get_upgrate($lang,$ca,'android');
$ios_url = $api->get_upgrate($lang,$ca,'iphone');
//echo $lang.','.$ca;exit;
?>
<div class="download" align="center">
	<p class="an_download">
		<a href="<?php if(!empty($and_url['downloadurl'])) echo $and_url['downloadurl'];?>">
			<img id="android" src="http://121.40.144.58/api/include/images/download_icon/android.png" width="187" height="59" />
			<img id="android_click" style="display: none;" src="http://121.40.144.58/api/include/images/download_icon/android_click.png" width="187" height="59" />
		</a>
	</p>
	<p class="ios_download">
		<a href="<?php if(!empty($ios_url['downloadurl'])) echo $ios_url['downloadurl']; ?>">
			<img id="ios" src="http://121.40.144.58/api/include/images/download_icon/iphone.png" width="187" height="59" />
			<img id="ios_click" style="display: none;" src="http://121.40.144.58/api/include/images/download_icon/iphone_click.png" width="187" height="59" />
		</a>
	</p>
</div>
</body>
<script type="text/javascript">
	var browser={
		versions:function(){
			var u = navigator.userAgent, app = navigator.appVersion;
			return {
				trident: u.indexOf('Trident') > -1,
				presto: u.indexOf('Presto') > -1,
				webKit: u.indexOf('AppleWebKit') > -1,
				gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1,
				mobile: !!u.match(/AppleWebKit.*Mobile.*/),
				ios: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/),
				android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1,
				iPhone: u.indexOf('iPhone') > -1 || u.indexOf('Mac') > -1,
				iPad: u.indexOf('iPad') > -1,
				webApp: u.indexOf('Safari') == -1,
				weiXin: u.indexOf('MicroMessenger') > -1
			};
		}(),
		language:(navigator.browserLanguage || navigator.language).toLowerCase()
	};
	if(browser.versions.ios) {
		$(".an_download").hide();
	}else if(browser.versions.android) {
		$(".ios_download").hide();
	}

	if(!browser.versions.weiXin){
		$(".bar").hide();
	}
	function show_m(){
		$("#android").show();$("#android_click").hide();
		$("#ios").show();$("#ios_click").hide();
	}
	function show_c(){
		$("#android").hide();$("#android_click").show();
		$("#ios").hide();$("#ios_click").show();
	}
</script>
</html>