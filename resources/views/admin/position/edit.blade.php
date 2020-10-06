@extends('admin.layouts.adminshop')  
@section('content')
  
  
    <!-- 内容主体区域 -->
    <!-- <div style="padding: 15px;"></div> -->

    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 50px;">
        <legend>
            <span class="layui-breadcrumb">
                <a href="/">后台首页</a>
                <a href="/demo/">广告管理</a>
                <a><cite>修改广告位</cite></a>
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
<form class="layui-form" action="{{url('/position/update/'.$position->position_id)}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="layui-form-item">
            <label class="layui-form-label">广告位名称:</label>
            <div class="layui-input-block">
            <input type="text" name="position_name" lay-verify="title" autocomplete="off" placeholder="请输入广告位名称" class="layui-input" value="{{$position->position_name}}">
            <b style="color:000; font-family:'仿宋' ">{{$errors->first('brand_name')}}</b> 
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">广告位宽度:</label>
            <div class="layui-input-block">
            <input type="text" name="ad_width" lay-verify="title" autocomplete="off" placeholder="请输入广告位宽度" class="layui-input" value="{{$position->ad_width}}">
            <b style="color:000; font-family:'仿宋'" >{{$errors->first('brand_url')}}</b> 
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">广告位高度:</label>
            <div class="layui-input-block">
            <input type="text" name="ad_height" lay-verify="title" autocomplete="off" placeholder="请输入广告位高度" class="layui-input" value="{{$position->ad_height}}">
            <b style="color:000; font-family:'仿宋'" >{{$errors->first('brand_desc')}}</b> 
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">广告位描述:</label>
            <div class="layui-input-block">
            <input type="text" name="position_desc" lay-verify="title" autocomplete="off" placeholder="请输入广告位描述" class="layui-input" value="{{$position->position_desc}}">
            <b style="color:000; font-family:'仿宋'" >{{$errors->first('brand_desc')}}</b> 
            </div>
        </div>

        <div class="layui-inline">
          <label class="layui-form-label">广告位模板:</label>
          <div class="layui-input-inline">
            <select name="template" lay-verify="required" lay-search="">
              <option value="0">请选择模板</option>
              <option value="1" @if($position->template==1) selected @endif>单图片</option>
              <option value="2" @if($position->template==2) selected @endif>多图片</option>
              <option value="3" @if($position->template==3) selected @endif>文字</option>
            </select>
          </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label"></label>
            <div class="layui-input-block" align="center">
            <button type="submit" class="layui-btn">确定</button>
            <button type="reset" class="layui-btn layui-btn-primary">清除</button>
            </div>
        </div>
    </form>
    
  </div>
  
  

<script src="/static/layui/layui.js"></script>
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

@endsection