<<<<<<< HEAD
<?php

/**
 * CloudFS class.
 *
 * Abstraction layer for integrating with multiple storage_client,  specifically formatted for CodeIgniter
 *
 */
class CloudFS {

    private $tracker_server;
    private $storage_server;
    private $group_name;

    /**
     *  静态成品变量 保存全局实例
     *  @access private
     */
    static private $_instance = NULL;

    /**
     *  私有化克隆函数，防止外界克隆对象
     */
    private function __clone() {
        
    }

    /**
     *  私有化构造函数，防止外界实例化对象
     */
    private function __construct($service) {
        $this->load($service);
    }

    /**
     *  静态方法, 单例统一访问入口
     *  @return  object  返回对象的唯一实例
     */
    static public function factory($service = '') {
        if (is_null(self::$_instance) || !isset(self::$_instance)) {
            self::$_instance = new self($service);
        }
        return self::$_instance;
    }

    public function load($service = '') {
        if ($service == '') {
            //$ci=&get_instance();
            //$service=$ci->config->item("cfs_service");
            $service = 'local';
        }

        $prefix = 'CFS_';
        $classname = $prefix . $service;
        if (class_exists($classname)) {

            $this->_obj = $this->load_class($classname);
        } else {
            trigger_error("service type not found");
        }
    }

    function & load_class($class) {
        static $_classes = array();

        if (isset($_classes[$class])) {
            return $_classes[$class];
            // 如果类已实例化，直接返回类对象
        }
        $_classes[$class] = new $class();
        return $_classes[$class];
    }

    public function __call($method, $args) {
        if (method_exists($this->_obj, $method)) {
            return call_user_func_array(array($this->_obj, $method), $args);
        }
        trigger_error("Method $method not found");
    }

}

abstract class CFSAbstract {

    private $_conn;
    private $_errormsg = "";
    private $_error = false;

    /**
     * Constructor
     *
     * @access public
     * @return void
     */
    public function __contsruct() {
        $this->_conn = false;
        $this->_errormsg = "";
    }

    /**
     * init function.
     *
     * Creates a connection to the service. Returns true if successful.
     *
     * @access public
     * @abstract
     * @param bool $credentials. (default: false)
     * @return boolean
     */
    abstract public function init($credentials = false);

    /**
     * uploadFile function.
     *
     * Upload a file to your service. Returns uri if successful, else returns false.
     *
     * @access public
     * @param string $filename
     * @return string URI of new file
     */
    abstract public function uploadFile($filename, $bucket = false);

    /**
     * getFileContents function.
     *
     * Gets the file contents from your service. Returns false if unsuccessful.
     *
     * @access public
     * @abstract
     * @param string $filename
     * @return string
     */
    abstract public function getFileContents($filename, $bucket = false);

    /**
     * getContentType function.
     *
     * Gets the content_type from your service for use in headers or wherever you need to know what you're dealing with. Returns false if unsuccessful.
     *
     * @access public
     * @abstract
     * @param string $filename
     * @return string
     */
    abstract public function getContentType($filename, $bucket = false);

    /**
     * lastError function.
     *
     * Returns the last error, if any
     *
     * @access public
     * @return string
     */
    public function lastError() {
        return $this->_errormsg;
    }

    public function hasError() {
        return $this->_error;
    }

    protected function _setError($message) {
        $this->_errormsg = $message;
        $this->_error = true;
    }

    public function _hash($str, $date_format='Y/m') {
        $filename = $str;

        if (($last_slash = strrpos($str, '/')) !== FALSE) {

            $path = substr($str, 0, $last_slash + 1);
            $filename = substr($str, $last_slash + 1);
        }

        //$md5 = compute_md5sum($str);
        $md5 = get_unique_name($filename);
        //$ext = get_extension($filename);
        if (empty($date_format)) $date_format = 'Y/m';
        $str = date($date_format) . '/' . substr($md5, -2, 2) . '/' . substr($md5, -4, 2) . '/' . $md5;
        return $str;
    }

    public function _hash2($id) {
        $id = intval($id);
        $hash_tree = Array();
        for ($i = 0; $i < $this->hash_opt; $i++) {
            $hash_tree[] = ceil($id / pow(32, $i)) % 32;
        }
        if (0 < sizeof($hash_tree)) {
            $hash_tree[] = $id;
            return $hash_tree;
        }
        return false;
    }

}

class CFS_local extends CFSAbstract {
    private $_upload_path = '';
    private $_has_init = false;
    protected $_date_format = '';
    
    public function init($path_prefix = '', $date_format = '') {
        if (!$this->_has_init and !empty($path_prefix)) {
            $path_prefix = trim($path_prefix, '/');
            $this->_upload_path = trim($this->_upload_path . '/' . $path_prefix, '/');
        }
        if (!empty($date_format)) {
            $this->_date_format = $date_format;
        }
        $this->_has_init = true;
    }

