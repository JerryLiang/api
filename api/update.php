<?php

/*
  更新升级接口
 */

define("BASEPATH", dirname(__FILE__) . '/');
include_once BASEPATH . 'config/system.php';
include_once BASEPATH . 'config/conf.php';
include_once BASEPATH . 'config/database.php';
include_once INCLUDE_PATH . 'libraries/Auth.class.php';
include_once BASEPATH . 'model/api.php';

$input = new CI_Input();
$lang = CLIENT_LANGUAGE;
$lang = !empty($lang) ? $lang : $input->get_post('lang');
$ca = $input->get_post('ca');

$auth = Auth::getInstance($dbconfig['mainuser']);
$reVal = array('content' => '', 'status' => 103);
//if (!$auth->verify()) {
//	$reVal['content'] = _display_error('101');
//	$reVal['status'] = 101;
//} else {
	$version = CLIENT_VERSION;
	$ca = !empty($ca) ? $ca : 'default';
	$lang = !empty($lang) ? $lang : 'cn';

	$api = new api_model();
	$upinfo = $api->get_upgrate($lang,$ca,'');
	_logger(_LL_DEBUG, "line:".__FILE__.__LINE__."\n useragent = " .$_SERVER['HTTP_USER_AGENT']. "\n platform = ".CLIENT_PLATFORM."\n   lang =".$lang);
	if (!empty($upinfo) && is_array($upinfo)) {
		$reVal['status'] = 0;
		$reVal['upgrate'] = $upinfo;
	} else {
		$reVal['status'] = 154;
		$reVal['content'] = _display_error('154') . "(" . $version . ")";
	}
	unset($upinfo);
//}
echo json_encode($reVal);
?>
