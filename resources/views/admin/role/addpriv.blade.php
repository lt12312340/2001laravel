@extends('admin.layouts.adminshop')  
@section('content')
    <!-- 内容主体区域 -->
    <!-- <div style="padding: 15px;"></div> -->

    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 50px;">
        <legend>
            <span class="layui-breadcrumb">
                <a href="/">后台首页</a>
                <a href="/demo/">权限管理</a>
                <a><cite>添加权限</cite></a>
            </span>
        </legend>
    </fieldset>


<!-- <form class="layui-form" action="{{url('/brand')}}" >

  <div class="layui-form-item">
    <div class="layui-inline">
      <label class="layui-form-label">商品名称</label>
      <div class="layui-input-inline">
        <input type="text" name="brand_name" lay-verify="required|phone" autocomplete="off" class="layui-input" placeholder="商品名称" value="{{$query['brand_name']??''}}">
      </div>
    </div>
    <div class="layui-inline">
      <label class="layui-form-label">商品网址</label>
      <div class="layui-input-inline">
        <input type="text" name="brand_url" lay-verify="email" autocomplete="off" class="layui-input" placeholder="商品网址" value="{{$query['brand_url']??''}}">
      </div>
    </div>
    <button type="submit" class="layui-btn layui-btn-warm">搜索</button>
  </div>
  
</form> -->

    <div class="layui-form">
        <form action="{{url('role/addprivdo')}}" method="post">
        <input type="hidden" name="role_id" value={{$role_id}}>
        <table class="layui-table">
            <colgroup>
            <col width="150">
            <col width="150">
            <col width="200">
            <col>
            </colgroup>
            <thead>
            <tr> 
                <th width="30%">权限名称</th>
                <th>
                  <input type="checkbox" name="allcheckbox" lay-skin="primary"   class="vainglory" >
                </th>
            </tr> 
            </thead>
            <tbody>
            @foreach($menu as $v)
            <tr>
                <td>
                  {{str_repeat('|——',$v->level)}}{{$v->names}}
                </td>
                <td><input @if(in_array($v->id,$role_menu)) checked @endif type="checkbox" class="priv_{{$v->id}}" name="menucheck[]" lay-skin="primary"  parent_id="{{$v->parent_id}}" value="{{$v->id}}"></td>
            </tr>
            @endforeach
            <tr>
                <td colspan="2">
                   <center><button type="submit" class="layui-btn layui-btn-normal">添加权限</button></center>
                </td>
            </tr>
            </tbody>       
        </table>
        </form>
    </div>

<script src="/static/layui/layui.js"></script>
<script src="/static/layui/jquery.js"></script>
<script>
//JavaScript代码区域
layui.use(['element','form'], function(){
  var element = layui.element;
  var form = layui.form;
});

//全选
$(document).on('click','.layui-form-checkbox:eq(0)',function(){
  //alert(123321);
  var checkval = $('input[name="allcheckbox"]').prop('checked');
  //alert(checkval);
  $('input[name="menucheck[]"]').prop('checked',checkval);
  if(checkval){
    $('.layui-form-checkbox:gt(0)').addClass('layui-form-checked');
  }else{
    $('.layui-form-checkbox:gt(0)').removeClass('layui-form-checked');
  }
  
})

$(document).on('click','.layui-form-checkbox',function(){
    var val = $(this).prev().val();
    // alert(val);
    //当前复选框的值
    var checkval = $(this).prev().prop('checked');
    $('input[parent_id="'+val+'"]').prop('checked',checkval);
    // alert(checkval);
    if(checkval){
        $('input[parent_id="'+val+'"]').next().addClass('layui-form-checked');
    }else{
        $('input[parent_id="'+val+'"]').next().removeClass('layui-form-checked');
    }

    var parent_val = $(this).prev().attr('parent_id');
    //alert(parent_val);
    $('input[class="priv_'+parent_val+'"]').prop('checked',checkval);
    if(checkval){
        $('input[class="priv_'+parent_val+'"]').next().addClass('layui-form-checked');
    }else{
        $('input[class="priv_'+parent_val+'"]').next().removeClass('layui-form-checked');
    }
})
</script>

  @endsection
  
  

