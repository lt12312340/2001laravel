@extends('admin.layouts.adminshop')  
@section('content')
    <!-- 内容主体区域 -->
    <!-- <div style="padding: 15px;"></div> -->

    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 50px;">
        <legend>
            <span class="layui-breadcrumb">
                <a href="/">后台首页</a>
                <a href="/demo/">分类管理</a>
                <a><cite>分类展示</cite></a>
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
                
                <th>分类id</th>
                <th>分类名称</th>
                <th>父级id</th>
                <th>是否展示</th>
                <th>是否在导航栏展示</th>
                <th>操作</th>
            </tr> 
            </thead>
            <tbody>
            @foreach($cate as $v)
            <tr style="display:none;" pid="{{$v->pid}}" cate_id="{{$v->cate_id}}">
                <td>
                  <a href="javascript:;" class='showHide' style="color:red;">+</a>
                  {{$v->cate_id}}
                </td>
                <td>
                {{str_repeat('|——',$v->level)}}{{$v->cate_name}}
                  <!-- <span class="brand_name">{{$v->brand_name}}</span>
                  <input type="text" class="changevalue" value="{{$v->brand_name}}" style="display:none"> -->
                </td>
                <td>
                {{$v->pid}}
                  <!-- <span class="brand_name">{{$v->brand_url}}</span>
                  <input type="text" class="changevalue" value="{{$v->brand_url}}" style="display:none"> -->
                </td>
                <td field="cate_show" class="changeValue" value="{{$v->cate_show}}">
                    @if($v->cate_show == 1) √ @else × @endif
                  <!-- <span class="brand_name">{{$v->brand_desc}}</span>
                  <input type="text" class="changevalue" value="{{$v->brand_desc}}" style="display:none"> -->
                </td>
                <td field="cate_nav_show" class="changeValue" value="{{$v->cate_nav_show}}">
                    @if($v->cate_nav_show == 1) √ @else × @endif
                  <!-- <span class="brand_name">{{$v->brand_desc}}</span>
                  <input type="text" class="changevalue" value="{{$v->brand_desc}}" style="display:none"> -->
                </td>
                <td>
                    <a href="javascript:void(0)" onclick="DeleteGetId({{$v->cate_id}},this)">
                    <button type="button" class="layui-btn layui-btn-danger">删除</button>
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
    layui.use(['element','form'], function(){
        var element = layui.element;
        var form = layui.form;
    });


//删除
function DeleteGetId(cate_id,obj){
    // alert(cate_id);die;
    if(!cate_id){
      return;
    }

    $.get('/category/destroy/'+cate_id,function(res){
      alert(res.msg);
      //$(obj).parents('tr').hide();
      //$(obj).parents('tr').remove();
      location.reload();
    },'json')
}

// 对错号即点即改
$('.changeValue').click(function(){
  // 获取点击对象
  var _this=$(this);
  // console.log(_this);die;
  // 获取分类
  var cate_id=_this.parent().attr('cate_id');
  // console.log(cate_id);
  // 获取字段
  var _field=_this.attr('field');
  // console.log(_field);
  // 获取值
  var sign=_this.text();
  // console.log(typeof(sign));

  // 获取√,赋值为1;获取×,赋值为2;
  var is_show=_this.attr('value');
  // alert(is_show);
  // return;
  // ajax传值
  $.ajax({
    url:"{{url('/category/check_cateshows')}}",
    type:'post',
    data:{cate_id:cate_id,_field:_field,is_show:is_show},
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

// 获取顶级分类
$("tr[pid='0']").show();

// 给+绑定点击事件
$('.showHide').click(function(){
  // 获取点击+的这个对象
  var _this=$(this);
  // console.log(_this);
  // 获取纯文本
  var sign=_this.text();
  // console.log(sign);
  var cate_id=_this.parents("tr").attr('cate_id');
  // console.log('cate_id');
  if(sign=='+'){
    var child=$("tr[pid='"+cate_id+"']");
    // console.log(child.length);
    if(child.length>0){
      child.show();
      _this.text("-");
    }
  }else{
    $("tr[pid='"+cate_id+"']").hide();
    _this.text("+");
  }
})
</script>
  @endsection
  
  

