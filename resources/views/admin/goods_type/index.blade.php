@extends('admin.layouts.adminshop')
@section('content')
    <!-- 内容主体区域 -->
    <!-- <div style="padding: 15px;"></div> -->

    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 50px;">
        <legend>
            <span class="layui-breadcrumb">
                <a href="/">后台首页</a>
                <a href="/demo/">商品分类管理</a>
                <a><cite>分类列表</cite></a>
            </span>
        </legend>
    </fieldset>

    <div class="layui-collapse" lay-filter="test">
              <div class="layui-colla-item">
                <h2 class="layui-colla-title">多条件搜索</h2>
                <div class="layui-colla-content">
                  <div style="padding: 15px;" id="showinput">
                    <form action="{{url('/goods_type/index')}}" method="get" enctype="multipart/form-data">
                      @CSRF
                      <input type="text" name="cat_name" style='width: 280px;' placeholder="请输入分类名称" value="{{$query['cat_name']??''}}" class="layui-input">
                      <button type="submit" class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>


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
                <th>
                  <input type="checkbox" name="allcheckbox" lay-skin="primary" class="vainglory" >
                </th>
                <th>分类id</th>
                <th>分类名称</th>
                <th>是否启用</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($goods_type as $v)
            <tr cat_id="{{$v->cat_id}}">
                <td><input type="checkbox" name="goodstypecheck[]" lay-skin="primary"  value="{{$v->cat_id}}"></td>
                <td>{{$v->cat_id}}</td>
                <td field="cat_name" old="{{$v->cat_name}}">
                  <span class="span_name">{{$v->cat_name}}</span>
                </td>
                <td cat_id="{{$v->cat_id}}" class="hubei" status='{{$v->enabled}}' filed="enabled">{{$v->enabled=='1' ? "√" : "×"}}</td>
                <td>
                    <a href="javascript:void(0)" onclick="DeleteGetId({{$v->cat_id}},this)">
                    <button type="button" class="layui-btn layui-btn-danger">删除</button>
                    </a>
                    <a href="/goods_type/edit?cate_id={{$v->cat_id}}">
                    <button type="button" class="layui-btn layui-btn-normal">编辑</button>
                    </a>
                </td>
            </tr>
            @endforeach


            <tr>
                <td colspan="7" align="center">
                <button type="button" class="layui-btn layui-btn-warm moredel">批量删除</button>
                {{$goods_type->appends(["cat_name"=>$cat_name])->links('vendor.pagination.adminshop')}}
                </td>
            </tr>
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
});

//全选
$(document).on('click','.layui-form-checkbox:eq(0)',function(){
  //alert(123321);
  var checkval = $('input[name="allcheckbox"]').prop('checked');
  //alert(checkval);
  $('input[name="goodstypecheck[]"]').prop('checked',checkval);
  if(checkval){
    $('.layui-form-checkbox:gt(0)').addClass('layui-form-checked');
  }else{
    $('.layui-form-checkbox:gt(0)').removeClass('layui-form-checked');
  }
  
})

//删除
function DeleteGetId(cat_id,obj){
    //alert(brand_id);
    if(!cat_id){
      return;
    }

    $.get('/goods_type/destroy/'+cat_id,function(res){
      alert(res.msg);
      //$(obj).parents('tr').hide();
      //$(obj).parents('tr').remove();
      location.reload();
    },'json')
}
</script>

  @endsection
