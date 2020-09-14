@extends('admin.layouts.adminshop')  
@section('content')
  
  
    <!-- 内容主体区域 -->
    <!-- <div style="padding: 15px;"></div> -->

    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 50px;">
        <legend>
            <span class="layui-breadcrumb">
                <a href="/">后台首页</a>
                <a href="/demo/">角色管理</a>
                <a><cite>角色添加</cite></a>
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
<form class="layui-form" action="{{url('/role/update/'.$role->role_id)}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="layui-form-item">
            <label class="layui-form-label">角色名称:</label>
            <div class="layui-input-block">
            <input type="text" name="role_name" lay-verify="title" autocomplete="off" placeholder="请输入角色名称" class="layui-input" value="{{$role->role_name}}">
            <b style="color:000; font-family:'仿宋' ">{{$errors->first('brand_name')}}</b> 
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">角色描述:</label>
            <div class="layui-input-block">
            <input type="text" name="role_desc" lay-verify="title" autocomplete="off" placeholder="请输入角色描述" class="layui-input" value="{{$role->role_desc}}">
            <b style="color:000; font-family:'仿宋'" >{{$errors->first('brand_url')}}</b> 
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
layui.use('element', function(){
  var element = layui.element;
  
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