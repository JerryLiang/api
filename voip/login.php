<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/3/6
 * Time: 17:55
 */
define("BASEPATH", dirname(__FILE__) . '/');

include_once BASEPATH . 'config/conf.php';
include_once BASEPATH . 'model/voip.php';
include_once INCLUDE_PATH . 'libraries/SmsGateway.class.php';
include_once INCLUDE_PATH . 'libraries/Redis.class.php';

$input = new CI_Input();
$mobile = trim($input->get_post('mobile'));
$imei = trim($input->get_post('imei'));
$code = trim($input->get_post('code'));
$country = trim($input->get_post('country'));
$agent = trim($input->get_post('agent'));
$model = trim($input->get_post('model'));
if (CLIENT_PLATFORM == 'iphone' || CLIENT_PLATFORM == 'android') {
    $format = 'json';
} else {

    $format = 'txt';
}
$_table = 'T_phone_info';
$_table_list = 'T_phone_list';

$redis = new RedisInit();
$verify_code = $redis->redis()->hGet('VerifyCode', $mobile);
if (trim($code) != $verify_code) {
    $status = '123';
} else {
    $voip = new voip();
    $is_imei = $voip->get_item($_table_list, array('imei' => $imei));
    //imei在库中
    if (!empty($is_imei)) {
    $item = $voip->get_item($_table, array('mobile' => $mobile));
    if (!empty($item)) {
        //已注册。执行登陆激活步骤
//	$row = $voip->get_item($_table,array('mobile'=>$mobile,'imei'=>$imei));
//        echo $item['imei'];exit;
        if ($item['imei'] != $imei) {
//                $ret = $voip->get_item($_table, array('imei' => $imei));
                //imei在库中
//                if (!empty($ret)) {
//                    $voip->delete_data($_table, array('imei' => $imei));
                $voip->update_data($_table, array('imei' => $imei), array('imei' => '', 'status' => 0));
                $voip->update_data($_table, array('mobile' => $mobile), array('imei' => $imei, 'status' => 0));
                _logger(_LL_DEBUG,'line:'.__LINE__.',已注册,imei,'.$imei.',mobile:'.$mobile);
        }
        if ($item['status'] == 1) {
//		sendput('180',$format);
            $status = '180';
        } else {
            _logger(_LL_DEBUG,'line:'.__LINE__.',已注册,imei,'.$imei.',mobile:'.$mobile);
            //需要激活步骤
            $item = $voip->get_item('T_group_info', array('mobile' => $mobile));
            if (!empty($item['isadmin'])) {
                $status = '181,' . $item['isadmin'];
            } else {
                $status = '181';
            }
        }

    } else {
        //避免功能机与智能机重复注册的情况
        if ($voip->check_im_user($mobile)) {
            $status = '179';
        } else {
//	注册
                $items = $voip->get_item($_table, array('imei' => $imei));
                if (!empty($items)) {
                    if (!empty($items['mobile'])) {
                        $voip->update_data($_table, array('imei' => $imei), array('imei' => '', 'status' => 0, 'country' => $country));
                        $voip->insert_data($_table, array('imei' => $imei, 'mobile' => $mobile, 'status' => 0, 'country' => $country,'agent'=>$agent,'model'=>$model));
                        _logger(_LL_DEBUG,'未注册,imei,'.$imei.',mobile:'.$mobile);
                    } else {
                        $voip->update_data($_table, array('imei' => $imei), array('mobile' => $mobile, 'status' => 0, 'country' => $country));
                    }
                } else {
                    $voip->insert_data($_table, array('imei' => $imei, 'mobile' => $mobile, 'status' => 0, 'country' => $country,'agent'=>$agent,'model'=>$model));
                }
                $status = '181';
            }
        }
    }
else {
//		imei不在库中
//		$voip->insert_data($_table,array('imei'=>$imei,'mobile'=>$mobile,'status'=>0));
//		sendput('179',$format);exit;
        $status = '179';
    }

}
header("Content-Type: text/html;charset=utf-8");
header("Content-Length: " . strlen($status));
_logger(_LL_DEBUG,'login,code:'.$status.',format:'.$format);
sendput($status, $format);

