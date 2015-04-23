<<<<<<< HEAD
<?php

/**
 * 创建任意尺寸缩略图
 * @author Justin
 * @copyright (c) 2012, iicall
 * 
 * 
 */
class thumbnail {

    function __construct() {
        
    }

    /*
     *  创建缩略图主函数
     * 
     */

    function ImageResize($source, $toW = 0, $toH = 0, $ratio, $thumb_name) {

        list($srcW, $srcH, $imageType) = getimagesize($source); //第二步
        if ($toW == 0) {
            $toW == $srcW;
        }
        if ($toH == 0) {
            $toH = $srcH;
        }
        if ($toW > $srcW && $toH > $srcH) {
            $toW = $srcW;
            $toH = $srcH;
        }


        $toWH = $toW / $toH;
        $srcWH = $srcW / $srcH;
        if ($toWH <= $srcWH) {
            $ftoW = $toW;
            $ftoH = $ftoW * ($srcH / $srcW);
        } else {
            $ftoH = $toH;
            $ftoW = $ftoH * ($srcW / $srcH);
        }
        if ($ratio == '1') {
            $ftoW = $toW;
            $ftoH = $toH;
        }

        $imageType = image_type_to_mime_type($imageType);
        $original = $this->getoriginal($imageType, $source);
        imagesavealpha($original, true);
        $thumb = imagecreatetruecolor($ftoW, $ftoH); //创建画板
        imagealphablending($thumb, false);   //处理png,gif非透明
        imagesavealpha($thumb, true);
        imagecopyresampled($thumb, $original, 0, 0, 0, 0, $ftoW, $ftoH, $srcW, $srcH); //复制图片到画板
        switch ($imageType) {
            case "image/gif":
                imagegif($thumb, $thumb_name);
                break;
            case "image/pjpeg":
            case "image/jpeg":
            case "image/jpg":
                imagejpeg($thumb, $thumb_name, 100);
                break;
            case "image/png":
            case "image/x-png":
                imagepng($thumb, $thumb_name);
                break;
        }
        return '1';
    }

    /*
     *  获取源图片资源
     * 
     */

    function getoriginal($imageType, $source) {
        switch ($imageType) {
            case "image/gif":
                $original = imagecreatefromgif($source);
                break;
            case "image/pjpeg":
            case "image/jpeg":
            case "image/jpg":
                $original = imagecreatefromjpeg($source);
                break;
            case "image/png":
            case "image/x-png":
                $original = imagecreatefrompng($source);
                break;
        }

        return $original;
    }

}

=======
<?php

/**
 * 创建任意尺寸缩略图
 * @author Justin
 * @copyright (c) 2012, iicall
 * 
 * 
 */
class thumbnail {

    function __construct() {
        
    }

    /*
     *  创建缩略图主函数
     * 
     */

    function ImageResize($source, $toW = 0, $toH = 0, $ratio, $thumb_name) {

        list($srcW, $srcH, $imageType) = getimagesize($source); //第二步
        if ($toW == 0) {
            $toW == $srcW;
        }
        if ($toH == 0) {
            $toH = $srcH;
        }
        if ($toW > $srcW && $toH > $srcH) {
            $toW = $srcW;
            $toH = $srcH;
        }


        $toWH = $toW / $toH;
        $srcWH = $srcW / $srcH;
        if ($toWH <= $srcWH) {
            $ftoW = $toW;
            $ftoH = $ftoW * ($srcH / $srcW);
        } else {
            $ftoH = $toH;
            $ftoW = $ftoH * ($srcW / $srcH);
        }
        if ($ratio == '1') {
            $ftoW = $toW;
            $ftoH = $toH;
        }

        $imageType = image_type_to_mime_type($imageType);
        $original = $this->getoriginal($imageType, $source);
        imagesavealpha($original, true);
        $thumb = imagecreatetruecolor($ftoW, $ftoH); //创建画板
        imagealphablending($thumb, false);   //处理png,gif非透明
        imagesavealpha($thumb, true);
        imagecopyresampled($thumb, $original, 0, 0, 0, 0, $ftoW, $ftoH, $srcW, $srcH); //复制图片到画板
        switch ($imageType) {
            case "image/gif":
                imagegif($thumb, $thumb_name);
                break;
            case "image/pjpeg":
            case "image/jpeg":
            case "image/jpg":
                imagejpeg($thumb, $thumb_name, 100);
                break;
            case "image/png":
            case "image/x-png":
                imagepng($thumb, $thumb_name);
                break;
        }
        return '1';
    }

    /*
     *  获取源图片资源
     * 
     */

    function getoriginal($imageType, $source) {
        switch ($imageType) {
            case "image/gif":
                $original = imagecreatefromgif($source);
                break;
            case "image/pjpeg":
            case "image/jpeg":
            case "image/jpg":
                $original = imagecreatefromjpeg($source);
                break;
            case "image/png":
            case "image/x-png":
                $original = imagecreatefrompng($source);
                break;
        }

        return $original;
    }

}

>>>>>>> 63b94a7e1b4167248a21999ae09c4dde81b786e9
?>