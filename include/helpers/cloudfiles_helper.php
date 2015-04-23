<<<<<<< HEAD
<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('uploadFile')) {
    if (!class_exists('CloudFS')) {
        //require_once(APPPATH.'helpers/cdn.php');
    }
    require_once(dirname(__FILE__) . '/cloudfiles.php');
    //require_once(BASEPATH . '/inc/flexihash.php');

    /**
     * 根据文件名上传
     *
     * @param string $local_filename
     * @param array $meta_list
     * @return remote filename
     */
    function uploadFile($filename, $path_prefix = '', $date_format = '') {

        $obj = CloudFS::factory('local');
        $obj->init($path_prefix, $date_format);
        $ret = $obj->uploadFile($filename);
        return $ret;
    }

    function deleteFile($filename) {
        return @unlink($filename);
    }

    function getFileContents($filename, $bucket = false) {
        
    }

    function downToFile($remote_filename, $local_filename) {
        
    }

    function getFileUrl($filepath) {
        $ci = &get_instance();
        $url = $ci->config->item("base_url") . $filepath;
        return $url;
    }

    function HumanizeFileSize($size) {
        $unidade = "bytes";

        if ($size > 1024) {
            $size = ($size / 1024);
            $unidade = "KB";
        }
        if ($size > 1024) {
            $size = ($size / 1024);
            $unidade = "MB";
        }
        if ($size > 1024) {
            $size = ($size / 1024);
            $unidade = "GB";
        }
        if ($size > 1024) {
            $size = ($size / 1024);
            $unidade = "TB";
        }

        $size = round($size, 0);
        return $size . " " . $unidade;
    }

=======
<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('uploadFile')) {
    if (!class_exists('CloudFS')) {
        //require_once(APPPATH.'helpers/cdn.php');
    }
    require_once(dirname(__FILE__) . '/cloudfiles.php');
    //require_once(BASEPATH . '/inc/flexihash.php');

    /**
     * 根据文件名上传
     *
     * @param string $local_filename
     * @param array $meta_list
     * @return remote filename
     */
    function uploadFile($filename, $path_prefix = '', $date_format = '') {

        $obj = CloudFS::factory('local');
        $obj->init($path_prefix, $date_format);
        $ret = $obj->uploadFile($filename);
        return $ret;
    }

    function deleteFile($filename) {
        return @unlink($filename);
    }

    function getFileContents($filename, $bucket = false) {
        
    }

    function downToFile($remote_filename, $local_filename) {
        
    }

    function getFileUrl($filepath) {
        $ci = &get_instance();
        $url = $ci->config->item("base_url") . $filepath;
        return $url;
    }

    function HumanizeFileSize($size) {
        $unidade = "bytes";

        if ($size > 1024) {
            $size = ($size / 1024);
            $unidade = "KB";
        }
        if ($size > 1024) {
            $size = ($size / 1024);
            $unidade = "MB";
        }
        if ($size > 1024) {
            $size = ($size / 1024);
            $unidade = "GB";
        }
        if ($size > 1024) {
            $size = ($size / 1024);
            $unidade = "TB";
        }

        $size = round($size, 0);
        return $size . " " . $unidade;
    }

>>>>>>> 63b94a7e1b4167248a21999ae09c4dde81b786e9
}