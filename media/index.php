<?php

/**
 * 访问语音接口
 *
 */
define("BASEPATH", dirname(__FILE__) . '/');
include_once BASEPATH . 'config/system.php';
include_once BASEPATH . 'config/database.php';
include_once BASEPATH . 'config/conf.php';
include_once INCLUDE_PATH . 'libraries/FileDownload.class.php';

$input = new CI_Input();
$key = $input->get_post('key');
$format = trim($input->get_post('format'));
$u = $input->get_post('u');//u为1，不重定向文件地址，输出文件地址

$img_url_prefix = $url_prefixs[array_rand($url_prefixs)];
$status = $content = "";

if (!empty($key) && !empty($format)) {
	$db_media = DB($dbconfig['sedserver'], true);
	$db_media->select('url');
	$db_media->where('key', $key);
	$db_media->order_by('id desc');
	$query = $db_media->get('T_media_info');
	if ($query->num_rows() > 0) {
		$info = $query->row_array();
		if (file_exists(UPLOAD_PATH . '/' . $info['url'])) {
			$status = '0';
			$content = 'success';
			_logger(_LL_DEBUG,'index.php,file='.print_r($info,true));
            if(!empty($u)){
                $return = array(
                    'status' => $status,
                    'content' => $content,
                    'fileurl' => $img_url_prefix . $info['url'],
                );

                echo json_encode($return);exit;
            }else{
                header("Location: " . $img_url_prefix . $info['url']);
            }
//			$download = new FileDownload();
//			$ret = $download->download($img_url_prefix . $info['url'],$info['url'],true);
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
		_logger(_LL_DEBUG,'echo:'.json_encode($return));
		break;
	case 'txt' :
		$list = "status:" . $status . "content:" . $content;
		//功能机请求使用http1.0,返回body固定长度
		$c = strlen($list);
		header("Content-Length: ".$c);
		echo $list;
		break;
	default :
		$return = array(
			'status' => $status,
			'content' => $content,
		);
		echo json_encode($return);
		break;
}