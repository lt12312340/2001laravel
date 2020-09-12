@extends('admin.layouts.adminshop')  
@section('content')
  
  
    <!-- 内容主体区域 -->
    <!-- <div style="padding: 15px;"></div> -->

    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 50px;">
        <legend>
            <span class="layui-breadcrumb">
                <a href="/">后台首页</a>
                <a href="/demo/">分类管理</a>
                <a><cite>分类添加</cite></a>
            </span>
        </legend>
    </fieldset>
<form class="layui-form" action="{{url('/category/store')}}" method="post">
        @csrf
        <div class="layui-form-item">
            <label class="layui-form-label">分类名称:</label>
            <div class="layui-input-block">
            <input type="text" name="cate_name" lay-verify="title" autocomplete="off" placeholder="请输入分类名称" class="layui-input">
            <b style="color:#ff0000; font-family:'仿宋' ">{{$errors->first('cate_name')}}</b> 
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">父级分类:</label>
            <div class="layui-input-block">
            <!-- 下拉选择项 -->
                <div class="layui-input-inline">
                    <select name="pid" lay-verify="required" lay-search="">
                        <option value="0">父级分类</option>
                        @foreach($cate as $v)
                            <option value="{{$v->cate_id}}">{{str_repeat('|——',$v->level)}}{{$v->cate_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">是否展示:</label>
            <div class="layui-input-block">
                <input type="radio" name="cate_show" value="1" title="是" checked="">
                <input type="radio" name="cate_show" value="2" title="否">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">是否在导航栏展示:</label>
            <div class="layui-input-block">
                <input type="radio" name="cate_nav_show" value="1" title="是" checked="">
                <input type="radio" name="cate_nav_show" value="2" title="否">
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