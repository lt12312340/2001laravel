@extends('admin.layouts.adminshop')  
@section('content')
    <!-- 内容主体区域 -->
    <!-- <div style="padding: 15px;"></div> -->

    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 50px;">
        <legend>
            <span class="layui-breadcrumb">
                <a href="/">后台首页</a>
                <a href="/demo/">广告管理</a>
                <a><cite>广告列表</cite></a>
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
                <th>广告id</th>
                <th>广告名称</th>
                <th>广告位置</th>
                <th>媒介类型</th>
                <th>开始时间</th>
                <th>结束时间</th>
                <th>点击次数</th>
                <th>操作</th>
            </tr> 
            </thead>
            <tbody>
            @foreach($ad as $v)
            <tr brand_id = {{$v->ad_id}}>
                <td><input type="checkbox" name="brandcheck[]" lay-skin="primary"  value="{{$v->ad_id}}"></td>
                <td>{{$v->ad_id}}</td>
                <td field="ad_name">
                  <span class="brand_name">{{$v->ad_name}}</span>
                  <input type="text" class="changevalue" value="{{$v->ad_name}}" style="display:none">
                </td>
                <td>
                  {{$v->position_name}}
                </td>
                <td>
                  @if($v->media_type ==1) 图片 @else 文字 @endif
                </td>
                <td>
                  {{date('Y-m-d',$v->start_time)}}
                </td>
                <td>
                  {{date('Y-m-d',$v->end_time)}}
                </td>
                <td>
                  {{$v->click_count}}
                </td>
                <td>
                    <a href="javascript:void(0)" onclick="DeleteGetId({{$v->position_id}},this)">
                    <button type="button" class="layui-btn layui-btn-danger">删除</button>
                    </a>
                    <a href="{{url('position/edit/'.$v->position_id)}}">
                    <button type="button" class="layui-btn layui-btn-normal">编辑</button>
                    </a>
                    
                </td>
            </tr>
            @endforeach
            
            
            <tr>
                <td colspan="9" align="center">
                <button type="button" class="layui-btn layui-btn-warm moredel">批量删除</button>{{$ad->links('vendor.pagination.adminshop')}}
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
            var brand_id=_this.parents("tr").attr("brand_id");
            //获取字段
            var field=_this.parent().attr("field");
            if(!value){
              alert('值不能为空');
              return;
            }
            layui.$.ajax({
                //提交地址
                url:"{{url('/position/check_name')}}",
                //提交方式
                type:"post",
                //提交内容
                data:{value:value,brand_id:brand_id,field:field},
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
      $.get('/position/destroy/',{id:ids},function(res){
            alert(res.msg);
            //$(obj).parents('tr').hide();
            //$(obj).parents('tr').remove();
            location.reload();
          },'json')
  }
  
})

//删除
function DeleteGetId(position_id,obj){
    //alert(brand_id);
    if(!position_id){
      return;
    }

    $.get('/position/destroy/'+position_id,function(res){
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
  
  

