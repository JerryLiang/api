<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// 包含文件路径
define('INCLUDE_PATH', realpath(BASEPATH . '../') . '/include/');

// DataStore Server Path
define('DATASTORE_STORE_PATH', 'tcp://127.0.0.1:11214');

// Memcache Server Path
define('DATACACHE_STORE_PATH', 'tcp://127.0.0.1:11211');

###################
# 加载公共配置文件 #
###################
include_once INCLUDE_PATH . 'config/common.config.php';

################
# 加载辅助函数 #
################

// 通用函数
include_once INCLUDE_PATH . 'helpers/common.inc.php';
// 日志函数
include_once INCLUDE_PATH . 'helpers/logger.php';
// 输入类
include_once INCLUDE_PATH . 'libraries/Input.php';
// Memcache类
include_once INCLUDE_PATH . 'libraries/DataCache.class.php';
// TTserver类
include_once INCLUDE_PATH . 'libraries/DataStore.class.php';
// 数据库类
include_once INCLUDE_PATH . 'database/DB.php';

get_device();
