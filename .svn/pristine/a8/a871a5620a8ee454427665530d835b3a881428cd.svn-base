<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

define("BASEPATH", dirname(__FILE__) . '/');
include_once BASEPATH . 'config/system.php';
include_once BASEPATH . 'config/conf.php';
include_once BASEPATH . 'config/database.php';
include_once INCLUDE_PATH . 'libraries/Auth.class.php';
include_once BASEPATH . 'model/user.php';


$user = new user_model();
$yy = $user->select_imserver();
print_r($yy);exit;

$auth = Auth::getInstance($dbconfig['mainuser']);
$img_url_prefix = $url_prefixs[array_rand($url_prefixs)];
$temp_1 = array();
$query = $auth->_main_user_db->query("select imei,names,headimag from T_user_imei where udid='7bc561cd-753d-3eab-862c-6dbee02eeebb'");
if ($query && $query->num_rows() > 0) {
    foreach ($query->result_array() as $row) {
         $temp_1[] =array('imei'=>!empty($row['imei']) ? $row['imei'] : '','names'=>!empty($row['names']) ? $row['names'] : '','image'=>!empty($row['headimag']) ? $img_url_prefix .$row['headimag'] : '');
       
    }
}
unset($query);
$reVal['status'] = 0;
$reVal['list'] = $temp_1;
echo json_encode($reVal);



exit;

$auth = Auth::getInstance($dbconfig['mainuser']);
$query = $auth->_main_user_db->query("select member from `T_group_info` WHERE `id`=5 limit 1");
if ($query && $query->num_rows() > 0) {
    $member1 = unserialize($query->row()->member);
    foreach ($member1 as $key => $val) {
        $temp[] = $val;
    }
    $username = "008613528750391";
    $udid = "3dd59828-d93b-3190-883e-763def718d70";
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
    }
}
unset($query);
print_r($member);

//echo serialize(array(array('username' => $username, 'udid' => $udid)));
//print_r($member);
//exit;


$data = array(array('username' => 1, 'udid' => 'aaa'), array('username' => 2, 'udid' => 'bbb'), array('username' => 3, 'udid' => 'ccc'));

//$reval = array();
//foreach ($data as $key => $val) {
//    $temp[] = $val;
//}
//$reval['userlist'] = $temp;
//
//echo json_encode($reval);

$data[] = array('username' => 4, 'udid' => 'dddd');

foreach ($data as $k => $v) {
    if ($v['username'] == 1) {
        unset($data[$k]);
    }
}

print_r($data, false);

exit;

function assoc_unique($arr, $key) {
    $tmp_arr = array();
    foreach ($arr as $k => $v) {
        if (in_array($v[$key], $tmp_arr)) {
            unset($arr[$k]);
        } else {
            $tmp_arr[] = $v[$key];
        }
    }
    sort($arr);
    return $arr;
}

$key = 'username';
//assoc_unique($data, $key);
$tmp_arr = array();
foreach ($data as $k => $v) {
    if (in_array($v[$key], $tmp_arr)) {
        unset($data[$k]);
    } else {
        $tmp_arr[] = $v[$key];
    }
}
sort($data);
print_r($data, false);
?>
