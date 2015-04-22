<?php

/**
 * 多媒体上传
 * 
 */
define("BASEPATH", dirname(__FILE__) . '/');
include_once BASEPATH . 'config/system.php';
include_once BASEPATH . 'config/conf.php';
include_once BASEPATH . 'config/database.php';
include_once INCLUDE_PATH . 'helpers/cloudfiles_helper.php';
include_once INCLUDE_PATH . 'helpers/rand.php';

$input = new CI_Input();
$username = $input->get_post('username');
$filetype = trim($input->get_post('mediatype'));
$format = trim($input->get_post('format'));

$status = $content = $url = $media = "";
if (!empty($username) && !empty($filetype) && !empty($_FILES['attachment']['name'])) {
    $type_array = array('txt', 'audio', 'image');
    if (in_array(strtolower($filetype), $type_array)) {
        //上传文件
        _logger(_LL_DEBUG, "\n file=" . print_r($_FILES['attachment'], true));
        $data = uploadFile($_FILES['attachment'], '', 'Y/m/d');
        // 删除临时文件
        deleteFile($_FILES['attachment']['tmp_name']);
        //保存到数据库
        $randChar = rand_char($username);
        _logger(_LL_DEBUG, "randChar=" . print_r($randChar, true));
        $db_media = DB($dbconfig['mainuser'], true);
        $val = array(
            'username' => $username,
            'key' => $randChar,
            'url' => $data['path'],
            'type' => strtolower($filetype)
        );
        if ($db_media->insert("T_media_info", $val) && $db_media->affected_rows() > 0) {
            $status = 0;
            $content = "上传成功";
            $url = BASE_URL . '?key=' . $randChar;
        } else {
            $status = 100;
            $content = "上传失败";
        }
//		_logger(_LL_DEBUG, "\n file=" . print_r($content, true));
    } else {
        $status = 101;
        $content = "上传类型有误";
    }
} else {
    $status = 102;
    $content = "参数有误";
}
switch ($format) {
    case 'json' :
        $return = array(
            'status' => $status,
            'content' => $content,
            'url' => $url,
            'media' => $filetype,
        );
//		_logger(_LL_DEBUG, "\n file=" . print_r($return, true));

		echo json_encode($return);
        break;
    case 'txt' :
		$list = "status:" . $status . ",content:" . $content . ",url:" . $url . ",media:" . $filetype;
		//功能机请求使用http1.0,返回body固定长度
		$c = strlen($list)+3;
		_logger(_LL_DEBUG, "\n uploadfile=" . print_r($list, true).',len:'.$c);
		header("Content-Length: ".$c);
        echo $list;
        break;
}