@extends('admin.layouts.adminshop')  
@section('content')
  
  
    <!-- 内容主体区域 -->
    <!-- <div style="padding: 15px;"></div> -->

    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 50px;">
        <legend>
            <span class="layui-breadcrumb">
                <a href="/">后台首页</a>
                <a href="/demo/">权限管理</a>
                <a><cite>权限添加</cite></a>
            </span>
        </legend>
    </fieldset>
    <!-- @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li style="padding-left:35px; padding-bottom:10px; color:#0000ff" >{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif -->
<form class="layui-form" action="{{url('/menu/store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="layui-form-item">
            <label class="layui-form-label">权限名称:</label>
            <div class="layui-input-block">
            <input type="text" name="names" lay-verify="title" autocomplete="off" placeholder="请输入权限名称" class="layui-input">
            <b style="color:000; font-family:'仿宋' ">{{$errors->first('names')}}</b> 
            </div>
        </div>

        <div class="layui-inline">
          <label class="layui-form-label">父级菜单</label>
          <div class="layui-input-inline">
            <select name="parent_id" lay-verify="required" lay-search="">
              <option value="0">直接选择或搜索选择</option>
              @foreach($menu as $v)
              <option value="{{$v->id}}">{{str_repeat('|——',$v->level)}}{{$v->names}}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">模块:</label>
            <div class="layui-input-block">
            <input type="text" name="model" lay-verify="title" autocomplete="off" placeholder="请输入模块" class="layui-input">
            <b style="color:000; font-family:'仿宋'" >{{$errors->first('model')}}</b> 
            </div>
        </div>


        <div class="layui-form-item">
            <label class="layui-form-label">控制器:</label>
            <div class="layui-input-block">
            <input type="text" name="controller" lay-verify="title" autocomplete="off" placeholder="请输入控制器" class="layui-input">
            <b style="color:000; font-family:'仿宋'" >{{$errors->first('controller')}}</b> 
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">路由别名:</label>
            <div class="layui-input-block">
            <input type="text" name="function" lay-verify="title" autocomplete="off" placeholder="请输入路由别名" class="layui-input">
            <b style="color:000; font-family:'仿宋'" >{{$errors->first('function')}}</b> 
            </div>
        </div> 

         <div class="layui-form-item">
            <label class="layui-form-label">路由:</label>
            <div class="layui-input-block">
            <input type="text" name="route" lay-verify="title" autocomplete="off" placeholder="请输入路由" class="layui-input">
            <b style="color:000; font-family:'仿宋'" >{{$errors->first('route')}}</b> 
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
  var element = layui.element,
      form = layui.form;
  
});

// layui.use('upload', function(){
//   var $ = layui.jquery
//   ,upload = layui.upload;

//   $.ajaxSetup({
//     headers: {
//     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//     }
//   });

//   //拖拽上传
//   upload.render({
//     elem: '#test10'
//     ,url: 'http://www.laravel01.com/brand/upload' //改成您自己的上传接口
//     ,done: function(res){
//       layer.msg(res.msg);
//       layui.$('#uploadDemoView').removeClass('layui-hide').find('img').attr('src', res.data);
//       //console.log(res)

//       layui.$('input[name="brand_logo"]').attr('value',res.data);
//     }
//   });
// });
</script>

@endsection