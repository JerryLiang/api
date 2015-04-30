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
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
	<meta name="format-detection" content="telephone=no" />
	<title><?php echo $declare['title']; ?></title>
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

		ul {
			list-style: none outside none;
			/*list-style-type: decimal;*/
			width: 100%;
		}

		.title {
			white-space:nowrap;
			text-overflow:ellipsis;
			overflow: hidden;
			display: block;
			/*font-weight: bold;
			background-color: #f1f1f1;*/
			padding: 10px 10px;
			padding-right: 25px;
			border-bottom: #e2e2e2 solid 1px;
			/*background-image: url("images/arw_r.png");*/
			background-position: right center;
			background-repeat: no-repeat;
			background-size: 18px 15px;
		}
		.content {
			/*display: none;*/
			color: #737373;
			background-color: #fff;
			margin: 0px;
		}

		.content,.content dl,.content dt,.content dd {
			margin: 0px;
			padding: 0px;
		}

		.content dl {
			padding: 22px 25px;
			border-bottom: #d8d8d8 solid 1px;
		}

		.content dt {
			background-image: url("images/help-icon.png");
			background-position: top left;
			background-repeat: no-repeat;
			padding-left: 10px;
		}

		.content dd {
			color: #000;
		}

		.content img {
			display: block;
			max-width: 275px;
			margin: 22px auto 20px auto;
		}

		.justShowQA dl{
			border: none;
		}

		.justShowQA .title{
			background-color: #ebebeb;
			background-image: none;
			padding-right: 10px;
			white-space:normal;
		}
	</style>
</head>

<body>
<div id="main">
    <?php echo $declare['content']; ?>
</div>
</body>
</html>