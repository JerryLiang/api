<?php

/*
  首次添加设备成为管理员,移交管理员，加载列表
 */

define("BASEPATH", dirname(__FILE__) . '/');
include_once BASEPATH . 'config/system.php';
include_once BASEPATH . 'config/conf.php';
include_once BASEPATH . 'config/database.php';
include_once INCLUDE_PATH . 'libraries/Auth.class.php';
include_once BASEPATH . 'model/user.php';

$input = new CI_Input();
$username = trim($input->get_post('user'));
$mobile = trim($input->get_post('mobile'));
$imei = trim($input->get_post('imei'));
//$udid = trim($input->get_post('udid'));
$pass = trim($input->get_post('pass'));
$action = trim($input->get_post('action'));

$auth = Auth::getInstance($dbconfig['mainuser']);
$reVal = array('content' => '', 'status' => 103);

$img_url_prefix = $url_prefixs[array_rand($url_prefixs)];

if (empty($username) || empty($mobile) || empty($action)) {
    $reVal['content'] = _display_error('102');
    $reVal['status'] = 102;
} else {
    $imdata = array('master' => $mobile, 'member' => $username);
    $user = new user_model();
    switch ($action) {
        case 'list': //成员列表

            $reVal['list'] = array();
            $query = $auth->_main_user_db->query("select member from `T_group_info` WHERE `mobile`='" . $mobile . "' limit 1");
            if ($query && $query->num_rows() > 0) {
                $member = unserialize($query->row()->member);
                $i = 0;
                foreach ($member as $val) {
                    $ret = array();
                    $temp[$i] = $val;
                    $ret = $auth->_main_user_db->query("select headimag,names from `T_user_info` WHERE `username`='" . $val['username'] . "' limit 1");
                    $headimg = $ret->row()->headimag;
                    $temp[$i]['headimag'] = !empty($headimg) ? $img_url_prefix . $headimg : '';
                    $temp[$i]['name'] = $ret->row()->names;
                    $i++;
                }
                $phone = $auth->_main_user_db->query("select headimag,names from `T_phone_info` WHERE `mobile`='" . $mobile . "' limit 1");
                $phoneimg = $phone->row()->headimag;
                $temp[$i]['username'] = $mobile;
                $temp[$i]['headimag'] = !empty($phoneimg) ? $img_url_prefix . $phoneimg : '';
                $temp[$i]['name'] = $phone->row()->names;
                $reVal['status'] = 0;
                $reVal['list'] = $temp;
            }
            unset($query);
            break;
        case 'move': //移交管理员
            $moveuser = trim($input->get_post('moveuser'));
            if (empty($moveuser)) {
                $reVal['content'] = _display_error('102');
                $reVal['status'] = 102;
            } else {
                $info = $user->check_record("select id from `T_group_info` WHERE `isadmin`='" . $username . "' and `mobile` = " . $mobile, 'val');
//				echo $info;exit;
                if ($info) {
                    $auth->_main_user_db->set('isadmin', $moveuser);
                    $auth->_main_user_db->where('id', $info);
                    if ($auth->_main_user_db->update('T_group_info') && $auth->_main_user_db->affected_rows() > 0) {
                        $reVal['content'] = _display_error('166');
                        $reVal['status'] = 166;
                    } else {
                        $reVal['content'] = _display_error('167');
                        $reVal['status'] = 167;
                    }
                } else {
                    $reVal['content'] = _display_error('165');
                    $reVal['status'] = 165;
                }
                unset($info);
            }
            break;
        case 'adduser': //添加管理员
            $phone = $auth->_main_user_db->query("select * from `T_phone_info` WHERE `mobile` = '" . $mobile . "'");
//			$phone = $user->check_record("select id from `T_phone_info` WHERE `imei`='" . $imei . "'");
            $par = $phone->row_array();
            if (!empty($par) && $par['imei']) {
                if (!$par['status']) {
                    $query = $auth->_main_user_db->query("select id,isadmin from `T_group_info` WHERE `mobile`='" . $mobile . "'");
                    $ret = $query->row_array();
                    if ($query->num_rows() == 0) {
                        $data = array(
                            'mobile' => $mobile,
                            'isadmin' => $username,
                            'member' => serialize(array(array('username' => $username, 'udid' => $udid)))
                        );
                        //添加设备列表
                        $query = $auth->_main_user_db->query("select id from `T_user_imei` WHERE `username`='" . $username . "' and `mobile`='" . $mobile . "' limit 1");
                        if ($query && $query->num_rows() <= 0) {
                            $user->insert_imserver($imdata);
//							$names = !empty($phone->row()->names) ? $phone->row()->names ; '';
                            $auth->_main_user_db->query("insert into T_user_imei(username,udid,mobile,names,headimag)value('" . $username . "','" . $udid . "','" . $mobile . "','" . $phone->row()->names . "','" . $phone->row()->headimag . "')");
                            //更新用户信息
                            $auth->_main_user_db->query("update T_user_info set mobile='" . $mobile . "' where username='" . $username . "'");
                            if ($auth->_main_user_db->insert('T_group_info', $data) && $auth->_main_user_db->affected_rows() > 0) {
                                $reVal['status'] = 0;
                                $reVal['mobile'] = $mobile;
                                $reVal['content'] = _display_error('161');
                            }
                        }

                        _logger(_LL_DEBUG, '117,mobile:' . $mobile . ',imei:' . $par['imei']);

                        if (strpos($mobile, '0086') !== false) {
                            $auth->_main_user_db->where('imei', $par['imei']);
                            $query = $auth->_main_user_db->get('T_phone_list');
                            $phone_item = $query->row_array();
                            if (!$phone_item['status']){
                                //注册voip
                                $val = reg_voip($mobile);
                            $val = json_decode($val, true);
                            $auth->_main_user_db->insert("T_voip_info", array('mobile' => $mobile, 'imei' => $par['imei'], 'status' => $val['status'], 'info' => $val['info']));
                            if (!$val['status']) {
                                //检测机器是否绑定voip
                                $auth->_main_user_db->where('imei', $par['imei']);
                                $query = $auth->_main_user_db->get('T_voip_imei');
                                $n = $query->num_rows();
                                if (empty($n)) {
                                    $query = $auth->_main_user_db->query("SELECT * FROM `T_voip_imei` WHERE `imei`= '' limit 0,1");
                                }
                                $card = $query->row_array();
                                $cid = $card['id'];
                                $cardid = $card['voipid'];
                                $cardpw = $card['voippass'];
                                //充值voip
                                $chg = charge_voip($mobile, $cardid, $cardpw);
                                $chg = json_decode($chg, true);
                                $auth->_main_user_db->insert("T_voip_activate", array('mobile' => $mobile, 'imei' => $par['imei'], 'status' => $chg['status'], 'info' => $chg['info']));
                                if (!$chg['status']) {
                                    $auth->_main_user_db->query("update T_voip_imei set status = 1,imei='" . $par['imei'] . "' where id = '" . $cid . "'");
                                }
                            }
                        }
                    }
                        $auth->_main_user_db->query("update T_phone_info set status = 1 where mobile='" . $mobile . "'");
                    } elseif ($ret['isadmin'] == $username) {
                        if (strpos($mobile, '0086') !== false) {
                            //查找是否需要voip
                            $auth->_main_user_db->where('imei', $par['imei']);
                            $query = $auth->_main_user_db->get('T_phone_list');
                            $phone_item = $query->row_array();
                            if (!$phone_item['status']){
                                //注册voip
                                $val = reg_voip($mobile);
                            $val = json_decode($val, true);
                            $auth->_main_user_db->insert("T_voip_info", array('mobile' => $mobile, 'imei' => $par['imei'], 'status' => $val['status'], 'info' => $val['info']));
//                             重新激活，不需要检测voip是否注册过
//                            if (!$val['status']) {
                                $auth->_main_user_db->where('imei', $par['imei']);
                                $query = $auth->_main_user_db->get('T_voip_imei');
                                //检测机器是否绑定voip
                                $n = $query->num_rows();
                                if (empty($n)) {
                                    $query = $auth->_main_user_db->query("SELECT * FROM `T_voip_imei` WHERE `imei`= '' limit 0,1");
                                }
                                $card = $query->row_array();
                                $cid = $card['id'];
                                $cardid = $card['voipid'];
                                $cardpw = $card['voippass'];
                                //充值voip
                                $chg = charge_voip($mobile, $cardid, $cardpw);
                                $chg = json_decode($chg, true);
                                $auth->_main_user_db->insert("T_voip_activate", array('mobile' => $mobile, 'imei' => $par['imei'], 'status' => $chg['status'], 'info' => $chg['info']));
                                if (!$chg['status']) {
                                    $auth->_main_user_db->query("update T_voip_imei set status = 1,imei='" . $par['imei'] . "' where id = '" . $cid . "'");
                                }
//                            }
                        }
                        }
                        $auth->_main_user_db->query("update T_phone_info set status = 1 where mobile='" . $mobile . "'");
                        $reVal['content'] = _display_error('161');
                        $reVal['mobile'] = $mobile;
                        $reVal['status'] = 0;
                    } else {
                        $reVal['content'] = _display_error('162');
                        $reVal['status'] = 162;
                    }

                    unset($query);
                } else {
                    $reVal['content'] = _display_error('162');
                    $reVal['status'] = 162;
                }
            } else {
                $reVal['content'] = _display_error('189');
                $reVal['status'] = 189;
            }
            break;
    }
}

echo json_encode($reVal);
?>
