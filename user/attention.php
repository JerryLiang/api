<?php

/*
  邀请关注接口
 */

define("BASEPATH", dirname(__FILE__) . '/');
include_once BASEPATH . 'config/system.php';
include_once BASEPATH . 'config/conf.php';
include_once BASEPATH . 'config/database.php';
include_once INCLUDE_PATH . 'libraries/Auth.class.php';
include_once BASEPATH . 'model/user.php';

$input = new CI_Input();
$username = trim($input->get_post('user'));
$imei = trim($input->get_post('imei'));
$mobile = trim($input->get_post('mobile'));
$udid = trim($input->get_post('udid'));
$code = trim($input->get_post('code'));
$action = trim($input->get_post('action'));

$lang = CLIENT_LANGUAGE;
$lang = !empty($lang) ? $lang : $input->get_post('lang');
$ca = $input->get_post('ca');

$auth = Auth::getInstance($dbconfig['mainuser']);
$reVal = array('content' => '', 'status' => 103);
if (empty($username) || empty($mobile) || empty($action)) {
	$reVal['content'] = _display_error('102');
	$reVal['status'] = 102;
}
//elseif (!$auth->verify()) {
//	$reVal['content'] = _display_error('101');
//	$reVal['status'] = 101;
//}
else {
	$user = new user_model();
	$imdata = array('master' => $mobile, 'member' => $username);
	switch ($action) {
		case 'sendcode':
//			echo CLIENT_PLATFORM.'ii';exit;
			//生成随机码
			$rand_code = generate_password();
			$data = array(
				'username' => $username,
				'mobile' => $mobile,
				'udid' => $udid,
				'code' => $rand_code
			);

			if ($auth->_main_user_db->insert('T_attention_info', $data) && $auth->_main_user_db->affected_rows() > 0) {

				$ca = !empty($ca) ? $ca : 'default';
				$lang = !empty($lang) ? $lang : 'cn';
				$upinfo = $user->get_upgrate($lang, $ca);
//				$downloadurl = $upinfo['downloadurl'];
//				//快速注册地址
////				$regist_url = httpfetch(BASE_URL.'api/get_sms_content.php?imei='.$imei.'&user='.$username.'&ca='.$ca);
//				//在cnzz生成短地址
////				$short_url = httpfetch('http://www.rdcnzz.com/v1/data/link_conv/rd_dispatcher.php?orig_link='.urlencode($regist_url));
//				$downloadurl = httpfetch('http://www.rdcnzz.com/v1/data/link_conv/rd_dispatcher.php?orig_link=' . urlencode($downloadurl));

                $downloadurl = BASE_URL.'api/get_download_url.php?lang='.$lang.'&ca='.$ca;
                $base64_url = base64_encode($downloadurl);
                $result = $user->get_short_url($base64_url);
                if(!empty($result)){
                    $sms_link = $result['short_url'];
                }
                else{
                    $t= time()-86400;
                    $header =array('Referer: http://dwz.aidmin.cn/','User-Agent:Mozilla/5.0 (Windows NT 6.3; WOW64; rv:35.0) Gecko/20100101 Firefox/35.0','Cookie:Hm_lvt_fd97a926d52ef868e2d6a33de0a25470='.$t.'; PHPSESSID=l0ko5a7vpd11u7upmf24snqfa4; Hm_lpvt_fd97a926d52ef868e2d6a33de0a25470='.time());
                    $ret = httpfetch('http://dwz.aidmin.cn/api.php?url='.base64_encode($downloadurl).'&site=t','',$header);
                    $ret = json_decode($ret,true);
                    if($ret['result'] == 'ok'){
                        $data = array('long_url'=>$downloadurl,'short_url'=>$ret['data']['short_url'],'base64_url'=>$base64_url,'type'=>'sina','created'=>date("Y-m-d H:i:s"));
                        $result = $user->insert_short_url($data);
                        $sms_link = $ret['data']['short_url'];
                    }
                    else{
                        $sms_link = $downloadurl;
                    }
                }
                $reVal['status'] = 0;
				$reVal['code'] = $rand_code;
				$reVal['mobile'] = $mobile;
				$reVal[CLIENT_PLATFORM . '_download'] = $sms_link;
                _logger(_LL_DEBUG, 'sendcode:' . print_r($reVal,true));
//				$reVal['regist_url'] = $short_url;
				$reVal['content'] = output(_display_error('1002'), $sms_link, $mobile, $rand_code);
//				$reVal['content'] = _display_error('163');
			} else {
				$reVal['status'] = 164;
				$reVal['content'] = _display_error('164');
			}
			break;
		case 'adduser':
			//添加关注用户
			$info = $user->check_record("select id from `T_attention_info` WHERE `mobile`='" . $mobile . "' and `code`='" . $code . "' limit 1");
            if (strlen($code) == 6) {
				$focus_code = $auth->_main_user_db->query("select names,headimag from T_phone_info where mobile='" . $mobile . "' and pass ='" . $code . "'");
				$code_num = $focus_code->num_rows();
			} else {
				$code_num = 0;
			}
			if ($info || $code_num) {
				//群中去重或加载
				$query = $auth->_main_user_db->query("select member from `T_group_info` WHERE `mobile`='" . $mobile . "' limit 1");
				if ($query && $query->num_rows() > 0) {
					$member = unserialize($query->row()->member);
					if (is_array($member)) {
						$member[] = array('username' => $username, 'udid' => $udid);
						$tmp_arr = array();
						foreach ($member as $k => $v) {
							if (in_array($v['username'], $tmp_arr)) {
								unset($member[$k]);
							} else {
								$tmp_arr[] = $v['username'];
							}
						}
						sort($member);
						//加入该用户老人机列表
						$ret = $auth->_main_user_db->query("select names,headimag from T_phone_info where mobile='" . $mobile . "'");
						$res = $auth->_main_user_db->query("select id from T_user_imei   where  `mobile`='" . $mobile . "' and `username` = '" . $username . "'");

						if ($ret->num_rows() > 0 && $res->num_rows() == 0) {
							$user->insert_imserver($imdata);
							$auth->_main_user_db->query("update T_group_info set member='" . serialize($member) . "' where  `mobile`='" . $mobile . "'");
							$status = $auth->_main_user_db->query("insert into T_user_imei(username,udid,mobile,names,headimag)value('" . $username . "','" . $udid . "','" . $mobile . "','" . $ret->row()->names . "','" . $ret->row()->headimag . "')");
							//更新用户信息
							$auth->_main_user_db->query("update T_user_info set mobile='" . $mobile . "' where username='" . $username . "'");
//								$auth->_main_user_db->query("insert into im_relation (username,imei,created)value('".$username ."','" . $imei . "','1','" . date("Y-m-d H:i:s") . "')");
						}
						if (!empty($status)) {
							$reVal['status'] = 0;
							$reVal['content'] = _display_error('169');
						} else {
							$reVal['status'] = 170;
							$reVal['content'] = _display_error('170');
						}

						unset($ret);
					}
				}
                _logger(_LL_DEBUG, 'mobile:'.$mobile.',username:' . $username . ',' . print_r($reVal, true));
                unset($query);
			} else {
				$reVal['status'] = 168;
				$reVal['content'] = _display_error('168');
			}
			unset($info);
			break;
		case 'canceluser':
			//非管理员取消关注用户
			$info = $user->check_record("select id from `T_group_info` WHERE `mobile`='" . $mobile . "' and `isadmin`='" . $username . "' limit 1");
			if (!$info) {
				//群中去重
				$query = $auth->_main_user_db->query("select member from `T_group_info` WHERE `mobile`='" . $mobile . "' limit 1");
				if ($query && $query->num_rows() > 0) {
					$member = unserialize($query->row()->member);
					//去除
					foreach ($member as $k => $v) {
						if ($v['username'] == $username) {
							unset($member[$k]);
						}
					}
					//
//					在该用户关注列表中取消
					$user->cancel_user('T_user_imei', $username, $mobile);
					//当前关注用户取消
					$user->update_data('T_user_info', array('username' => $username, 'mobile' => $mobile), array('mobile' => ''));
					$user->delete_imserver($imdata);
					if (is_array($member)) {
						//插入
						$status = $auth->_main_user_db->query("update T_group_info set member='" . serialize($member) . "' where  `mobile`='" . $mobile . "'");
						if ($status && $auth->_main_user_db->affected_rows() > 0) {
							$reVal['status'] = 0;
							$reVal['content'] = _display_error('171');
						} else {
							$reVal['status'] = 172;
							$reVal['content'] = _display_error('172');
						}
					}
				}
				unset($query);
			} else {
				$reVal['status'] = 173;
				$reVal['content'] = _display_error('173');
			}
			unset($info);
			break;
	}
}
echo json_encode($reVal);
