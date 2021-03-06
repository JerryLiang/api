<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// 生产环境时，请改为 false
define('DEBUG', false);

define('BASE_URL', 'http://115.29.160.121/api/media/index.php');

// 图片路径前缀，最尾不含反斜杠 '/'；支持多个轮询
$url_prefixs = array('http://115.29.160.121/uploads/media');

// 本地存储绝对路径，最尾不含反斜杠 '/'
define('UPLOAD_PATH', '/home/data/uploads/media');

// 处理队列key值
define('QUEUE_KEY', 'imagetransfer');

###############################################
# 日志配置
# LOG_FILE_PATH: Log file save path
# MAX_LOG_LEVEL: Log level: 1-ERROR,2-WARN,3-INFO,4-DEBUG
# FETCH_LOG: fetch log
define('LOG_FILE_PATH', '/home/webtronics/logs/media');
define('MAX_LOG_LEVEL', 4);
