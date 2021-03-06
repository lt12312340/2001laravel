@extends('admin.layouts.adminshop')  
@section('content')
  
  
    <!-- 内容主体区域 -->
    <!-- <div style="padding: 15px;"></div> -->

    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 50px;">
        <legend>
            <span class="layui-breadcrumb">
                <a href="/">后台首页</a>
                <a href="/demo/">商品属性</a>
                <a><cite>属性修改</cite></a>
            </span>
        </legend>
    </fieldset>
    @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li style="padding-left:35px; padding-bottom:10px; color:#0000ff" >{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif
<form class="layui-form" action="{{url('/attribute/update/'.$attribute->attr_id)}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="layui-form-item">
            <label class="layui-form-label">属性名称:</label>
            <div class="layui-input-block">
            <input type="text" name="attr_name" lay-verify="title" autocomplete="off" placeholder="请输入属性名称" class="layui-input" value="{{$attribute->attr_name}}">
            <b style="color:000; font-family:'仿宋' ">{{$errors->first('attr_name')}}</b> 
            </div>
        </div>

        <div class="layui-inline">
          <label class="layui-form-label">商品分类:</label>
          <div class="layui-input-inline">
            <select name="cat_id" lay-verify="required" lay-search="">
              <option value="0">直接选择或搜索选择</option>
              @foreach($cat as $v)
              <option @if($attribute->cat_id == $v->cat_id) selected @endif value="{{$v->cat_id}}">{{$v->cat_name}}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="layui-form-item" pane="">
             <label class="layui-form-label">属性是否可选:</label>
             <div class="layui-input-block">
               <input type="radio" name="attr_type" value="1" title="属性" @if($attribute->attr_type == 1) checked @endif >
               <input type="radio" name="attr_type" value="2" title="规格" @if($attribute->attr_type == 2) checked @endif>
             </div>
        </div>

        <div class="layui-form-item" pane="">
             <label class="layui-form-label">录入方式:</label>
             <div class="layui-input-block">
               <input type="radio" name="attr_input_type" value="1" title="手工录入" @if($attribute->attr_input_type == 1) checked @endif>
               <input type="radio" name="attr_input_type" value="2" title="列表选中" @if($attribute->attr_input_type == 2) checked @endif>
             </div>
        </div>

        <div class="layui-form-item layui-form-text">
          <label class="layui-form-label">属性值</label>
          <div class="layui-input-block">
            <textarea placeholder="请输入内容" name="attr_values" id="attr_values" class="layui-textarea layui-disabled" disabled="disabled">{{$attribute->attr_values}}</textarea>
          </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label"></label>
            <div class="layui-input-block" align="center">
            <button type="submit" class="layui-btn">修改</button>
            <button type="reset" class="layui-btn layui-btn-primary">清除</button>
            </div>
        </div>
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

layui.use('upload', function(){
  var $ = layui.jquery
  ,upload = layui.upload;

  $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  //拖拽上传
  upload.render({
    elem: '#test10'
    ,url: 'http://www.laravel01.com/brand/upload' //改成您自己的上传接口
    ,done: function(res){
      layer.msg(res.msg);
      layui.$('#uploadDemoView').removeClass('layui-hide').find('img').attr('src', res.data);
      //console.log(res)

      layui.$('input[name="brand_logo"]').attr('value',res.data);
    }
  });
});
</script>

<script>
  $(document).on('click','.layui-form-radio:gt(1)',function(){
  // alert(123);
    var find = $(this).prev().attr('value');
    // alert(find);
    if(find == '1'){
      // alert(123);
      $('#attr_values').addClass('layui-disabled'); 
      $('#attr_values').attr('disabled','disabled');
    }else{
      // alert(31);
      $('#attr_values').removeClass('layui-disabled'); 
      $('#attr_values').removeAttr('disabled'); 
    }
})
</script>

@endsection