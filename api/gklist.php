<?php

/*
  服务列表接口
 */

define("BASEPATH", dirname(__FILE__) . '/');
include_once BASEPATH . 'config/system.php';
include_once BASEPATH . 'config/conf.php';

$input = new CI_Input();
$format = trim($input->get_post('format'));
if (!empty($format) && ($format == 'json' || $format == 'txt')) {
    switch ($format) {
        case 'json' :
            $return = array(
                'type' => 'im',
                'ip' => '121.40.144.58',
                'port' => 6688
            );
            echo json_encode($return);
            break;
        case 'txt' :
            echo "type:im,ip:121.40.144.58,port:6688";
            break;
    }
}
?>
