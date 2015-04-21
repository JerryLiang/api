<?php

/**
 * 访问语音接口
 *
 */
define("BASEPATH", dirname(__FILE__) . '/');
include_once BASEPATH . 'config/system.php';
include_once BASEPATH . 'config/database.php';
include_once BASEPATH . 'config/conf.php';

$input = new CI_Input();
$key = $input->get_post('key');
$format = trim($input->get_post('format'));

$img_url_prefix = $url_prefixs[array_rand($url_prefixs)];
$status = $content = "";

if (!empty($key) && !empty($format)) {
	$db_media = DB($dbconfig['mainuser'], true);
	$db_media->select('url');
	$db_media->where('key', $key);
	$db_media->order_by('id desc');
	$query = $db_media->get('T_media_info');
	if ($query->num_rows() > 0) {
		$info = $query->row_array();
		if (file_exists(UPLOAD_PATH . '/' . $info['url'])) {
			$status = '0';
			$content = 'success';
			header("Location:" . $img_url_prefix . $info['url']);
		} else {
			$status = '100';
			$content = '原文件不存在';
		}
	} else {
		$status = '101';
		$content = 'url地址文件不对';
	}
	unset($query);
} else {
	$status = '102';
	$content = '参数有误';
}
switch ($format) {
	case 'json' :
		$return = array(
			'status' => $status,
			'content' => $content,
		);
		echo json_encode($return);
		break;
	case 'txt' :
		echo "status:" . $status . "content:" . $content;
		break;
	default :
		$return = array(
			'status' => $status,
			'content' => $content,
		);
		echo json_encode($return);
		break;
}
?>