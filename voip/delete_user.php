<<<<<<< HEAD
<?php
/**
 * Created by PhpStorm.
 * User: jerry
 * Date: 2015/4/14 0014
 * Time: 11:20
 */
define("BASEPATH", dirname(__FILE__) . '/');

include_once BASEPATH . 'config/conf.php';
include_once BASEPATH . 'model/voip.php';
include_once INCLUDE_PATH . 'libraries/SmsGateway.class.php';
include_once INCLUDE_PATH . 'libraries/Redis.class.php';

$input = new CI_Input();
$mobile = trim($input->get_post('mobile'));

$voip = new voip();
//删除im用户
$voip->delete_im_user($mobile);
$voip->delete_data('T_phone_info',array('mobile'=>$mobile));
$voip->delete_data('T_group_info',array('mobile'=>$mobile));
$voip->delete_data('T_user_imei',array('mobile'=>$mobile));
$ret = $voip->delete_data('T_user_info',array('username'=>$mobile));
=======
<?php
/**
 * Created by PhpStorm.
 * User: jerry
 * Date: 2015/4/14 0014
 * Time: 11:20
 */
define("BASEPATH", dirname(__FILE__) . '/');

include_once BASEPATH . 'config/conf.php';
include_once BASEPATH . 'model/voip.php';
include_once INCLUDE_PATH . 'libraries/SmsGateway.class.php';
include_once INCLUDE_PATH . 'libraries/Redis.class.php';

$input = new CI_Input();
$mobile = trim($input->get_post('mobile'));

$voip = new voip();
//删除im用户
$voip->delete_im_user($mobile);
$voip->delete_data('T_phone_info',array('mobile'=>$mobile));
$voip->delete_data('T_group_info',array('mobile'=>$mobile));
$voip->delete_data('T_user_imei',array('mobile'=>$mobile));
$ret = $voip->delete_data('T_user_info',array('username'=>$mobile));
>>>>>>> 63b94a7e1b4167248a21999ae09c4dde81b786e9
var_dump($ret);exit;