<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// 生产环境时，请改为 false
define('DEBUG', false);
define('BASE_URL', 'http://115.29.160.121/api/');

include_once BASEPATH . 'config/system.php';
include_once BASEPATH . 'config/database.php';

###############################################
# 日志配置
# LOG_FILE_PATH: Log file save path
# MAX_LOG_LEVEL: Log level: 1-ERROR,2-WARN,3-INFO,4-DEBUG
# FETCH_LOG: fetch log
define('LOG_FILE_PATH', '/home/webtronics/logs/voip');
define('MAX_LOG_LEVEL', 4);

