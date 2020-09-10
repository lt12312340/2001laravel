<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"> 
	<title>Bootstrap 实例 - 水平表单</title>
	<link rel="stylesheet" href="/static/css/bootstrap.min.css">  
	<script src="/static/js/jquery.min.js"></script>
	<script src="/static/js/bootstrap.min.js"></script>
</head>
<body>
<center><h2>新闻添加</h2></center>
<hr>
<form class="form-horizontal" role="form" action="{{url('news/store')}}" method="post" enctype="multipart/form-data">
    @csrf
	<div class="form-group">
		<label for="firstname" class="col-sm-2 control-label">新闻标题</label>
		<div class="col-sm-10">
			<input type="text"  class="form-control" name="title" id="firstname" 
				   placeholder="请输入新闻标题">
		</div>
	</div>
	<div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">新闻分类</label>
		<div class="col-sm-10">
            <select name="type_id" id="" class="col-sm-5">
                <option value="">请选择</option>
                @foreach($type as $v)
                <option value="{{$v->type_id}}">{{$v->type_name}}</option>
                @endforeach
            </select>
		</div>
	</div>
    <div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">新闻图片</label>
		<div class="col-sm-10">
			<input type="file"  class="form-control" name="news_img" id="lastname">
		</div>
	</div>
    <div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">新闻简介</label>
		<div class="col-sm-10">
			<input type="text"  class="form-control" name="desc" id="lastname" 
				   placeholder="请输入新闻简介">
		</div>
	</div>
    <div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">新闻内容</label>
		<div class="col-sm-10">
			<input type="text"  class="form-control" name="content" id="lastname" 
				   placeholder="请输入新闻内容">
		</div>
	</div>
    <div class="form-group">
		<label for="lastname" class="col-sm-2 control-label">新闻作者</label>
		<div class="col-sm-10">
			<input type="text"  class="form-control" name="news_man" id="lastname" 
				   placeholder="请输入新闻作者">
		</div>
	</div>
    
    
	
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" class="btn btn-default">新闻添加</button>
		</div>
	</div>
</form>

</body>
</html>