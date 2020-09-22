@extends('admin.layouts.adminshop')
@section('content')


    <!-- 内容主体区域 -->
    <!-- <div style="padding: 15px;"></div> -->

    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 50px;">
        <legend>
            <span class="layui-breadcrumb">
                <a href="/">后台首页</a>
                <a href="/demo/">商品类型管理</a>
                <a><cite>添加类型</cite></a>
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
<form class="layui-form" action="{{url('/goods_type/store')}}" method="post">
        @csrf
        <div class="layui-form-item">
            <label class="layui-form-label">分类名称:</label>
            <div class="layui-input-block">
            <input type="text" name="cat_name" lay-verify="title" autocomplete="off" placeholder="请输入分类名称" class="layui-input">
            <!-- <b style="color:#f00; font-family:'仿宋' ">{{$errors->first('goods_name')}}</b> -->
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">是否启用:</label>
            <div class="layui-input-block">
                <input type="radio" name="enabled" value="1" title="是" checked="">
                <input type="radio" name="enabled" value="2" title="否">
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
layui.use('element', function(){
  var element = layui.element;

});
layui.use('form', function(){
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

});
</script>

@endsection
