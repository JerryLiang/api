<?php

/*
  帮助接口
 */

define("BASEPATH", dirname(__FILE__) . '/');
include_once BASEPATH . 'config/system.php';
include_once BASEPATH . 'config/conf.php';
include_once BASEPATH . 'config/database.php';
include_once INCLUDE_PATH . 'libraries/Auth.class.php';

$auth = Auth::getInstance($dbconfig['mainuser']);
$reVal = array('content' => '', 'status' => 103);
if (!$auth->verify()) {
    $reVal['content'] = _display_error('101');
    $reVal['status'] = 101;
} else {
    $reVal['status'] = 0;
    $list = array(
        array('question' => '问题列表1', 'answer' => '回答列表1'),
        array('question' => '问题列表2', 'answer' => '回答列表2'),
    );
    $reVal['list'] = $list;
}
echo json_encode($reVal);
?>
