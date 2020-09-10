<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"> 
	<title>登录</title>
	<link rel="stylesheet" href="/static/css/bootstrap.min.css">  
	<script src="/static/js/jquery.min.js"></script>
	<script src="/static/js/bootstrap.min.js"></script>
</head>
<body>

<h1 align="center">登录页面</h1>
<font color="pink">{{session('msg')}}</font>
<form class="form-horizontal" role="form"  method="post" action={{url('news/logindo')}} enctype="multipart/form-data">
    @csrf
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">用户名</label>
		<div class="col-sm-6">
			<input type="text"  class="form-control" name="user_name" id="firstname" 
				   placeholder="请输入用户名">
		</div>
	</div>
    <div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">密码</label>
		<div class="col-sm-6">
        <input type="password"  class="form-control" name="user_pwd" id="firstname" 
				   placeholder="请输入密码">
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" class="btn btn-default">登录</button>
		</div>
	</div>
</form>

</body>
</html>