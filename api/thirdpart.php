<?php
/**
 * Created by PhpStorm.
 * User: jerry
 * Date: 2015/6/1 0001
 * Time: 14:57
 */

define("BASEPATH", dirname(__FILE__) . '/');
include_once BASEPATH . 'config/system.php';
include_once BASEPATH . 'config/conf.php';
include_once BASEPATH . 'config/database.php';
include_once INCLUDE_PATH . 'libraries/Auth.class.php';
//include_once BASEPATH . 'model/api.php';

$input = new CI_Input();

header('Location:http://m.dianping.com/tuan');
