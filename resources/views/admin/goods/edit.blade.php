@extends('admin.layouts.adminshop')
@section('content')


    <!-- 内容主体区域 -->
    <!-- <div style="padding: 15px;"></div> -->

    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 50px;">
        <legend>
            <span class="layui-breadcrumb">
                <a href="/">后台首页</a>
                <a href="/demo/">商品管理</a>
                <a><cite>商品修改</cite></a>
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
<form class="layui-form" action="{{url('/goods/update/'.$goods->goods_id)}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="layui-form-item">
            <label class="layui-form-label">商品名称:</label>
            <div class="layui-input-block">
            <input type="text" name="goods_name" lay-verify="title" autocomplete="off" placeholder="请输入商品名称" class="layui-input" value="{{$goods->goods_name}}">
            <b style="color:#f00; font-family:'仿宋' ">{{$errors->first('goods_name')}}</b>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">商品价格:</label>
            <div class="layui-input-block">
            <input type="text" name="goods_price" lay-verify="title" autocomplete="off" placeholder="请输入商品价格" class="layui-input" value="{{$goods->goods_price}}">
            <b style="color:#f00; font-family:'仿宋' ">{{$errors->first('goods_price')}}</b>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">商品库存:</label>
            <div class="layui-input-block">
            <input type="text" name="goods_num" lay-verify="title" autocomplete="off" placeholder="请输入商品库存" class="layui-input" value="{{$goods->goods_num}}">
            <b style="color:#f00; font-family:'仿宋' ">{{$errors->first('goods_num')}}</b>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">商品积分:</label>
            <div class="layui-input-block">
            <input type="text" name="goods_score" lay-verify="title" autocomplete="off" placeholder="请输入商品积分" class="layui-input" value="{{$goods->goods_score}}">
            <b style="color:#f00; font-family:'仿宋' ">{{$errors->first('goods_score')}}</b>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">商品图片:</label>
            <div class="layui-input-block">
            <div class="layui-upload-drag" id="test10">
              <i class="layui-icon">&#xe67c;</i>
              <p>点击上传，或将文件拖拽到此处</p>
              <div @if(!$goods->goods_img) class="layui-hide" @endif id="uploadDemoView">
                <hr>
                <img src="{{$goods->goods_img}}" alt="上传成功后渲染" style="max-width: 196px">
              </div>
            </div>
            <input type="hidden" name="goods_img" @if($goods->goods_img) value="{{$goods->goods_img}}" @endif>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">商品相册:</label>

            <div class="layui-upload">
              <button type="button" class="layui-btn" id="test2">多图片上传</button>
              <blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px;">
                预览图：
                <div class="layui-upload-list" id="demo2">
                    @if($goods->goods_imgs)
                    	@php $goods_imgs = explode("|",$goods["goods_imgs"]); @endphp
                    	@foreach($goods_imgs as $vvv)
                    	<img src="{{$vvv}}" alt="{{$vvv}}" class="layui-upload-img" width="100px;">
                        <input type="hidden" name="goods_imgs[]" value="{{$vvv}}">
                    	@endforeach
                    @endif

                </div>
             </blockquote>
            </div>
         </div>

         <div class="layui-form-item" pane="">
            <label class="layui-form-label">是否新品:</label>
            <div class="layui-input-block">
              <input type="radio" name="is_new" value="1" title="是" {{$goods->is_new=="1" ? "checked" : ""}}>
              <input type="radio" name="is_new" value="2" title="否" {{$goods->is_new=="2" ? "checked" : ""}}>
            </div>
          </div>

          <div class="layui-form-item" pane="">
             <label class="layui-form-label">是否热卖:</label>
             <div class="layui-input-block">
               <input type="radio" name="is_hot" value="1" title="是" {{$goods->is_hot=="1" ? "checked" : ""}}>
               <input type="radio" name="is_hot" value="2" title="否" {{$goods->is_hot=="2" ? "checked" : ""}}>
             </div>
           </div>

           <div class="layui-form-item" pane="">
              <label class="layui-form-label">是否精品:</label>
              <div class="layui-input-block">
                <input type="radio" name="is_best" value="1" title="是" {{$goods->is_best=="1" ? "checked" : ""}}>
                <input type="radio" name="is_best" value="2" title="否" {{$goods->is_best=="2" ? "checked" : ""}}>
              </div>
            </div>

            <div class="layui-form-item" pane="">
               <label class="layui-form-label">是否上架:</label>
               <div class="layui-input-block">
                 <input type="radio" name="is_up" value="1" title="是" {{$goods->is_up=="1" ? "checked" : ""}}>
                 <input type="radio" name="is_up" value="2" title="否" {{$goods->is_up=="2" ? "checked" : ""}}>
               </div>
             </div>

             <div class="layui-form-item">
                 <label class="layui-form-label">商品品牌</label>
                 <div class="layui-input-block">
                   <select name="brand_id" lay-filter="aihao">
                     <option value="">--请选择--</option>
                     @foreach($brand as $v)
                     <option value="{{$v->brand_id}}" {{$v->brand_id==$goods->brand_id ? "selected" : ""}}>{{$v->brand_name}}</option>
                     @endforeach
                   </select>
                 </div>
               </div>

               <div class="layui-form-item">
                   <label class="layui-form-label">商品分类</label>
                   <div class="layui-input-block">
                     <select name="cate_id" lay-filter="aihao">
                       <option value="">--请选择--</option>
                       @foreach($cate as $vv)
                       <option value="{{$vv->cate_id}}" {{$vv->cate_id==$goods->cate_id ? "selected" : ""}}>{{$vv->cate_name}}</option>
                       @endforeach
                     </select>
                   </div>
                 </div>

        <div class="layui-form-item">
            <label class="layui-form-label">商品简介:</label>
            <div class="layui-input-block">
            <input type="text" name="goods_desc" lay-verify="title" autocomplete="off" placeholder="请输入商品简介" class="layui-input" value="{{$goods->goods_desc}}">
            <b style="color:#f00; font-family:'仿宋'" >{{$errors->first('goods_desc')}}</b>
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

  //拖拽上传
  upload.render({
    elem: '#test10'
    ,url: 'http://www.laravel01.com/goods/upload' //改成您自己的上传接口
    ,done: function(res){
      layer.msg(res.msg);
      layui.$('#uploadDemoView').removeClass('layui-hide').find('img').attr('src', res.data);
      //console.log(res)

      layui.$('input[name="goods_img"]').attr('value',res.data);
    }
  });

   //多图片上传
    upload.render({
      elem: '#test2'
      ,url: 'http://www.laravel01.com/goods/upload' //改成您自己的上传接口
      ,multiple: true
      ,before: function(obj){
        //预读本地文件示例，不支持ie8
        obj.preview(function(index, file, result){
            // console.log(result);
          // $('#demo2').append('<img src="'+ result +'" alt="'+ file.name +'" class="layui-upload-img" width="100px;">')
          // $("#demo2").append('<input type="hidden" name="goods_imgs[]" value="'+result.data+'">');
        });
      }
      ,done: function(res){
        //上传完毕
        // alert(123);
        // $('#demo2').empty();
        $('#demo2').append('<img src="'+ res["data"] +'" alt="'+ res["data"] +'" class="layui-upload-img" width="100px;">')
        $("#demo2").append('<input type="hidden" name="goods_imgs[]" value="'+res["data"]+'">');
        // console.log(res["data"]);
      }
    });
});
</script>

@endsection
