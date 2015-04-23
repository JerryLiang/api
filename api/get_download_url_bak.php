<?php
/**
 * 获取智能端下载地址
 */
define("BASEPATH", dirname(__FILE__) . '/');
include_once BASEPATH . 'config/system.php';
include_once BASEPATH . 'config/conf.php';
include_once BASEPATH . 'config/database.php';
include_once INCLUDE_PATH . 'libraries/Auth.class.php';

define('USER_PATH', realpath(BASEPATH . '../') . '/user/');
include_once BASEPATH . 'model/api.php';

$input = new CI_Input();
$ca = $input->get_post('ca');
$lang = $input->get_post('lang');

$api = new api_model();
?>
<script type="text/javascript">
	var url = navigator.userAgent;
	var browser = {
		versions: function () {
			var u = navigator.userAgent,
				app = navigator.appVersion;
			var ua = u.toLowerCase();
			return {
				trident: u.indexOf('Trident') > -1,
				presto: u.indexOf('Presto') > -1,
				webKit: u.indexOf('AppleWebKit') > -1,
				gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1,
				mobile: !!u.match(/AppleWebKit.*Mobile.*/) || !!u.match(/AppleWebKit/),
				ios: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/),
				android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1,
				iPhone: u.indexOf('iPhone') > -1 || u.indexOf('Mac') > -1,
				iPad: u.indexOf('iPad') > -1,
				webApp: u.indexOf('Safari') == -1,
				coolpad: u.indexOf('Coolpad') > -1,
				weixin: ua.match(/MicroMessenger/i) == "micromessenger" || window.WeixinJSBridge != undefined
			};
		}(),
		language: (navigator.browserLanguage || navigator.language).toLowerCase()
	};
	//	for(var par in browser.versions){
	//		alert(browser.versions.iPhone);
	//	}
	if (browser.versions.iPhone) {
		<?php
		$platform = 'iphone';
		$upinfo = $api->get_upgrate($lang, $ca,$platform);
		$downloadurl = $upinfo['downloadurl'];
		?>
		location.href = '<?php echo $downloadurl; ?>';
//		$("#call_copy").show();
	}
	else {
		<?php
		$platform = 'android';
		$upinfo = $api->get_upgrate($lang, $ca,$platform);
		$downloadurl = $upinfo['downloadurl'];
		?>
		location.href = '<?php echo $downloadurl; ?>';
	}

</script>
