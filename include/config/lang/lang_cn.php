<<<<<<< HEAD
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2014/12/26
 * Time: 9:58
 */
$statuscode = array(
	'cn' => array(
		"101" => "授权码有误,请重试",
		"102" => "参数有误,请重试",
		"1022" => "加密串有误,请重试",
		"104" => "登陆失败,请检查您的账号或密码是否正确",
		"105" => "抱歉,此账号已被使用,请用其他的用户名注册",
		"106" => "恭喜，该账号未被注册",
		"108" => "抱歉，该账号还未绑定,请先绑定您的号码",
      "109" => "系统繁忙,请稍后重试",
      "118" => "抱歉,此账号已注册,请用其他的用户名",
      "119" => "恭喜，此账号未被注册",
      "120" => "手机号码有误,请重试",
      "121" => "一天只有三次提交机会,请明天重试",
      "122" => "验证发送成功,请查询短信",
      "123" => "验证发送有误,请重试",
      "124" => "短信发送次数过多",
      "125" => "您账号认证失败",
      "126" => "找回密码成功,请查看找回密码短信",
      "127" => "短信发送失败, 请稍后重试",
      "128" => "您账号未绑定手机号码或手机号码有误；如有疑问，请联系客服",
      "129" => "账号信息未注册；请您先注册",
      "130" => "密码修改成功",
      "131" => "抱歉，密码修改失败",
      "132" => "账号注册成功",
      "133" => "抱歉，账号注册失败",
      "135" => "您账号已被注册或请不要频繁注册,请稍后重试",
      "136" => "您账号已经认证成功",
      "137" => "原始密码与新密码不能相同,请您重新输入",
        "138" => "感谢您的反馈,我们技术与客服会第一时间处理您的反馈",
      "139" => "抱歉,不能使用中文作为账号",
      "140" => "抱歉,您的账号必须大于6位或小于12位的长度",
      "141" => "抱歉,您的账号已注册过老人机",
      "151" => "抱歉,您的提交过于频繁,请稍后重试",
      "154" => "您的版本已是最新版本",
      "157" => "抱歉,您今天的反馈次数过多，请明天重试",
      "159" => "您的帐号认证成功",
      "160" => "抱歉,您的账号必须为您的手机号码",
      "161" => "设置添加成功，请您继续完善其它资料",
      "162" => "该手机已经添加过了，请添加其它手机或被邀请加入",
      "163" => "生成邀请成功",
      "164" => "抱歉，生成邀请失败",
      "165" => "请注意！只有管理员才有权限操作此功能",
      "166" => "移交管理员成功",
      "167" => "抱歉，移交管理员失败",
      "168" => "邀请码不存在，请确认是否输入正确",
      "169" => "关注成功",
      "170" => "关注失败，此号码不存在或已关注",
      "171" => "取消关注成功",
      "172" => "抱歉，取消关注失败",
      "173" => "请注意！管理员不能取消关注",
      "174" => "修改信息成功",
      "175" => "上传图片信息有误，请重试",
      "176" => "上传图片成功",
      "177" => "切换设备信息成功",
      "178" => "抱歉，切换设备信息失败",
      "901" => "抱歉，无法获取坐标信息",
      "179" => "该手机号码不正确，请重新输入",
      "189" => "该手机不存在，请选择其它手机",

//		voip提示语
		"180"=>"已激活",
		"181"=>"未激活",


//    四位编码表示短信文本内容
      "1001" => "你的关注，增添幸福额度，快来关注我吧。请关注号码：%s，点击下载：%s",  //老人机短信内容
      "1002" => "让我们一起来关注他/她吧。关注号码：%s，邀请码:%s，点击下载啊哩咕哩APP：%s",  //管理员邀请关注短信内容
      "1003" => "您的啊哩咕哩验证码是：%s",
//		下载网址文本内容
		"2001" => "啊哩咕哩",
		"2002" => "专注家庭老人看护",
		"2003" => "以硬件+云服务+APP方式服务于快乐家庭生活",
	),
=======
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2014/12/26
 * Time: 9:58
 */
$statuscode = array(
	'cn' => array(
		"101" => "授权码有误,请重试",
		"102" => "参数有误,请重试",
		"1022" => "加密串有误,请重试",
		"104" => "登陆失败,请检查您的账号或密码是否正确",
		"105" => "抱歉,此账号已被使用,请用其他的用户名注册",
		"106" => "恭喜，该账号未被注册",
		"108" => "抱歉，该账号还未绑定,请先绑定您的号码",
      "109" => "系统繁忙,请稍后重试",
      "118" => "抱歉,此账号已注册,请用其他的用户名",
      "119" => "恭喜，此账号未被注册",
      "120" => "手机号码有误,请重试",
      "121" => "一天只有三次提交机会,请明天重试",
      "122" => "验证发送成功,请查询短信",
      "123" => "验证发送有误,请重试",
      "124" => "短信发送次数过多",
      "125" => "您账号认证失败",
      "126" => "找回密码成功,请查看找回密码短信",
      "127" => "短信发送失败, 请稍后重试",
      "128" => "您账号未绑定手机号码或手机号码有误；如有疑问，请联系客服",
      "129" => "账号信息未注册；请您先注册",
      "130" => "密码修改成功",
      "131" => "抱歉，密码修改失败",
      "132" => "账号注册成功",
      "133" => "抱歉，账号注册失败",
      "135" => "您账号已被注册或请不要频繁注册,请稍后重试",
      "136" => "您账号已经认证成功",
      "137" => "原始密码与新密码不能相同,请您重新输入",
        "138" => "感谢您的反馈,我们技术与客服会第一时间处理您的反馈",
      "139" => "抱歉,不能使用中文作为账号",
      "140" => "抱歉,您的账号必须大于6位或小于12位的长度",
      "141" => "抱歉,您的账号已注册过老人机",
      "151" => "抱歉,您的提交过于频繁,请稍后重试",
      "154" => "您的版本已是最新版本",
      "157" => "抱歉,您今天的反馈次数过多，请明天重试",
      "159" => "您的帐号认证成功",
      "160" => "抱歉,您的账号必须为您的手机号码",
      "161" => "设置添加成功，请您继续完善其它资料",
      "162" => "该手机已经添加过了，请添加其它手机或被邀请加入",
      "163" => "生成邀请成功",
      "164" => "抱歉，生成邀请失败",
      "165" => "请注意！只有管理员才有权限操作此功能",
      "166" => "移交管理员成功",
      "167" => "抱歉，移交管理员失败",
      "168" => "邀请码不存在，请确认是否输入正确",
      "169" => "关注成功",
      "170" => "关注失败，此号码不存在或已关注",
      "171" => "取消关注成功",
      "172" => "抱歉，取消关注失败",
      "173" => "请注意！管理员不能取消关注",
      "174" => "修改信息成功",
      "175" => "上传图片信息有误，请重试",
      "176" => "上传图片成功",
      "177" => "切换设备信息成功",
      "178" => "抱歉，切换设备信息失败",
      "901" => "抱歉，无法获取坐标信息",
      "179" => "该手机号码不正确，请重新输入",
      "189" => "该手机不存在，请选择其它手机",

//		voip提示语
		"180"=>"已激活",
		"181"=>"未激活",


//    四位编码表示短信文本内容
      "1001" => "你的关注，增添幸福额度，快来关注我吧。请关注号码：%s，点击下载：%s",  //老人机短信内容
      "1002" => "让我们一起来关注他/她吧。关注号码：%s，邀请码:%s，点击下载啊哩咕哩APP：%s",  //管理员邀请关注短信内容
      "1003" => "您的啊哩咕哩验证码是：%s",
//		下载网址文本内容
		"2001" => "啊哩咕哩",
		"2002" => "专注家庭老人看护",
		"2003" => "以硬件+云服务+APP方式服务于快乐家庭生活",
	),
>>>>>>> 63b94a7e1b4167248a21999ae09c4dde81b786e9
);