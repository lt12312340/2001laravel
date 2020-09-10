<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"> 
	<title>Bootstrap 实例 - 边框表格</title>
	<link rel="stylesheet" href="/static/css/bootstrap.min.css">  
	<script src="/static/js/jquery.min.js"></script>
	<script src="/static/js/bootstrap.min.js"></script>
</head>
<body>



<center>
    <h2>新闻展示
        <a href="{{url('news/create')}}" style="float:right;">
            <button type="button" class="btn btn-success">添加</button>
        </a>
    </h2>
    <hr>
</center>



<table class="table table-bordered">
	<thead>
		<tr>
			<th>新闻标题</th>
			<th>新闻分类</th>
            <th>新闻图片</th>
            <th>新闻简介</th>
            <th>前往详情页</th>
		</tr>
	</thead>
	<tbody>
    @foreach($news as $v)
		<tr>
			<td>{{$v->title}}</td>
			<td>{{$v->type_name}}</td>
            <td>@if($v->news_img)<img src="{{env('UPLOADS_URL')}}{{$v->news_img}}" width="50">@endif</td>
			<td>{{$v->desc}}</td>
			<td>
				<a href="{{url('news/product/'.$v->news_id)}}">
					<button type="button" class="btn btn-primary">前往详情页</button>
				</a>
            </td>
		</tr>
	@endforeach
    <tr>
        <td colspan="5" align="center">{{$news->links()}}</td>
    </tr>
	</tbody>
</table>

</body>
</html>

<script>
$(document).on('click','.page-item a',function(){
	//alert(123);
	var url=$(this).attr('href');
	//alert(url);
	$.get(url,function(res){
		$('tbody').html(res);
	})
	return false;
})
</script>