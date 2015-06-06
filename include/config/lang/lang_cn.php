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
      "141" => "抱歉,您的账号已注册过啊哩咕哩",
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
     <li>
            <div class="title">如何使用电子围栏？</div>
            <div class="content">
                <dl>
                    <dd>
                        答：在啊哩咕哩首页，点击电子围栏进入围栏设置界面，点击电子围栏开关打开电子围栏功能，接着设置围栏范围最小为‘1公里’最大为‘10公里’。围栏设置后，如被关注者超出所设置的范围，
                            您可以收到警报提醒。
                    </dd>
                </dl>
            </div>
        </li>
    </ul>',
);

$declare = array(
    'title'=>'',
    'content'=>'	<ul class="decimal" id="QAList">
		<li>
			<div class="title">1. 特别提示</div>
			<div class="content">
				<dl>
					<dd>
						1.1
						<br/>
						深圳优合胜通信技术有限公司同意按照本协议的规定及其不时发布的操作规则提供基于互联网以及移动网的啊哩咕哩平台服务（以下称"啊哩咕哩"），为获得啊哩咕哩服务，啊哩咕哩使用人（以下称"用户"）应当基于了解本协议全部内容，在独立思考的基础上认可、同意本协议的全部条款并按照页面上的提示完成全部的注册程序。用户在进行注册程序过程中点击"同意" 按钮即表示用户完全接受《啊哩咕哩服务使用协议》、《啊哩咕哩使用协议》、及优合胜公司公示的各项规则、规范。
						<br/>
						1.2
						<br/>
						用户注册成功后，优合胜公司将为用户基于啊哩咕哩使用的客观需要而在申请、注册啊哩咕哩时，按照注册要求提供的帐号开通啊哩咕哩，用户有权在优合胜公司为其开通、并同意向其提供服务的基础上使用啊哩咕哩服务。该用户帐号和密码由用户负责保管；用户使用啊哩咕哩过程中，须对自身使用啊哩咕哩的行为，对任何由用户通过啊哩咕哩服务发布、公开的信息，及对由此产生的任何后果承担全部责任。
						<br/>
						1.3
						<br/>
						为提高用户的啊哩咕哩使用感受和满意度，用户同意优合胜公司将基于用户的操作行为对用户数据进行调查研究和分析，从而进一步优化啊哩咕哩。

					</dd>
				</dl>
			</div>
		</li>
		<li>
			<div class="title">2. 服务内容</div>
			<div class="content">
				<dl>
					<dd>
						2.1
						<br/>
						啊哩咕哩的具体内容由优合胜公司根据实际情况提供，包括但不限于授权用户通过其帐号，使用啊哩咕哩发布观点、评论、图片、视频、转发链接等，优合胜公司有权对其提供的服务或产品形态进行升级或其他调整，并将及时更新页面/告知用户。
						<br/>
						2.2
						<br/>
						优合胜公司现阶段提供的服务为免费项目。
						<br/>
						2.3
						<br/>
						优合胜公司仅提供与啊哩咕哩相关的技术服务等，除此之外与相关网络服务有关的设备（如个人电脑、手机、及其他与接入互联网或移动网有关的装置）及所需的费用（如为接入互联网而支付的电话费及上网费、为使用移动网而支付的手机费）均应由用户自行负担。
						<br/>
						2.4
						<br/>
						用户在使用啊哩咕哩的过程中，因基站的原因，存在地理位置定位距离偏差的问题，视为正常情况，优合胜公司不承担责任。
						<br/>
						2.5
						<br/>
						用户在啊哩咕哩上使用口信的过程中，因网络问题，有时无法及时接收口信内容均视为正常情况，后果由用户自行负担。
						<br/>
						2.6
						<br/>
						用户在为关注设备设置SOS通讯录成功后，如遇在求救过程中，无法正常拨打电话或发送短信，这与啊哩咕哩平台没有直接关联，优合胜公司不承担责任。
						<br/>
						2.7
						<br/>
						用户在使用啊哩咕哩时，注意隐私保护，防止恶意添加好友。如有恶性事件发生均由用户自行承担。

					</dd>
				</dl>
			</div>
		</li>
		<li>
			<div class="title">3. 服务变更、中断或终止</div>
			<div class="content">
				<dl>
					<dd>
						3.1
						<br/>鉴于网络服务的特殊性（包括但不限于服务器的稳定性问题、恶意的网络攻击等行为的存在及其他优合胜公司无法控制的情形），用户同意优合胜公司有权随时中断或终止部分或全部的啊哩咕哩，若发生该等中断或中止啊哩咕哩的情形，优合胜公司将尽可能及时通过网页公告、系统通知、私信、短信提醒或其他合理方式通知受到影响的用户。
						<br/>3.2
						<br/>优合胜公司需要定期或不定期地对提供啊哩咕哩的平台（如互联网网站、移动网络等）或相关的设备进行检修或者维护，如因此类情况而造成服务在合理时间内的中断，优合胜公司无需为此承担任何责任，但优合胜公司应尽可能事先进行通告。
						<br/>3.3
						<br/>如发生下列任何一种情形，优合胜公司有权随时中断或终止向用户提供本协议项下的啊哩咕哩而无需对用户或任何第三方承担任何责任：
						<br/>3.3.1 用户提供的个人资料不真实；
						<br/>3.3.2 用户违反法律法规国家政策或本协议中规定的使用规则；
						<br/>3.4
						<br/>如用户在申请开通啊哩咕哩后在任何连续90日内未实际使用，则优合胜公司有权选择采取以下任何一种方式进行处理：
						<br/>3.4.1 回收用户昵称；
						<br/>3.4.2 停止为该用户提供啊哩咕哩。
						<br/>3.5
						<br/>用户选择将啊哩咕哩帐号与啊哩咕哩合作的第三方帐号进行绑定的，除用户自行解除绑定关系外，如发生下列任何一种情形，用户已绑定的第三方帐号也有可能被解除绑定而优合胜公司无需对用户或任何第三方承担任何责任：
						<br/>3.5.1 用户违反法律法规国家政策、本协议或《啊哩咕哩服务使用协议》 的；
						<br/>3.5.2 用户违反第三方帐户用户协议或其相关规定的；
						<br/>3.5.3 其他需要解除绑定的。

					</dd>
				</dl>
			</div>
		</li>
		<li>
			<div class="title">4. 使用规则</div>
			<div class="content">
				<dl>
					<dd>
						4.1
						<br/>用户注册啊哩咕哩帐号，制作、发布、传播信息内容的，应当使用真实身份信息，不得以虚假、冒用的居民身份信息、企业注册信息、组织机构代码信息进行注册。
						<br/>4.2
						<br/>如用户违反前述4.1条之约定，依据相关法律、法规及国家政策要求，优合胜公司有权随时中止或终止用户对啊哩咕哩的使用且不承担违约责任。
						<br/>4.3
						<br/>优合胜公司将建立健全用户信息安全管理制度、落实技术安全防控措施。优合胜公司将对用户使用啊哩咕哩过程中涉及的用户隐私内容加以保护。
						<br/>4.4
						<br/>用户在使用啊哩咕哩时，优合胜公司有权基于安全运营、社会公共安全的需要或国家政策的要求，要求用户提供准确的个人资料，如用户提供的个人资料有任何变动，导致用户的实际情况与用户提交给优合胜公司的信息不一致的，用户应及时更新。
						<br/>4.5
						<br/>由于啊哩咕哩的存在前提是用户在申请开通啊哩咕哩的过程中所提供的帐号，则用户不应将其帐号、密码转让或出借予他人使用。如用户发现其帐号或啊哩咕哩遭他人非法使用，应立即通知优合胜公司。因黑客行为或用户的保管疏忽导致帐号、密码及啊哩咕哩遭他人非法使用，优合胜公司有权拒绝承担任何责任。
						<br/>4.6
						<br/>用户同意优合胜公司在提供啊哩咕哩过程中以各种方式投放各种商业性广告或其他任何类型的商业信息（包括但不限于在优合胜公司网站的任何页面上投放广告），并且，用户同意接受优合胜公司通过电子邮件或其他方式向用户发送商品促销或其他相关商业信息。
						<br/>4.7
						<br/>对于用户通过啊哩咕哩公开发布的任何内容，用户同意优合胜公司在全世界范围内具有免费的、永久性的、不可撤销的、非独家的和完全再许可的权利和许可，以使用、复制、修改、改编、出版、翻译、据以创作衍生作品、传播、表演和展示此等内容（整体或部分），和/或将此等内容编入当前已知的或以后开发的其他任何形 式的作品、媒体或技术中。
						<br/>4.8
						<br/>用户在使用啊哩咕哩的过程中应文明发言，并依法尊重其它用户的人格权与身份权等人身权利，共同建立和谐、文明、礼貌的网络社交环境。
						<br/>4.9
						<br/>用户在使用啊哩咕哩过程中，必须遵循以下原则：
						<br/>4.9.1 不得违反中华人民共和国法律法规及相关国际条约或规则；
						<br/>4.9.2 不得违反与网络服务、啊哩咕哩有关的网络协议、规定、程序及行业规则；
						<br/>4.9.3 不得违反法律法规、社会主义制度、国家利益、公民合法权益、公共秩序、社会道德风尚和信息真实性等“七条底线”要求；
						<br/>4.9.4 不得进行任何可能对互联网或移动网正常运转造成不利影响的行为；
						<br/>4.9.5 不得上传、展示或传播任何不实虚假、冒充性的、骚扰性的、中伤性的、攻击性的、辱骂性的、恐吓性的、种族歧视性的、诽谤诋毁、泄露隐私、成人情色、恶意抄袭的或其他任何非法的信息资料；
						<br/>4.9.6 不得以任何方式侵犯其他任何人依法享有的专利权、著作权、商标权等知识产权，或姓名权、名称权、名誉权、荣誉权、肖像权、隐私权等人身权益，或其他任何合法权益；
						<br/>4.9.7 不得以任何形式侵犯啊哩咕哩、优合胜公司的权利和/或利益或作出任何不利于啊哩咕哩、优合胜公司的行为；
						<br/>4.9.8 不得从事其他任何影响啊哩咕哩平台正常运营、破坏啊哩咕哩平台经营模式或其他有害啊哩咕哩平台生态的行为。
						<br/>4.9.9 不得为其他任何非法目的而使用啊哩咕哩。
						<br/>4.10
						<br/>优合胜公司针对某些特定的啊哩咕哩的使用通过各种方式（包括但不限于网页公告、系统通知、私信、短信提醒等）作出的任何声明、通知、警示等内容视为本协议的一部分，用户如使用该等啊哩咕哩，视为用户同意该等声明、通知、警示的内容。
						<br/>4.11
						<br/>优合胜公司有权对用户使用啊哩咕哩的行为及信息进行审查、监督及处理，包括但不限于用户信息（账号信息、个人信息等）、发布内容（位置、文字、图片、音频、视频、商标、专利、出版物等）、用户行为（构建关系、@信息、评论、私信、参与话题、参与活动、营销信息发布、举报投诉等）等范畴。如优合胜公司发现、或收到第三方举报或投诉用户在使用啊哩咕哩时违反本协议第四条使用规则相关规定，优合胜公司或其授权的主体有权依据其合理判断要求用户：
						<br/>a. 限期改正;
						<br/>b. 不经通知直接采取一切必要措施以减轻或消除用户不当行为造成的影响，并将尽可能在处理之后对用户进行通知。上述必要措施包括但不限于更改、屏蔽或删除相关内容，警告违规账号，限制或禁止违规账号部分或全部功能，暂停、终止、注销用户使用啊哩咕哩的权利等。
						<br/>4.12
						<br/>如用户在使用啊哩咕哩的过程中遇到其它用户上传违法侵权等内容，可直接点击"举报"按键进行举报，相关人员会尽快核实并进行处理； 如涉及姓名权、名称权、名誉权、荣誉权、肖像权、隐私权等人身权益纠纷的处理，根据《最高人民法院关于审理利用信息网络侵害人身权益民事纠纷案件适用法律若干问题的规定》，请参照站方有关公告所公示的方式进行处理； 如用户认为上述方法无法解决遇到的问题、或用户觉得有必要向司法行政机关寻求帮助的，请用户尽快向相关机关反馈，优合胜公司将依法配合司法机关的调查取证工作。
					</dd>
				</dl>
			</div>
		</li>
		<li>
			<div class="title">5. 知识产权</div>
			<div class="content">
				<dl>
					<dd>
						5.1
						<br/>优合胜公司是啊哩咕哩平台的所有权及知识产权权利人。
						<br/>5.2
						<br/>优合胜公司是啊哩咕哩平台产品的所有权及知识产权权利人。上述啊哩咕哩产品指的是优合胜公司、或其关联公司、或其授权主体等通过啊哩咕哩平台为用户提供的包括但不限于信息发布分享、关系链拓展、便捷辅助工具、平台应用程序、公众开放平台等功能、软件、服务等。
						<br/>5.3
						<br/>优合胜公司是啊哩咕哩平台及啊哩咕哩产品中所有信息内容的所有权及知识产权权利人。前述信息内容包括但不限于程序代码、界面设计、版面框架、数据资料、账号、文字、图片、图形、图表、音频、视频等，除按照法律法规规定应由相关权利人享有权利的内容以外。
						<br/>5.4
						<br/>用户在使用啊哩咕哩平台的过程中，可能会使用到由第三方针对啊哩咕哩开发的在啊哩咕哩平台运行的功能、软件或服务，用户除遵守本协议相关规定以外，还应遵守第三方相关规定，并尊重第三方权利人对其功能、软件、服务及其所包含内容的相关权利。
						<br/>5.5
						<br/>鉴于以上，用户理解并同意：
						<br/>5.5.1 未经优合胜公司及相关权利人同意，用户不得对上述功能、软件、服务进行反向工程 （reverse engineer）、反向编译（decompile）或反汇编（disassemble）等；同时，不得将上述内容或资料在任何媒体直接或间接发布、播放、出于播放或发布目的而改写或再发行，或者用于其他任何目的。
						<br/>5.5.2 在尽商业上的合理努力的前提下，优合胜公司并不就上述功能、软件、服务及其所包含内容的延误、不准确、错误、遗漏或由此产生的任何损害，以任何形式向用户或任何第三方承担任何责任；
						<br/>5.5.3 优合胜公司并不对上述任何由第三方提供的功能、软件、服务或内容进行任何保证性的、或连带性的承诺或担保，由此产生的任何纠纷、争议或损害，由用户与第三方自行解决，优合胜公司不承担任何责任；
						<br/>5.5.4 为更好地维护啊哩咕哩生态，优合胜公司保留在任何时间内以任何方式处置上述由优合胜公司享受所有权及知识产权的产品或内容，包括但不限于修订、屏蔽、删除或其他任何法律法规允许的处置方式。

					</dd>
				</dl>
			</div>
		</li>
		<li>
			<div class="title">6. 隐私保护</div>
			<div class="content">
				<dl>
					<dd>
						6.1
						<br/>本协议所指的“隐私”包括《电信和互联网用户个人信息保护规定》第4条关于个人信息、《最高人民法院关于审理利用信息网络侵害人身权益民事纠纷案件适用法律若干问题的规定》第12条关于个人隐私、以及未来不时制定或修订的法律法规中明确规定的隐私应包括的内容。
						<br/>6.2
						<br/>保护用户隐私和其他个人信息是优合胜公司的一项基本政策，优合胜公司保证不会将单个用户的注册资料及用户在使用啊哩咕哩时存储在优合胜公司的非公开内容用于任何非法的用途，且保证将单个用户的注册资料进行商业上的利用时应事先获得用户的同意，但下列情况除外：
						<br/>6.2.1 事先获得用户的明确授权；
						<br/>6.2.2 为维护社会公共利益；
						<br/>6.2.3 学校、科研机构等基于公共利益为学术研究或统计的目的，经自然人用户书面同意，且公开方式不足以识别特定自然人；
						<br/>6.2.4 用户自行在网络上公开的信息或其他已合法公开的个人信息；
						<br/>6.2.5 以合法渠道获取的个人信息；
						<br/>6.2.6 用户侵害啊哩咕哩或优合胜公司合法权益，为维护前述合法权益且在必要范围内；
						<br/>6.2.7 根据相关政府主管部门的要求；
						<br/>6.2.8 根据相关法律法规或政策的要求；
						<br/>6.2.9 其他必要情况。
						<br/>6.3
						<br/>为提升啊哩咕哩的质量，优合胜公司可能会与第三方合作共同向用户提供相关的啊哩咕哩，此类合作可能需要包括但不限于啊哩咕哩用户数据与第三方用户数据的互通。在此情况下，用户知晓并同意如该第三方同意承担与优合胜公司同等的保护用户隐私的责任，则优合胜公司有权将用户的注册资料等提供给该第三方，并与第三方约定用户数据仅为双方合作的啊哩咕哩之目的使用；并且，优合胜公司将对该等第三方使用用户数据的行为进行监督和管理，尽一切合理努力保护用户个人信息的安全性。

					</dd>
				</dl>
			</div>
		</li>
		<li>
			<div class="title">7. 免责声明</div>
			<div class="content">
				<dl>
					<dd>
						7.1
						<br/>用户在使用啊哩咕哩的过程中应遵守国家法律法规及政策规定，因其使用啊哩咕哩而产生的行为后果由用户自行承担。
						<br/>7.2
						<br/>通过啊哩咕哩发布的任何信息，及通过啊哩咕哩传递的任何观点不代表优合胜公司之立场，优合胜公司亦不对其完整性、真实性、准确性或可靠性负责。用户对于可能会接触到的非法的、非道德的、错误的或存在其他失宜之处的信息，及被错误归类或是带有欺骗性的发布内容，应自行做出判断。在任何情况下，对于任何信息，包括但不仅限于其发生的任何错误或遗漏；或是由于使用通过啊哩咕哩发布、私信、传达、其他方式所释出的或在别处传播的信息，而造成的任何损失或伤害，应由相关行为主体承担全部责任。
						<br/>7.3
						<br/>鉴于外部链接指向的网页内容非优合胜公司实际控制的，因此优合胜公司无法保证为向用户提供便利而设置的外部链接的准确性和完整性。
						<br/>7.4
						<br/>对于因不可抗力或优合胜公司不能控制的原因造成的啊哩咕哩中断或其它缺陷，优合胜公司不承担任何责任，但将尽力减少因此而给用户造成的损失和影响。
						<br/>7.5
						<br/>用户同意，对于优合胜公司向用户提供的下列产品或者服务的质量缺陷本身及其引发的任何损失，优合胜公司无需承担任何责任：
						<br/>7.5.1 优合胜公司向用户免费提供的啊哩咕哩；
						<br/>7.5.2 优合胜公司向用户赠送的任何产品或者服务；
						<br/>7.6
						<br/>用户知悉并同意，优合胜公司可能会与第三方合作向用户提供产品（包括但不限于游戏、第三方应用等）并由第三方向用户提供该产品的升级、维护、客服等后续工作，由该等第三方对该产品的质量问题或其本身的原因导致的一切纠纷或用户损失承担责任，用户在此同意将向该第三方主张与此有关的一切权利和损失。
						<br/>7.7
						<br/>啊哩咕哩平台上提供的产品或服务（包括但不限于游戏物品及道具），如未标明使用期限、或者其标明的使用期限为“永久”、“无限期”或“无限制”的，则其使用期限为自用户获得该游戏物品或道具之日起至该产品或服务在微博下线之日为止。
					</dd>
				</dl>
			</div>
		</li>

		<li>
			<div class="title">8. 违约赔偿</div>
			<div class="content">
				<dl>
					<dd>
						8.1
						<br/>如因优合胜公司违反有关法律、法规或本协议项下的任何条款而给用户造成损失，优合胜公司同意承担由此造成的损害赔偿责任。
						<br/>8.2
						<br/>用户同意保障和维护优合胜公司及其他用户的利益，如因用户违反有关法律、法规或本协议项下的任何条款而给优合胜公司或任何其他第三人造成损失，用户同意承担由此造成的损害赔偿责任。
					</dd>
				</dl>
			</div>
		</li>
		<li>
			<div class="title">9. 协议修改</div>
			<div class="content">
				<dl>
					<dd>
						9.1
						<br/>优合胜公司有权随时修改本协议的任何条款，一旦本协议的内容发生变动，优合胜公司将会在啊哩咕哩网站上公布修改之后的协议内容，若用户不同意上述修改，则可以选择停止使用啊哩咕哩。优合胜公司也可选择通过其他适当方式（比如系统通知）向用户通知修改内容。
						<br/>9.2
						<br/>如果不同意优合胜公司对本协议相关条款所做的修改，用户有权停止使用啊哩咕哩。如果用户继续使用啊哩咕哩，则视为用户接受优合胜公司对本协议相关条款所做的修改。

					</dd>
				</dl>
			</div>
		</li>
		<li>
			<div class="title">10. 通知送达</div>
			<div class="content">
				<dl>
					<dd>
						10.1
						<br/>本协议项下优合胜公司对于用户所有的通知均可通过网页公告、电子邮件、系统通知、啊哩咕哩管理帐号主动联系、私信、手机短信或常规的信件传送等方式进行；该等通知于发送之日视为已送达收件人。
						<br/>10.2
						<br/>用户对于优合胜公司的通知应当通过优合胜公司对外正式公布的通信地址、传真号码、电子邮件地址等联系信息进行送达。
					</dd>
				</dl>
			</div>
		</li>
		<li>
			<div class="title">11. 法律适用</div>
			<div class="content">
				<dl>
					<dd>
						11.1
						<br/>啊哩咕哩依据并贯彻中华人民共和国法律法规、政策规章及司法解释之要求，包括但不限于《全国人民代表大会常务委员会关于加强网络信息保护的决定》、《最高人民法院最高人民检察院适用法律若干问题的解释》等文件精神，制定《 啊哩咕哩使用协议 》。
						<br/>11.2
						<br/>本协议的订立、执行和解释及争议的解决均应适用中国法律并受中国法院管辖。
						<br/>11.3
						<br/>如双方就本协议内容或其执行发生任何争议，双方应尽量友好协商解决；协商不成时，任何一方均可向优合胜公司所在地的人民法院提起诉讼。

					</dd>
				</dl>
			</div>
		</li>
		<li>
			<div class="title">12. 其他规定</div>
			<div class="content">
				<dl>
					<dd>
						12.1
						<br/>本协议构成双方对本协议之约定事项及其他有关事宜的完整协议，除本协议规定的之外，未赋予本协议各方其他权利。
						<br/>12.2
						<br/>如本协议中的任何条款无论因何种原因完全或部分无效或不具有执行力，本协议的其余条款仍应有效并且有约束力。
						<br/>12.3
						<br/>本协议中的标题仅为方便而设，在解释本协议时应被忽略。
					</dd>
				</dl>
			</div>
		</li>

	</ul>'
);