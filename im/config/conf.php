<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// 生产环境时，请改为 false
define('DEBUG', false);

###############################################
# 日志配置
# LOG_FILE_PATH: Log file save path
# MAX_LOG_LEVEL: Log level: 1-ERROR,2-WARN,3-INFO,4-DEBUG
# FETCH_LOG: fetch log
define('LOG_FILE_PATH', '/home/webtronics/logs/im');
define('MAX_LOG_LEVEL', 4);

define('IOS_PEM','/home/webtronics/htdocs/api/im/config/ApnsCertificateFile/apple_push_notification_production.pem');
define('FUN_PEM','/home/webtronics/htdocs/api/im/config/ApnsCertificateFile/magic-dev.pem');
define('COM_PEM','/home/webtronics/htdocs/api/im/config/ApnsCertificateFile/magic-dis-企业版.pem');

