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
                <td field="cat_name">
                  <span class="change">{{$v->cat_name}}</span>
                  <input type="text" class="changevalue" value="{{$v->cat_name}}" style="display:none">
                </td>

                <td field="enabled" class="changevalue" value="{{$v->enabled}}">
                  @if($v->enabled == 1) √ @else × @endif
                </td>

                <td>
                    <a href="javascript:void(0)" onclick="DeleteGetId({{$v->cat_id}},this)">
                    <button type="button" class="layui-btn layui-btn-danger">删除</button>
                    </a>
                    <a href="{{url('/goods_type/edit/'.$v->cat_id)}}">
                    <button type="button" class="layui-btn layui-btn-normal">编辑</button>
                    </a>
                    <a href="{{url('/goods_type/attrshow/'.$v->cat_id)}}">
                    <button type="button" class="layui-btn" >属性列表</button>
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

  // 对错号即点即改
$(document).on('click','.changevalue',function(){
    // 获取点击对象
    var _this=$(this);
    //   console.log(_this);
    // 获取分类
    var cat_id=_this.parent().attr('cat_id');
    // console.log(cat_id);
      // 获取字段
  var _field=_this.attr('field');
//   console.log(_field);
  // 获取值
  var sign=_this.text();
//   console.log(typeof(sign));

  // 获取√,赋值为1;获取×,赋值为2;
  var is_show=_this.attr('value');
//   alert(is_show);
  // return;
// ajax传值
$.ajax({
    url:"{{url('/goods_type/check_typeshows')}}",
    type:'post',
    data:{cat_id:cat_id,_field:_field,is_show:is_show},
    dataType:'json',
    // 回调函数
    success:function(res){
       //alert(res);
      // return;
      if(res.code==0){
          _this.text(res.data==1?'√':'×');
          _this.attr('value',res.data);
      }
    }
  })
})

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

//批量删除
$(document).on('click','.moredel',function(){
//$('.moredel').click(function(){
  //alert(123);
  var ids = new Array();
  $('input[name="goodstypecheck[]"]:checked').each(function(i,k){
    ids.push($(this).val())
  });
  //alert(ids);
  if(confirm('所以爱会消失是吗?')){
      $.get('/goods_type/destroy/',{cat_id:ids},function(res){
            alert(res.msg);
            //$(obj).parents('tr').hide();
            //$(obj).parents('tr').remove();
            location.reload();
          },'json')
  }
  
})


// ajax分页
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


  //即点即改
  layui.$(document).on('click','.change',function(){
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
            var cat_id=_this.parents("tr").attr("cat_id");
            //获取字段
            var field=_this.parent().attr("field");
            if(!value){
              alert('值不能为空');
              return;
            }
            layui.$.ajax({
                //提交地址
                url:"{{url('/goods_type/check_name')}}",
                //提交方式
                type:"post",
                //提交内容
                data:{value:value,cat_id:cat_id,field:field},
                //设置同步异步
                async:true,
                //回调函数
                success:function(res){
                  //alert(res);
                    if(res==0){
                        _this.prev("span").text(value).show();
                        _this.hide();
                    }else{
                        alert("操作有误");
                    }
                }
            })
  })




</script>

  @endsection
