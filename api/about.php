<!DOCTYPE HTML>
<html>

<?php
define("BASEPATH", dirname(__FILE__) . '/');
include_once BASEPATH . 'config/system.php';
include_once BASEPATH . 'config/conf.php';
include_once BASEPATH . 'config/database.php';

$input = new CI_Input();
$lang = $input->get('lang');
include '../include/config/lang/lang_'.$lang.'.php'
?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
	<meta name="format-detection" content="telephone=no"/>
	<title><?php echo $about['title']; ?>
    </title>
	<style type="text/css">
		* {
			font-family: "Microsoft YaHei", "微软雅黑", tahoma, arial, simsun, "宋体";
			font-size: 15px;
			padding: 0px;
			margin: 0px;
			color: #090909;
			line-height: 1.5;
		}

		html, body, #main {
			width: 100%;
			min-width: 300px;
			min-height: 100%;
			background-color: #fff;
		}

		#main {
			padding-bottom: 50px;
			overflow: hidden;
		}

		#search_no_result {
			padding: 22px 17px;
		}


	</style>
</head>

<body>
<div id="main">
<!--	<img src="../include/images/icon.png" style="display: none" title="pre-load arw_u.png"/>-->

	<div id="search_no_result">
		<div style="margin-bottom:123px;">
			<p style="text-align: center;margin-bottom: 23px;">
				<img alt="" src="../include/images/icon.png" style="width:90px;margin-bottom:-4px;margin-right:4px;"/>
			</p>
			<p>
                <?php echo $about['content'] ?>
			</p>

		</div>
		<?php echo $about['contact']; ?>
	</div>
</div>
<?php
//$p = preg_match("/^\d{6,24}$/", '1231222222224');
//var_dump(!preg_match("/^\d{6,24}$/", '123122g2222224'));
echo phpinfo();exit;
?>
</body>
</html>
