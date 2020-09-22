@extends('admin.layouts.adminshop')  
@section('content')
    <!-- 内容主体区域 -->
    <!-- <div style="padding: 15px;"></div> -->

    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 50px;">
        <legend>
            <span class="layui-breadcrumb">
                <a href="/">后台首页</a>
                <a href="/demo/">商品属性</a>
                <a><cite>属性展示</cite></a>
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

         
           <a href="{{url('/attribute/create/'.$cat_id)}}">
              <button type="button" class="layui-btn" >添加属性</button>
          </a>
        

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
                <th>属性id</th>
                <th>属性名称</th>
                <th>商品分类名称</th>
                <th>属性值</th>
                <th>操作</th>
            </tr> 
            </thead>
            <tbody>
            @foreach($attribute as $v)
            <tr attr_id = {{$v->attr_id}}>
                <td><input type="checkbox" name="attrcheck[]" lay-skin="primary"  value="{{$v->attr_id}}"></td>
                <td>{{$v->attr_id}}</td>
                <td field="attr_name">
                  <span class="brand_name">{{$v->attr_name}}</span>
                  <input type="text" class="changevalue" value="{{$v->attr_name}}" style="display:none">
                </td>
                <td>
                  {{$v->cat_name}}
                </td>
                <td field="attr_values">
                  <span class="brand_name">{{$v->attr_values}}</span>
                  <input type="text" class="changevalue" value="{{$v->attr_values}}" style="display:none">
                </td>
                <td>
                    <a href="javascript:void(0)" onclick="DeleteGetId({{$v->attr_id}},this)">
                    <button type="button" class="layui-btn layui-btn-danger">删除</button>
                    </a>
                    <a href="{{url('attribute/edit/'.$v->attr_id)}}">
                    <button type="button" class="layui-btn layui-btn-normal">编辑</button>
                    </a>
                </td>
            </tr>
            @endforeach
            
            
           
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
  
//全选
$(document).on('click','.layui-form-checkbox:eq(0)',function(){
//   alert(123321);
  var checkval = $('input[name="allcheckbox"').prop('checked');
//   alert(checkval);
  $('input[name="attrcheck[]"]').prop('checked',checkval);
  if(checkval){
    $('.layui-form-checkbox:gt(0)').addClass('layui-form-checked');
  }else{
    $('.layui-form-checkbox:gt(0)').removeClass('layui-form-checked');
  }
  
})

})
 //删除
function DeleteGetId(attr_id,obj){
    //alert(brand_id);
    if(!attr_id){
      return;
    }

    $.get('/attribute/destroy/'+attr_id,function(res){
      //alert(res.msg);
      popup({type:'tip',msg:res.msg,delay:3000,callBack:function(){
        
      }});
      //$(obj).parents('tr').hide();
      //$(obj).parents('tr').remove();
      location.reload();
    },'json')
}
</script>

  @endsection
  
  

