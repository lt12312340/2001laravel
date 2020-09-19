@extends('admin.layouts.adminshop')  
@section('content')
  
  
    <!-- 内容主体区域 -->
    <!-- <div style="padding: 15px;"></div> -->

    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 50px;">
        <legend>
            <span class="layui-breadcrumb">
                <a href="/">后台首页</a>
                <a href="/demo/">管理员</a>
                <a><cite>管理员添加</cite></a>
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
<form class="layui-form" action="{{url('/admin/store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="layui-form-item">
            <label class="layui-form-label">管理员名称:</label>
            <div class="layui-input-block">
            <input type="text" name="admin_account" lay-verify="title" autocomplete="off" placeholder="请输入管理员名称" class="layui-input">
            <b style="color:red; font-family:'仿宋' ">{{$errors->first('admin_account')}}</b> 
            </div>
        </div>
        <div class="layui-form-item">
          <label class="layui-form-label">管理员密码:</label>
          <div class="layui-input-block">
          <input type="password" name="admin_pwd" lay-verify="title" autocomplete="off" placeholder="请输入管理员密码 " class="layui-input">
          <b style="color:red; font-family:'仿宋' "></b> 
          </div>
      </div>

        <div class="layui-form-item">
            <label class="layui-form-label">管理员头像:</label>
            <div class="layui-input-block">
            <!-- <button type="button" class="layui-btn layui-btn-lg layui-btn-primary layui-btn-radius">
                <input type="file" name="brand_logo"  style='opacity:0; width:20px;'><span>文件上传</span>
            </button> -->
            
            <div class="layui-upload-drag" id="test10">
              <i class="layui-icon">&#xe67c;</i>
              <p>点击上传，或将文件拖拽到此处</p>
              <div class="layui-hide" id="uploadDemoView">
                <hr>
                <img src="" alt="上传成功后渲染" style="max-width: 196px">
              </div>
              
            </div>
            <input type="hidden" name="my_img">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">角色:</label>
            <div class="layui-input-block">
              @foreach($role as $v)
              <input type="checkbox" name="role[]" lay-skin="primary" value="{{$v->role_id}}" title="{{$v->role_name}}">
              @endforeach
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label"></label>
            <div class="layui-input-block" align="center">
            <button type="submit" class="layui-btn">添加</button>
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
    ,url: 'http://www.laravel01.com/admin/upload' //改成您自己的上传接口
    ,done: function(res){
      layer.msg(res.msg);
      layui.$('#uploadDemoView').removeClass('layui-hide').find('img').attr('src', res.data);
      //console.log(res)

      layui.$('input[name="my_img"]').attr('value',res.data);
    }
  });
});
</script>

@endsection