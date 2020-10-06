@extends('admin.layouts.adminshop')  
@section('content')
  
  
    <!-- 内容主体区域 -->
    <!-- <div style="padding: 15px;"></div> -->

    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 50px;">
        <legend>
            <span class="layui-breadcrumb">
                <a href="/">后台首页</a>
                <a href="/demo/">广告管理</a>
                <a><cite>添加广告</cite></a>
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
<form class="layui-form" action="{{url('/ad/store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="layui-form-item">
            <label class="layui-form-label">广告名称:</label>
            <div class="layui-input-block">
            <input type="text" name="ad_name" lay-verify="title" autocomplete="off" placeholder="请输入广告名称" class="layui-input">
            <b style="color:000; font-family:'仿宋' ">{{$errors->first('brand_name')}}</b> 
            </div>
        </div>

        <div class="layui-inline">
          <label class="layui-form-label">媒介类型:</label>
          <div class="layui-input-inline">
            <select name="media_type" lay-verify="required" lay-search="">
              <option value="1">图片</option>
              <option value="2">文字</option>
            </select>
          </div>
        </div>

        <div class="layui-inline">
          <label class="layui-form-label">广告位置:</label>
          <div class="layui-input-inline">
            <select name="position_id" lay-verify="required" lay-search="">
              <option value="0">请选择</option>
              @if($position)
              @foreach($position as $v)
              <option value="{{$v->position_id}}">{{$v->position_name}}</option>
              @endforeach
              @endif
            </select>
          </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">开始日期:</label>
                <div class="layui-input-inline">
                    <input type="text" name="start_time" id="date" lay-verify="date" placeholder="开始日期" autocomplete="off" class="layui-input">
                </div>
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">结束日期:</label>
                <div class="layui-input-inline">
                    <input type="text" name="end_time" id="date1" lay-verify="date" placeholder="结束日期" autocomplete="off" class="layui-input">
                </div>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">广告链接:</label>
            <div class="layui-input-block">
            <input type="text" name="ad_link" lay-verify="title" autocomplete="off" placeholder="请输入广告链接" class="layui-input">
            <b style="color:000; font-family:'仿宋'" >{{$errors->first('brand_desc')}}</b> 
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">广告图片:</label>
            <div class="layui-input-block">
                <div class="layui-upload-drag" id="test10">
                    <i class="layui-icon">&#xe67c;</i>
                    <p>点击上传，或将文件拖拽到此处</p>
                    <div class="layui-hide" id="uploadDemoView">
                    <hr>
                    <img src="" alt="上传成功后渲染" style="max-width: 196px">
                    </div>
                </div>
                <input type="hidden" name="ad_img">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">图片网址:</label>
            <div class="layui-input-block">
            <input type="text" name="img_url" lay-verify="title" autocomplete="off" placeholder="请输入图片网址" class="layui-input">
            <b style="color:000; font-family:'仿宋'" >{{$errors->first('brand_desc')}}</b> 
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">是否开启:</label>
            <div class="layui-input-block">
                <input type="radio" name="enabled" value="1" title="是" checked="">
                <input type="radio" name="enabled" value="2" title="否">
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
  layui.use('laydate', function(){
    var laydate = layui.laydate;
    
    //执行一个laydate实例
    laydate.render({
      elem: '#date'//指定元素
    });
  });
</script>

<script>
  layui.use('laydate', function(){
    var laydate = layui.laydate;
    
    //执行一个laydate实例
    laydate.render({
      elem: '#date1'//指定元素
    });
  });
</script>

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
    ,url: 'http://www.laravel01.com/ad/upload' //改成您自己的上传接口
    ,done: function(res){
      layer.msg(res.msg);
      layui.$('#uploadDemoView').removeClass('layui-hide').find('img').attr('src', res.data);
      //console.log(res)

      layui.$('input[name="ad_img"]').attr('value',res.data);
    }
  });
});
</script>

@endsection