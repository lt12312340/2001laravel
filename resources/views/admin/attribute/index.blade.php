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

 <div class="layui-collapse" lay-filter="test">
              <div class="layui-colla-item">
                <h2 class="layui-colla-title">多条件搜索</h2>
                <div class="layui-colla-content">
                  <div style="padding: 15px;" id="showinput">
                    <form action="{{url('/attribute')}}" method="get" enctype="multipart/form-data">
                      @CSRF
                      <input type="text" name="attr_name" style='width: 280px;' placeholder="请输入属性名称" value="{{$attr_name??''}}" class="layui-input">
                      <select name="cat_id" id="">
                          <option value="">直接选择或搜索选择</option>
                          @foreach($cat as $v)
                          <option @if($cat_id == $v->cat_id) selected @endif value="{{$v->cat_id}}">{{$v->cat_name}}</option>
                          @endforeach
                      </select>
                      <button type="submit" class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>

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
            
            
            <tr>
                <td colspan="6" align="center">
                <button type="button" class="layui-btn layui-btn-warm moredel">批量删除</button>{{$attribute->appends(['attr_name'=>$attr_name,'cat_id'=>$cat_id])->links('vendor.pagination.adminshop')}}
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
  layui.$(document).on('click','.brand_name',function(){
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
            var attr_id=_this.parents("tr").attr("attr_id");
            //获取字段
            var field=_this.parent().attr("field");
            if(!value){
              alert('值不能为空');
              return;
            }
            layui.$.ajax({
                //提交地址
                url:"{{url('/attribute/check_name')}}",
                //提交方式
                type:"post",
                //提交内容
                data:{value:value,attr_id:attr_id,field:field},
                //设置同步异步
                async:true,
                //回调函数
                success:function(res){
                  // alert(res);
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

//批量删除
$(document).on('click','.moredel',function(){
//$('.moredel').click(function(){
//   alert(123);
  var ids = new Array();
  $('input[name="attrcheck[]"]:checked').each(function(i,k){
    ids.push($(this).val())
  });
//   alert(ids);
  if(confirm('所以爱会消失是吗?')){
      $.get('/attribute/destroy/',{id:ids},function(res){
            alert(res);
            //$(obj).parents('tr').hide();
            //$(obj).parents('tr').remove();
            location.reload();
          },'json')
  }
  
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

//ajax分页
// $('.layui-laypage a').click(function(){
//   alert(123);
//   var url = $(this).attr('href');
//   attr(url);
//   return false;
// })


$(document).on('click','.layui-laypage a',function(){
//   alert(123);
  var url = $(this).attr('href');
//   alert(url);
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
  
  

