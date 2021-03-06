<?php

/**
 * 短信网关类
 */
class SmsGateway {

    public $err_msg = '';
    public $msgids = array();

    public function __construct() {
        
    }

    //短信网关
    public function send_sms($mobile, $chanel, $msg)
    {
        $status = FALSE;
        switch (strtolower($chanel)) {
            case 'hztk'://国内号码
                $return = $this->_fetch_api("http://cbapi.iddsms.com/smspro.php?userId=J22088&password=640522&pszMobis=" . $mobile . "&pszMsg=" . urlencode($msg) . "&iMobiCount=1&pszSubPort=*&type=1");
//                _logger(_LL_DEBUG,'url:'."http://cbapi.iddsms.com/smspro.php?userId=J22088&password=640522&pszMobis=" . $mobile . "&pszMsg=" . urlencode($msg) . "&iMobiCount=1&pszSubPort=*&type=1");
                $pos = strpos($return, '0');
                if ($pos !== false) {
                    $status = TRUE;
                } else {
                    $status = FALSE;
                }
                break;
            case 'outk': //国际号码
//                $return = $this->_fetch_api("http://sms.iddsms.com/websmss_dxmaoservice/dxapi/dxapi_send.jsp?username=J22088&password=123456&phone=" . $mobile . "&content=" . urlencode($msg));
                $pre = substr($mobile,0,2);
                if($pre == '00'){
                    $mobile = substr($mobile,2);
                }
                $return = $this->_fetch_api("http://93.158.78.4:3800/sendsms?username=v_Uoshon_gl&password=TA6jJU7n&from=UOSHON&to=".$mobile."&text=".urlencode($msg));
//                var_dump($return);exit;
//                $pos = strpos($return, '0');
                $pos = strlen($return);
                if ($pos == 32) {
                    $status = TRUE;
                } else {
                    $status = FALSE;
                }
                break;
        }
        return $status;
    }

    private function _fetch_api($url, $data = array()) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        if (!empty($data) && is_array($data)) {
            foreach ($data as $key => $val) {
                $url .= '&' . $key . '=' . $val;
            }
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // 设置连接超时时间 10 秒
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        // 设置超时时间 30 秒
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $out = curl_exec($ch);
        if ($out === false) {
            _logger(_LL_ERROR, 'Connect failed: ' . $url);
        } else {
            $out = trim($out);
        }
        curl_close($ch);
        return $out;
    }

}

?>
