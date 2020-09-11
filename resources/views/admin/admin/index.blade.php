@extends('admin.layouts.adminshop')  
@section('content')
    <!-- 内容主体区域 -->
    <!-- <div style="padding: 15px;"></div> -->

    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 50px;">
        <legend>
            <span class="layui-breadcrumb">
                <a href="/">后台首页</a>
                <a href="/demo/">管理员</a>
                <a><cite>管理员列表</cite></a>
            </span>
        </legend>
    </fieldset>

    <div class="layui-form">
        <table class="layui-table">
            <colgroup>
            <col width="150">
            <col width="150">
            <col width="200">
            <col>
            </colgroup>
            <thead>
            <tr>
                <th>管理员id</th>
                <th>管理员名称</th>
                <th>管理员头像</th>
                <th>操作</th>
            </tr> 
            </thead>
            <tbody>
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
            
            <!--  -->
            </tbody>       
        </table>
        
    </div>

<script src="/static/layui/layui.js"></script>
<script src="/static/layui/jquery.js"></script>
<script>
//JavaScript代码区域
layui.use(['element','form'], function(){
  var element = layui.element;
  var form = layui.form;
  
})
//ajax删除
function DeleteGetId(admin_id,obj){
    //alert(admin_id);
    if(!admin_id){
        return ;
    }
    $.get('/admin/destroy/'+admin_id,function(res){
      alert(res.msg);
      //$(obj).parents('tr').hide();
      //$(obj).parents('tr').remove();
      location.reload();
    },'json')

}
//ajax分页
$(document).on('click','.layui-laypage a',function(){
    //alert(123);
    var url= $(this).attr('href');
    //alert(url);
    $.get(url,function(res){
      $('tbody').html(res);
      
   
  })
  return false;
});

</script>

  @endsection
  
  

