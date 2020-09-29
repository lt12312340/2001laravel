<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE">
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
	<title>个人注册</title>


    <link rel="stylesheet" type="text/css" href="/static/index/css/webbase.css" />
    <link rel="stylesheet" type="text/css" href="/static/index/css/pages-register.css" />
</head>

<body>
	<div class="register py-container ">
		<!--head-->
		<div class="logoArea">
			<a href="" class="logo"></a>
		</div>
		<!--register-->
		<div class="registerArea">
			<h3>注册新用户<span class="go">我有账号，去<a href="{{url('/login')}}" target="_blank">登陆</a></span></h3>
			<div class="info">
			<font color=red>{{session('msg')}}</font>
				<form class="sui-form form-horizontal" action="{{url('/registerdo')}}" method="post">
					<div class="control-group">
						<label class="control-label">用户名：</label>
						<div class="controls">
							<input type="text" name="user_name" placeholder="请输入你的用户名" class="input-xfat input-xlarge">
						</div>
					</div>
					<div class="control-group">
						<label for="inputPassword" class="control-label">登录密码：</label>
						<div class="controls">
							<input type="password" name="user_pwd" placeholder="设置登录密码" class="input-xfat input-xlarge">
						</div>
					</div>
					<div class="control-group">
						<label for="inputPassword" class="control-label">确认密码：</label>
						<div class="controls">
							<input type="password" name="repassword" placeholder="再次确认密码" class="input-xfat input-xlarge">
						</div>
					</div>
					
					<div class="control-group">
						<label class="control-label">手机或邮箱：</label>
						<div class="controls">
							<input type="text" name="tel_email" placeholder="请输入你的手机号或邮箱" class="input-xfat input-xlarge">
						</div>
					</div>
					<div class="control-group">
						<label for="inputPassword" class="control-label">短信验证码：</label>
						<div class="controls">
							<input type="text" name="code" placeholder="短信验证码" class="input-xfat input-xlarge">  <a href="#" class="sendcode">获取短信验证码</a>
						</div>
					</div>
					
					<div class="control-group">
						<label for="inputPassword" class="control-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
						<div class="controls">
							<input name="m1" type="checkbox" value="2" checked=""><span>同意协议并注册《品优购用户协议》</span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label"></label>
						<div class="controls btn-reg">
							<button id="button" class="sui-btn btn-block btn-xlarge btn-danger" href="home.html" target="_blank">完成注册</button>
						</div>
					</div>
				</form>
				<div class="clearfix"></div>
			</div>
		</div>
		<!--foot-->
		<div class="py-container copyright">
			<ul>
				<li>关于我们</li>
				<li>联系我们</li>
				<li>联系客服</li>
				<li>商家入驻</li>
				<li>营销中心</li>
				<li>手机品优购</li>
				<li>销售联盟</li>
				<li>品优购社区</li>
			</ul>
			<div class="address">地址：北京市昌平区建材城西路金燕龙办公楼一层 邮编：100096 电话：400-618-4000 传真：010-82935100</div>
			<div class="beian">京ICP备08001421号京公网安备110108007702
			</div>
		</div>
	</div>


<script type="text/javascript" src="/static/index/js/plugins/jquery/jquery.min.js"></script>
<script type="text/javascript" src="/static/index/js/plugins/jquery.easing/jquery.easing.min.js"></script>
<script type="text/javascript" src="/static/index/js/plugins/sui/sui.min.js"></script>
<script type="text/javascript" src="/static/index/js/plugins/jquery-placeholder/jquery.placeholder.min.js"></script>
<script type="text/javascript" src="/static/index/js/pages/register.js"></script>

<script>
	$('.sendcode').click(function(){
		var tel_email = $('input[name="tel_email"]').val();
		// alert(tel_email);
		// return;
		$.get('/sendcode',{tel_email:tel_email},function(res){
			if(res.code=='00000'){
				alert(res.msg);
			}
		},'json')
	})

	$('#button').click(function(){
		var user_name = $('input[name="user_name"]').val();
		if(!user_name){
			alert("用户名必填");
			return false;
		}

		var user_pwd= $('input[name="user_pwd"]').val();
		var reg=/^[a-zA-Z\d]{6,18}$/;
		if(!reg.test(user_pwd)){
			alert("密码为6-18位数字或字母");
			return false;
		}

		var repassword = $('input[name="repassword"]').val();
		if(user_pwd!==repassword){
			alert("两次密码不一致");
			return false;
		}

		var tel_email = $('input[name="tel_email"]').val();
		if(!tel_email){
			alert("手机号或邮箱必填");
			return false;
		}

		var code = $('input[name="code"]').val();
		if(!code){
			alert('验证码必填');
			return false;
		}
		$('form').submit();
	})

</script>

</body>

</html>