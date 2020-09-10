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