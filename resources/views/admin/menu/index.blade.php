@extends('admin.layouts.adminshop')  
@section('content')
    <!-- 内容主体区域 -->
    <!-- <div style="padding: 15px;"></div> -->

    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 50px;">
        <legend>
            <span class="layui-breadcrumb">
                <a href="/">后台首页</a>
                <a href="/demo/">权限管理</a>
                <a><cite>权限展示</cite></a>
            </span>
        </legend>
    </fieldset>

 <div class="layui-collapse" lay-filter="test">
              <div class="layui-colla-item">
                <h2 class="layui-colla-title">多条件搜索</h2>
                <div class="layui-colla-content">
                  <div style="padding: 15px;" id="showinput">
                    <form action="{{url('/menu')}}" method="get" enctype="multipart/form-data">
                      @CSRF
                      <input type="text" name="names" style='width: 280px;' placeholder="请输入权限名称" value="{{$query['names']??''}}" class="layui-input">
                      <input type="text" name="model" style='width: 280px;' placeholder="请输入模块" value="{{$query['model']??''}}" class="layui-input">
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
                <th>权限id</th>
                <th>权限名称</th>
                <th>模块</th>
                <th>控制器</th>
                <th>方法</th>
                <th>路由</th>
                <th>操作</th>
            </tr> 
            </thead>
            <tbody>
            @foreach($menu as $v)
            <tr id = {{$v->id}}>
                <td><input type="checkbox" name="brandcheck[]" lay-skin="primary"  value="{{$v->id}}"></td>
                <td>{{$v->id}}</td>
                <td field="names">
                  <span class="names">{{$v->names}}</span>
                  <input type="text" class="changevalue" value="{{$v->names}}" style="display:none">
                </td>
                <td field="model">
                  <span class="brand_name">{{$v->model}}</span>
                  <input type="text" class="changevalue" value="{{$v->model}}" style="display:none">
                </td>
                <td field="controller">
                  <span class="brand_name">{{$v->controller}}</span>
                  <input type="text" class="changevalue" value="{{$v->controller}}" style="display:none">
                </td>
                 <td field="brand_desc">
                  <span class="function">{{$v->function}}</span>
                  <input type="text" class="changevalue" value="{{$v->function}}" style="display:none">
                </td>
                 <td field="brand_desc">
                  <span class="route">{{$v->route}}</span>
                  <input type="text" class="changevalue" value="{{$v->route}}" style="display:none">
                </td>
                <td>
                    <a href="javascript:void(0)" onclick="DeleteGetId({{$v->id}},this)">
                    <button type="button" class="layui-btn layui-btn-danger">删除</button>
                    </a>
                    <a href="{{url('menu/edit/'.$v->id)}}">
                    <button type="button" class="layui-btn layui-btn-normal">编辑</button>
                    </a>
                </td>
            </tr>
            @endforeach
            
            
            <tr>
                <td colspan="8" align="center">
                <button type="button" class="layui-btn layui-btn-warm moredel">批量删除</button>{{$menu->appends($query)->links('vendor.pagination.adminshop')}}
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
  //即点即改
  layui.$(document).on('click','.names',function(){
    //alert(123);
    //获取点击对象
    var _this=layui.$(this);
        _this.next("input").show();
        _this.hide();
  });
  layui.$(document).on('blur','.changevalue',function(){
  //layui.$(".changevalue").blur(function(){
            //获取失焦对象
            var _this=layui.$(this);
            //获取值
            var value=_this.val();
            //获取id
            var id=_this.parents("tr").attr("id");
            //获取字段
            var field=_this.parent().attr("field");
            if(!value){
              alert('值不能为空');
              return;
            }
            layui.$.ajax({
                //提交地址
                url:"{{url('/menu/check_name')}}",
                //提交方式
                type:"post",
                //提交内容
                data:{value:value,id:id,field:field},
                //设置同步异步
                async:true,
                //回调函数
                success:function(res){
                  //alert(typeof(res));
                    if(res==0){
                        _this.prev("span").text(value).show();
                        _this.hide();
                    }else{
                        alert("操作有误");
                    }
                }
            })
  })

});

//全选
$(document).on('click','.layui-form-checkbox:eq(0)',function(){
  //alert(123321);
  var checkval = $('input[name="allcheckbox"]').prop('checked');
  //alert(checkval);
  $('input[name="brandcheck[]"]').prop('checked',checkval);
  if(checkval){
    $('.layui-form-checkbox:gt(0)').addClass('layui-form-checked');
  }else{
    $('.layui-form-checkbox:gt(0)').removeClass('layui-form-checked');
  }
  
})

//批量删除
$(document).on('click','.moredel',function(){
//$('.moredel').click(function(){
  //alert(123);
  var ids = new Array();
  $('input[name="brandcheck[]"]:checked').each(function(i,k){
    ids.push($(this).val())
  });
  //alert(ids);
  if(confirm('所以爱会消失是吗?')){
      $.get('/menu/destroy/',{id:ids},function(res){
            alert(res.msg);
            //$(obj).parents('tr').hide();
            //$(obj).parents('tr').remove();
            location.reload();
          },'json')
  }
  
})

//删除
function DeleteGetId(id,obj){
    //alert(brand_id);
    if(!id){
      return;
    }

    $.get('/menu/destroy/'+id,function(res){
      alert(res.msg);
      //$(obj).parents('tr').hide();
      //$(obj).parents('tr').remove();
      location.reload();
    },'json')
}

//ajax分页
// $('.layui-laypage a').click(function(){
//   alert(123);
//   var url = $(this).attr('href');
//   attr(url);
//   return false;
// })


$(document).on('click','.layui-laypage a',function(){
  //alert(123);
  var url = $(this).attr('href');
  //alert(url);
  $.get(url,function(res){
      $('tbody').html(res);
      $('.vainglory').prop('checked',false);
      layui.use(['element','form'], function(){
      var element = layui.element;
      form = layui.form;
      form.render();
    })
  })
  return false;
})
</script>

  @endsection
  
  