    public function uploadFile($filename, $bucket = false) {
        $ext = '';
        if (is_array($filename)) {
            $ext = get_extension($filename['name'], $filename['type']);
            $filename = $filename['tmp_name'];
        }

        $data = array();
        $data['path'] = $this->_upload_path . '/' . $this->_hash($filename, $this->_date_format) . $ext;
        $name = basename($data['path']);
        $data['fullpath'] = UPLOAD_PATH  . '/' . $data['path'];
        $dir = dirname($data['fullpath']);
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        if (@copy($filename, $dir . '/' . $name)) {
            $data['error'] = 0;
        } else {
            $data['error'] = 1;
        }

        return $data;
    }

    public function getFileContents($filename, $bucket = false) {
        
    }

    public function getContentType($filename, $bucket = false) {
        
    }

    protected function _isFolder($filename) {
        if (substr($filename, -1) == "/") {
            return true;
        }
        return false;
    }
}

function get_extension($filename, $type = '') {
    $pos = strrpos($filename, '.');
    if ($pos !== FALSE) {
        $ext = substr($filename, $pos);
    } else {
        $ext = '';
        switch ($type) {
            case 'image/jpeg':
                $ext = '.jpg';
                break;
            case 'image/png':
                $ext = '.png';
                break;
            case 'image/gif':
                $ext = '.gif';
                break;
            default:
                break;
        }
    }
    return $ext;
}

/**
 * Compute the MD5 checksum
 *
 * Calculate the MD5 checksum on either a PHP resource or data. The argument
 * may either be a local filename, open resource for reading, or a string.
 *
 * <b>WARNING:</b> if you are uploading a big file over a stream
 * it could get very slow to compute the md5 you probably want to
 * set the $verify parameter to False in the write() method and
 * compute yourself the md5 before if you have it.
 *
 * @param filename|obj|string $data filename, open resource, or string
 * @return string MD5 checksum hexidecimal string
 */
function compute_md5sum(&$data) {
    if (function_exists("hash_init") && is_resource($data)) {
        $ctx = hash_init('md5');
        while (!feof($data)) {
            $buffer = fgets($data, 65536);
            hash_update($ctx, $buffer);
        }
        $md5 = hash_final($ctx, false);
        rewind($data);
    } elseif ((string) is_file($data)) {
        $md5 = md5_file($data);
    } else {
        $md5 = md5($data);
    }

    return $md5;
}

function get_unique_name($filename) {
    $uniqueImagePart1 = md5(microtime());
    $uniqueImagePart2 = md5($filename);
    $unique_name = substr(md5($uniqueImagePart1 . $uniqueImagePart2), 8, 16);

    return $unique_name;
}
=======
<?php

/**
 * CloudFS class.
 *
 * Abstraction layer for integrating with multiple storage_client,  specifically formatted for CodeIgniter
 *
 */
class CloudFS {

    private $tracker_server;
    private $storage_server;
    private $group_name;

    /**
     *  静态成品变量 保存全局实例
     *  @access private
     */
    static private $_instance = NULL;

    /**
     *  私有化克隆函数，防止外界克隆对象
     */
    private function __clone() {
        
    }

    /**
     *  私有化构造函数，防止外界实例化对象
     */
    private function __construct($service) {
        $this->load($service);
    }

    /**
     *  静态方法, 单例统一访问入口
     *  @return  object  返回对象的唯一实例
     */
    static public function factory($service = '') {
        if (is_null(self::$_instance) || !isset(self::$_instance)) {
            self::$_instance = new self($service);
        }
        return self::$_instance;
    }

    public function load($service = '') {
        if ($service == '') {
            //$ci=&get_instance();
            //$service=$ci->config->item("cfs_service");
            $service = 'local';
        }

        $prefix = 'CFS_';
        $classname = $prefix . $service;
        if (class_exists($classname)) {

            $this->_obj = $this->load_class($classname);
        } else {
            trigger_error("service type not found");
        }
    }

    function & load_class($class) {
        static $_classes = array();

        if (isset($_classes[$class])) {
            return $_classes[$class];
            // 如果类已实例化，直接返回类对象
        }
        $_classes[$class] = new $class();
        return $_classes[$class];
    }

    public function __call($method, $args) {
        if (method_exists($this->_obj, $method)) {
            return call_user_func_array(array($this->_obj, $method), $args);
        }
        trigger_error("Method $method not found");
    }

}

abstract class CFSAbstract {

    private $_conn;
    private $_errormsg = "";
    private $_error = false;

    /**
     * Constructor
     *
     * @access public
     * @return void
     */
    public function __contsruct() {
        $this->_conn = false;
        $this->_errormsg = "";
    }

    /**
     * init function.
     *
     * Creates a connection to the service. Returns true if successful.
     *
     * @access public
     * @abstract
     * @param bool $credentials. (default: false)
     * @return boolean
     */
    abstract public function init($credentials = false);

    /**
     * uploadFile function.
     *
     * Upload a file to your service. Returns uri if successful, else returns false.
     *
     * @access public
     * @param string $filename
     * @return string URI of new file
     */
    abstract public function uploadFile($filename, $bucket = false);

