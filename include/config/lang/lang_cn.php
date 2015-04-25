<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2014/12/26
 * Time: 9:58
 */
$statuscode = array(
	'cn' => array(
//		"101" => "授权码有误,请重试",
		"101" => "登录超时,请重新登录",
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
);

$about = array(
    'title'=>'关于我们',
    'content'=>'Aliguli是一款由深圳优合胜通信有限公司出品的专注关爱家人，亲友的应用，能轻松实现实时定位，实时口信交流，实时关注老人动态，组建家庭关爱群，远程帮助老人设置通讯录等功能，建立欢乐和谐的新型家庭生活方式。',
    'contact'=>'
        联系我们<br/>
		客服热线：<span style="color:#1064f3">0755-26037756</span><br/>
		服务QQ群：105683391<br/>
		操作视频：<span style="color:#1064f3">xxxxxxxxxxx</span><br/>
		微信号：啊哩咕哩
    ',
);

$help = array(
    'title'=>'帮助',
    'content'=>'
    <ul class="decimal" id="QAList">
        <li>
            <div class="title">如何注册啊哩咕哩？</div>
            <div class="content">
                <dl>
                    <dd>
                        答：A、扫二维码或者搜索“啊哩咕哩”（Aliguli）进行安装<br/>
                        &nbsp;&nbsp;B、啊哩咕哩官方下载安装

                    </dd>
                </dl>
            </div>
        </li>
        <li>
            <div class="title">如何注册啊哩咕哩账号？</div>
            <div class="content">
                <dl>
                    <dd>
                        答：选择正确的国家码及正确填写手机号码，设定密码即可注册。
                    </dd>
                </dl>
            </div>
        </li>
        <li>
            <div class="title">如何关注？</div>
            <div class="content">
                <dl>
                    <dd>
                        答：在设置，添加关注，输入被关注者手机号码即可。
                    </dd>
                </dl>
            </div>
        </li>
        <li>
            <div class="title">如何实现远程协助</div>
            <div class="content">
                <dl>
                    <dd>
                        答：点击设置可以看到管理关注。<br/>
                        1、可设置被关注者的资料；<br/>
                        2、被关注者的电话本，包括名字和号码均可设置；<br/>
                        3、被关注者SOS联系人设置，可最多设置5个号码，紧急情况可连续拨打，直到通话。

                    </dd>
                </dl>
            </div>
        </li>
        <li>
            <div class="title">如何实现管理员权限转移？</div>
            <div class="content">
                <dl>
                    <dd>
                        答：点击设置，转入转移管理员权限，选择需要更换的人员，确认即可。

                    </dd>
                </dl>
            </div>
        </li>
        <li>
            <div class="title">如何邀请好友关注？</div>
            <div class="content">
                <dl>
                    <dd>
                        答：输入被邀请人手机号码，发送邀请码即可。

                    </dd>
                </dl>
            </div>
        </li>
        <li>
            <div class="title">如何使用口信？</div>
            <div class="content">
                <dl>
                    <dd>
                        答：啊哩咕哩首页，点击话筒转至口信页面，点击按住说话功能条即可，口信时长20秒。口信发送后，可实现群员共享。

                    </dd>
                </dl>
            </div>
        </li>
        <li>
            <div class="title">如何切换关注对象？</div>
            <div class="content">
                <dl>
                    <dd>
                        答：在首页的右上角，点击切换设备，可任意选择需要切换的对象，切换成功后，可获取被关注对象的相关信息，包括上线状态、手机电量、地理位置、低电通知等功能。

                    </dd>
                </dl>
            </div>
        </li>
        <li>
            <div class="title">如何实现在啊哩咕哩拨打或者发送信息？</div>
            <div class="content">
                <dl>
                    <dd>
                        答：在首页的左下角有拨打电话功能，右下角有发送短信功能，均可及时使用。

                    </dd>
                </dl>
            </div>
        </li>
    </ul>',
);