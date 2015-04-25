<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2014/12/26
 * Time: 9:57
 */
$statuscode = array(
'en' => array(
	"101" => "auth error",
	"102" => "The parameter is wrong, please try again",
	"1022" => "Encrypted string is wrong, please try again",
	"104" => "Login failed, please check your account or password is correct",
	"105" => "Sorry, this account has been registered, please try again",
	"106" => "This account has not been registered",
	"108" => "Your account is not binding, binding your number first, please",
	"109" => "System is busy, please try again later",
	"118" => "Sorry, this account has been registered, please try again",
	"119" => "This account has not been registered",
	"120" => "Mobile phone number is wrong, please try again",
	"121" => "Only three times a day, please try again tomorrow",
	"122" => "Verification sent successfully, please query messages",
	"123" => "Verify that is wrong, please try again",
	"125" => "Your account authentication failure",
	"126" => "Retrieve password is successful, please check back the password text messages",
	"127" => "Message sending failed, please try again later",
	"128" => "Your account is not binding mobile phone number or mobile phone number is wrong; Please contact our customer service",
	"129" => "You have not registered account information; Please register first",
	"130" => "Password change successfully",
	"131" => "Password change failed",
	"132" => "Account registration successful",
	"133" => "Account registration failed",
	"135" => "Your account has been registered or please don't frequent, please try again later",
	"136" => "Your account has been successful authentication",
	"137" => "The original password and new password cannot be the same, please enter again",
	"138" => "Thank you for your feedback, technology and customer service will be the first time we deal with your feedback",
	"139" => "Sorry, can't use Chinese as the account number",
	"140" => "Sorry, your account must be greater than the length of the six or less than 12",
    "141" => "Sorry, your account has been registered the old machine",
    "151" => "Sorry, your submission too frequently, please try again later",
	"154" => "Your version is the latest version",
	"157" => "Sorry, you have feedback, we will deal with the problem you feedback in time",
	"159" => "Your account certification successfully",
	"160" => "Sorry, your account must be for your mobile phone number",
	"161" => "successfully, please continue to improve",
	"162" => "The mobile has been added, please add other mobile or be invited to join",
	"163" => "Generate invite success",
	"164" => "Generate invite failure",
	"165" => "Attention! Only the administrator can operate the function",
	"166" => "Successful handed over to the administrator",
	"167" => "Transfer the administrator failed",
	"168" => "Invite code does not exist, please confirm whether the input is correct",
	"169" => "Focus on success",
	"170" => "Pay attention to fail",
	"171" => "Remove focus on success",
	"172" => "Cancel the attention to failure",
	"173" => "Attention! The administrator can't cancel the attention",
	"174" => "Modify the information successfully",
	"175" => "Upload the image information is wrong, please try again",
	"176" => "Upload pictures success",
	"177" => "Switching device information successfully",
	"178" => "Switching equipment failure information",
	"901" => "There is no coordinate information",
	"179" => "The mobile is illegal, please choose other mobile",
    "189" => "The phone does not exist, please choose other phone",

//		四位编码表示文本内容
	"1001" => "Your attentions,increasing the happiness.please add my account.Scan number: %s,input Pass word :%s.Download ALIGULI APP,Click the website: %s",  //老人机短信内容
	"1002" => "Let’s focus on him/her together.Scan number: %s,input invitation code:%s.Download ALIGULI APP,Click the website: %s",  //老人机短信内容
	"1003" => "Your ALIGULI code is :%s",  //老人机验证短信内容
    //		下载网址文本内容
    "2001" => "Aliguli",
    "2002" => "Focus on family care",
    "2003" => "Hardware + cloud services + APP way to serve the happy family life",
),
);
$about = array(
    'title'=>'about',
    'content'=>'
    ALIGULI is an APP developed by shenzhen uoshon communication technology Ltd, which specialized for elder.On the APP, you can know the elder situation anytime, make a family group, talk with voice message, help elder set their mobile phone in long- distance, and you can attention multi-elders in the same time, make an interesting and happy family new style.
    ',
    'contact'=>'
        联系我们<br/>
		客服热线：<span style="color:#1064f3">0755-26037756</span><br/>
		服务QQ群：105683391<br/>
		操作视频：<span style="color:#1064f3">xxxxxxxxxxx</span><br/>
		微信号：啊哩咕哩
    ',
);

$help = array(
    'content'=>'
<ul class="decimal" id="QAList">
        <li>
            <div class="title">Q:How to register Aliguli?</div>
            <div class="content">
                <dl>
                    <dd>
                        A:1、Scan QR code or search Aliguli app to set up<br/>
                        &nbsp;&nbsp;2、Aliguli official downloading and setting up

                    </dd>
                </dl>
            </div>
        </li>
        <li>
            <div class="title">Q: How to register the Aliguli ID?</div>
            <div class="content">
                <dl>
                    <dd>
                        A: Choose correct country code and mobile phone number, then set a password.
                    </dd>
                </dl>
            </div>
        </li>
        <li>
            <div class="title">Q: How to pay close attention to elder?</div>
            <div class="content">
                <dl>
                    <dd>
                        A: Add device under setting, insert the phone number of senior.
                    </dd>
                </dl>
            </div>
        </li>
        <li>
            <div class="title">How to help elder by remote assistance?</div>
            <div class="content">
                <dl>
                    <dd>
                        A：click setting, find Add Device<br/>
                        1.Can set the elder’s information ；<br/>
                        2.can set contact of elder phone；<br/>
                        3. SOS contact setting: maximum 5 numbers, can dial automatically one by one and by continuously, till the call is in action.
。

                    </dd>
                </dl>
            </div>
        </li>
        <li>
            <div class="title">Q: How to create the right of administrator transfer?</div>
            <div class="content">
                <dl>
                    <dd>
                        A: Dial setting, shift and transfer the right of administrator, choose the one you would like to change, then confirm.


                    </dd>
                </dl>
            </div>
        </li>
        <li>
            <div class="title">Q: How to invite friends attention elder？</div>
            <div class="content">
                <dl>
                    <dd>
                        A: input the phone number of the person invited, then send the invitation


                    </dd>
                </dl>
            </div>
        </li>
        <li>
            <div class="title">Q: How to use voice message?</div>
            <div class="content">
                <dl>
                    <dd>
                        A: On Aliguli homepage, dial voice tube，press on then speak, maximum speaking time 20s

                    </dd>
                </dl>
            </div>
        </li>
        <li>
            <div class="title">Q: How to switch attention person?</div>
            <div class="content">
                <dl>
                    <dd>
                        A: On the top right corner of homepage, press switch ?, then you can change any person to attention and know information of elder phone as the on-line situation, battery electric quantity, location and notice of low  electric, etc.

                    </dd>
                </dl>
            </div>
        </li>
        <li>
            <div class="title">Q: How to make a call or sent SMS on APP Aliguli?</div>
            <div class="content">
                <dl>
                    <dd>
                       A: You can find call on the left bottom, SMS on right bottom on the homepage.

                    </dd>
                </dl>
            </div>
        </li>
    </ul>',
);