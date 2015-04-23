<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <meta name="format-detection" content="telephone=no" />
    <title>帮助</title>
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

        .opened  {
            background-size: 22px 15px;
            background-image: url("images/arw_u.png");
        }

        .content {
            display: none;
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
            /*margin-top: 7px;*/
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

    </ul>

</div>
<script type="text/javascript" src="../include/js/zepto.min.js"></script>
<script type="text/javascript">

    function showQA(elm) {
        var number = 0;
        var qaLi = null;
        if ('string' == typeof elm) {
            if (elm == '') {
                return false;
            }
                var hash = elm;
                var regExp = new RegExp('^#qa', 'gi');
                number = hash.replace(regExp, '');
                if (isNaN(number)) {
                    return false;
                }
                qaLi = $($('#QAList li').eq(number - 1));
                if (qaLi.length < 1) {
                    return false;
                }
                //alert(hash + regExp + hash.match(regExp));
            }
            var qaLi = qaLi == null ? $(elm).parent("li") : qaLi;
            var div = $(qaLi).find(".content");
            var t = $(qaLi).find(".title");
            var play = div.css('display')
            if(play == 'none'){
                div.show();
            t.bind("click",function(){div.hide();});
            }
            else{
                div.hide();
            t.bind("click",function(){div.show();});
            }
            $('#QAList li').each(function (i) {
                if (this == qaLi[0]) {
                    number = i;
                }
            });

//            $('#main').addClass('justShowQA');
//            qaLi.show();
//            div.show();
            //var newHash = '#QAList';//'#qa' + number;
            //window.location.hash = newHash;
//            window.scrollTo(0, 0);
            return true;
    }

    $(function() {

        $(".title").click(function () {showQA(this)}).each(function(n){
            this.innerHTML = (n+1) + "." + this.innerHTML;
        });
//
//        var hash = window.location.hash;
//        if(hash == '#qaMic') {
//            hash = '#qa5';
//        }
//        if(hash == '#qaCallnot') {
//            hash = '#qa7';
//        }
//        if(hash == '#qaContact') {
//            hash = '#qa19';
//        }
//        showQA(hash);

    });
</script>
</body>
</html>