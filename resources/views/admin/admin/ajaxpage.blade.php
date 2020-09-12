@foreach($res as $v)
<tr>
   
    <td>{{$v->admin_id}}</td>
    <td>{{$v->admin_account}}</td>
    <td>@if($v->my_img)<img src="{{$v->my_img}}" width="60"> @endif</td>
    <td>
        <a href="javascript:void(0)" onclick="DeleteGetId({{$v->admin_id}},this)">
            <button type="button" class="layui-btn layui-btn-danger">删除</button>
        </a>
        <a href="{{url('admin/edit/'.$v->admin_id)}}">
            <button type="button" class="layui-btn layui-btn-normal">编辑</button>
        </a>
    </td>
</tr>
@endforeach
<tr>
    <td colspan="5">{{$res->links('vendor.pagination.adminshop')}}</td>
</tr>