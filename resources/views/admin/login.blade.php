<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>管理员登录-固定资产后台管理系统-1.0</title>
	<meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Cache-Control" content="no-siteapp" />

    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="/static/login/css/font.css">
	<link rel="stylesheet" href="/static/login/css/weadmin.css">
    <script src="lib/layui/layui.js" charset="utf-8"></script>
	<script src="static/js/jquery-1.12.4.min.js"></script>
</head>
<body class="login-bg">
    
    <div class="login">
        <div class="message">Fixed Assets-管理登录</div>
        <div id="darkbannerwrap"></div>
        
        <form class="layui-form" action="{{url('/logindo')}}" post="post">
        
            <input name="admin_name"id='username'  placeholder="用户名"  type="text" lay-verify="required" class="layui-input" >
            <font color=red>{{session('msg')}}</font>
            <hr class="hr15">
			<input name="admin_pwd" id="password" lay-verify="required" placeholder="密码"  type="password" class="layui-input">
			<font color=red>{{session('mng')}}</font>
			<hr class="hr15">
			<input type="text" id="input1" name="captcha" placeholder="验证码" />
			<p class=""><img  id="img" src="{{route('getCaptcha')}}" alt=""><a href="javascript:;"  id="code" class="aaa"><u>换一张</u></a>
			<p><font color=red>{{session('mag')}}{{session('mbg')}}</font></p>
            <input class="loginin" value="登录" lay-submit lay-filter="login" style="width:100%;" type="submit" >
            <hr class="hr20" >

        </form>
    </div>
	<script src="static/js/path.js"></script>
	<script src="/static/layui/jquery.js"></script>
<script type="text/javascript">
	/*function login(){
		var name=$("#username").val();
		var pwd=$("#password").val();
			$.ajax({
				type:'get',
				url: 'http://192.168.1.88:8082/user/login',
				data:  {
					account:name,
					password:pwd
				},
				dataType: 'json',
				success:function(data){
					alert("success",data)
					location.href='./index.html'
					 return false
					},
					error:function(data){
						alert(data.code)
						location.href='./404.html'
						 return false
					},
			} );
	}*/
	layui.extend({
		admin: '{/}./static/js/admin'
	});
	layui.use(['form','admin'], function(){
	  var form = layui.form
	  	,admin = layui.admin;
	  // layer.msg('玩命卖萌中', function(){
	  //   //关闭后的操作
	  //   });
	  //监听提交
	  form.on('submit(login)', function(data){
		var name=$("#username").val();
		var pwd=$("#password").val();
			$.ajax({
				url: getPath()+'/user/login',
				data:  {
					account:name,
					password:pwd
				},
				contentType : false,
				dataType: 'json',
                crossDomain: true,
                xhrFields: {
                    withCredentials: true
                },
				success:function(data){
					var res=data.code
                    console.log(data);
					//缓存用户名
					localStorage.setItem("username",data.data.username)
					//缓存角色名
					localStorage.setItem("role",data.data.role)
					// console.log(role);
					if(res==200){
						//if(data.data.role=='管理员'){
							location.href='./index1.html?name='+name;
						/* }else{
							location.href='./index1.html?name='+name;
						} */
						 return false
					 }else{
						layer.msg(data.msg)
					 }
					},
					error:function(data){
				    console.log(data)
						location.href='./404.html'
						 return false
					},
			} );
	  });
	  
	}); 

	
</script>
<script>
	var img=document.getElementById('img');
	img.addEventListener('click',function(){
		this.setAttribute('scr','/getCaptcha?s='+Math.random());
	},false);

	
</script>
<script>
	$(document).on('click','.aaa',function(){
		//alert(123);
		window.location.reload();
	  })
</script>
    <!-- 底部结束 -->
</body>
</html>