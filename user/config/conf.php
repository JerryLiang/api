<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// 生产环境时，请改为 false
define('DEBUG', false);

// 图片路径前缀，最尾不含反斜杠 '/'；支持多个轮询
$url_prefixs = array('http://121.40.144.58/uploads/user/');
// 本地存储绝对路径，最尾不含反斜杠 '/'
define('UPLOAD_PATH', '/home/data/uploads/user');

###############################################
# 日志配置
# LOG_FILE_PATH: Log file save path
# MAX_LOG_LEVEL: Log level: 1-ERROR,2-WARN,3-INFO,4-DEBUG
# FETCH_LOG: fetch log
define('LOG_FILE_PATH', '/home/webtronics/logs/user');
define('MAX_LOG_LEVEL', 4);

