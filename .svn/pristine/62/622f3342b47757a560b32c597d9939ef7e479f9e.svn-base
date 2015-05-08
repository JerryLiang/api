
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/3/9
 * Time: 11:21
 */


define("BASEPATH", dirname(__FILE__) . '/');

include_once BASEPATH . 'config/conf.php';
include_once BASEPATH . 'model/voip.php';
include_once INCLUDE_PATH . 'libraries/SmsGateway.class.php';
include_once INCLUDE_PATH . 'libraries/Redis.class.php';


$input = new CI_Input();
$mobile = trim($input->get_post('mobile'));
$imei = trim($input->get_post('imei'));
$lang = CLIENT_LANGUAGE;
$lang = !empty($lang) ? $lang : $input->get_post('lang');

$_table = 'T_phone_info';
$_code_table = 'T_phone_verify';

if(CLIENT_PLATFORM == 'iphone' || CLIENT_PLATFORM == 'android'){
    $format = 'json';
}
else{
    $format = 'txt';

}
$voip = new voip();

if($mobile && $imei){
	if($voip->get_num($_table,array('mobile'=>$mobile,'imei'=>$imei,'status'=>1))){
		//已激活
//		sendput('180',$format);
        $errno = '180';
	}
	else{
		//未激活，跳转至注册登陆步骤
//		sendput('181',$format);
        $errno = '181';
	}
}else{


	$redis = new RedisInit();
    $t = $redis->redis()->get($mobile.'T');
    if(!empty($t)){
        $limit = time()-$t;
        $errno = 130-$limit;
//        if($errno >= 0){
            sendput($errno,$format);exit;
//        }
    }
	$time = $redis->redis()->get($mobile.'C');
	$time = !empty($time) ? $time : 0;
//	if($time < 10){
		$code = $redis->redis()->hGet('VerifyCode',$mobile);
		if(!empty($code)){
			$rand_num =  $code;
		}
		else{
			$rand_num =  generate_password(4);
			$redis->redis()->hSet('VerifyCode',$mobile,$rand_num);
		}
//        $tag = strpos($mobile,'0086');
        if(strpos($mobile, '0086') !== false){
            $stype = 'hztk';
            $msg = '您的啊哩咕哩的验证码是：'.$rand_num;
//            $msg = 'Your ALIGULI verification code is:'.$rand_num;
        }
        else{
            $stype = 'outk';
            $msg = 'Your ALIGULI verification code is:'.$rand_num;
        }
//        $stype = !empty($tag) ? 'hztk':'outk';
//		$msg = '您的啊哩咕哩的验证码是：'.$rand_num;
//		$msg = sprintf(_display_phone_error('1003',$lang),$rand_num);
		$sms = new SmsGateway();
		$result = $sms->send_sms($mobile, $stype, $msg);
		if ($result) {
            $redis->redis()->set($mobile.'T',time(),130);
            if(empty($time)) {
				$voip->insert_data($_code_table,array('mobile'=>$mobile,'type'=>$format,'code'=>$rand_num,'created'=>date("Y-m-d H:i:s")));
			}
			$redis->redis()->set($mobile.'C',++$time,strtotime(date("Y-m-d 23:59:59"))-time());
//			$u = $redis->redis()->get($mobile.'C');
            _logger(_LL_DEBUG,'sms_succ,type:'.$stype.',mobile:'.$mobile.',msg:'.$msg);
//            sendput('181',$format);
            $errno = '181';

        }else{
            _logger(_LL_DEBUG,'sms_fail,type:'.$stype.',mobile:'.$mobile.',msg:'.$msg);
//            sendput('123',$format);
            $errno = '123';

        }
//	}
//	else{
//		sendput('124',$format);
//	}

	}

if($format == 'txt'){
    header("Content-Type: text/html;charset=utf-8");
    header("Content-Length: ".strlen($errno));
}
sendput($errno,$format);