    /**
     * getFileContents function.
     *
     * Gets the file contents from your service. Returns false if unsuccessful.
     *
     * @access public
     * @abstract
     * @param string $filename
     * @return string
     */
    abstract public function getFileContents($filename, $bucket = false);

    /**
     * getContentType function.
     *
     * Gets the content_type from your service for use in headers or wherever you need to know what you're dealing with. Returns false if unsuccessful.
     *
     * @access public
     * @abstract
     * @param string $filename
     * @return string
     */
    abstract public function getContentType($filename, $bucket = false);

    /**
     * lastError function.
     *
     * Returns the last error, if any
     *
     * @access public
     * @return string
     */
    public function lastError() {
        return $this->_errormsg;
    }

    public function hasError() {
        return $this->_error;
    }

    protected function _setError($message) {
        $this->_errormsg = $message;
        $this->_error = true;
    }

    public function _hash($str, $date_format='Y/m') {
        $filename = $str;

        if (($last_slash = strrpos($str, '/')) !== FALSE) {

            $path = substr($str, 0, $last_slash + 1);
            $filename = substr($str, $last_slash + 1);
        }

        //$md5 = compute_md5sum($str);
        $md5 = get_unique_name($filename);
        //$ext = get_extension($filename);
        if (empty($date_format)) $date_format = 'Y/m';
        $str = date($date_format) . '/' . substr($md5, -2, 2) . '/' . substr($md5, -4, 2) . '/' . $md5;
        return $str;
    }

    public function _hash2($id) {
        $id = intval($id);
        $hash_tree = Array();
        for ($i = 0; $i < $this->hash_opt; $i++) {
            $hash_tree[] = ceil($id / pow(32, $i)) % 32;
        }
        if (0 < sizeof($hash_tree)) {
            $hash_tree[] = $id;
            return $hash_tree;
        }
        return false;
    }

}

class CFS_local extends CFSAbstract {
    private $_upload_path = '';
    private $_has_init = false;
    protected $_date_format = '';
    
    public function init($path_prefix = '', $date_format = '') {
        if (!$this->_has_init and !empty($path_prefix)) {
            $path_prefix = trim($path_prefix, '/');
            $this->_upload_path = trim($this->_upload_path . '/' . $path_prefix, '/');
        }
        if (!empty($date_format)) {
            $this->_date_format = $date_format;
        }
        $this->_has_init = true;
    }

    public function uploadFile($filename, $bucket = false) {
        $ext = '';
        if (is_array($filename)) {
            $ext = get_extension($filename['name'], $filename['type']);
            $filename = $filename['tmp_name'];
        }

        $data = array();
        $data['path'] = $this->_upload_path . '/' . $this->_hash($filename, $this->_date_format) . $ext;
        $name = basename($data['path']);
        $data['fullpath'] = UPLOAD_PATH  . '/' . $data['path'];
        $dir = dirname($data['fullpath']);
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        if (@copy($filename, $dir . '/' . $name)) {
            $data['error'] = 0;
        } else {
            $data['error'] = 1;
        }

        return $data;
    }

    public function getFileContents($filename, $bucket = false) {
        
    }

    public function getContentType($filename, $bucket = false) {
        
    }

    protected function _isFolder($filename) {
        if (substr($filename, -1) == "/") {
            return true;
        }
        return false;
    }
}

function get_extension($filename, $type = '') {
    $pos = strrpos($filename, '.');
    if ($pos !== FALSE) {
        $ext = substr($filename, $pos);
    } else {
        $ext = '';
        switch ($type) {
            case 'image/jpeg':
                $ext = '.jpg';
                break;
            case 'image/png':
                $ext = '.png';
                break;
            case 'image/gif':
                $ext = '.gif';
                break;
            default:
                break;
        }
    }
    return $ext;
}

/**
 * Compute the MD5 checksum
 *
 * Calculate the MD5 checksum on either a PHP resource or data. The argument
 * may either be a local filename, open resource for reading, or a string.
 *
 * <b>WARNING:</b> if you are uploading a big file over a stream
 * it could get very slow to compute the md5 you probably want to
 * set the $verify parameter to False in the write() method and
 * compute yourself the md5 before if you have it.
 *
 * @param filename|obj|string $data filename, open resource, or string
 * @return string MD5 checksum hexidecimal string
 */
function compute_md5sum(&$data) {
    if (function_exists("hash_init") && is_resource($data)) {
        $ctx = hash_init('md5');
        while (!feof($data)) {
            $buffer = fgets($data, 65536);
            hash_update($ctx, $buffer);
        }
        $md5 = hash_final($ctx, false);
        rewind($data);
    } elseif ((string) is_file($data)) {
        $md5 = md5_file($data);
    } else {
        $md5 = md5($data);
    }

    return $md5;
}

function get_unique_name($filename) {
    $uniqueImagePart1 = md5(microtime());
    $uniqueImagePart2 = md5($filename);
    $unique_name = substr(md5($uniqueImagePart1 . $uniqueImagePart2), 8, 16);

    return $unique_name;
}
>>>>>>> 63b94a7e1b4167248a21999ae09c4dde81b786e9
