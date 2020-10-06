@extends('admin.layouts.adminshop')
@section('content')


    <!-- 内容主体区域 -->
    <!-- <div style="padding: 15px;"></div> -->

    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 50px;">
        <legend>
            <span class="layui-breadcrumb">
                <a href="/">后台首页</a>
                <a href="/demo/">商品管理</a>
                <a><cite>商品添加</cite></a>
            </span>
        </legend>
    </fieldset>

    <form class="layui-form" action="{{url('/goods/store')}}" method="post" enctype="multipart/form-data">
        @csrf
    <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
      <ul class="layui-tab-title">
        <li class="layui-this">通用信息</li>
        <li>详细描述</li>
        <li>商品属性</li>
        <li>商品相册</li>
        <li>订单管理</li>
      </ul>
      
      <div class="layui-tab-content" style="height: 100px;">
        <!-- 通用信息 -->
        <div class="layui-tab-item layui-show">
        
          <div class="layui-form-item">
              <label class="layui-form-label">商品名称:</label>
              <div class="layui-input-block">
              <input type="text" name="goods_name" lay-verify="title" autocomplete="off" placeholder="请输入商品名称" class="layui-input">
              <b style="color:#f00; font-family:'仿宋' ">{{$errors->first('goods_name')}}</b>
              </div>
          </div>

          <div class="layui-form-item">
              <label class="layui-form-label">商品价格:</label>
              <div class="layui-input-block">
              <input type="text" name="goods_price" lay-verify="title" autocomplete="off" placeholder="请输入商品价格" class="layui-input">
              <b style="color:#f00; font-family:'仿宋' ">{{$errors->first('goods_price')}}</b>
              </div>
          </div>

          <div class="layui-form-item">
              <label class="layui-form-label">商品库存:</label>
              <div class="layui-input-block">
              <input type="text" name="goods_num" lay-verify="title" autocomplete="off" placeholder="请输入商品库存" class="layui-input">
              <b style="color:#f00; font-family:'仿宋' ">{{$errors->first('goods_num')}}</b>
              </div>
          </div>

          <div class="layui-form-item">
              <label class="layui-form-label">商品积分:</label>
              <div class="layui-input-block">
              <input type="text" name="goods_score" lay-verify="title" autocomplete="off" placeholder="请输入商品积分" class="layui-input">
              <b style="color:#f00; font-family:'仿宋' ">{{$errors->first('goods_score')}}</b>
              </div>
          </div>

          <div class="layui-form-item">
              <label class="layui-form-label">商品图片:</label>
              <div class="layui-input-block">
              <div class="layui-upload-drag" id="test10">
                <i class="layui-icon">&#xe67c;</i>
                <p>点击上传，或将文件拖拽到此处</p>
                <div class="layui-hide" id="uploadDemoView">
                  <hr>
                  <img src="" alt="上传成功后渲染" style="max-width: 196px">
                </div>
              </div>
              <input type="hidden" name="goods_img">
              </div>
          </div>

          <div class="layui-form-item" pane="">
              <label class="layui-form-label">是否新品:</label>
              <div class="layui-input-block">
                <input type="radio" name="is_new" value="1" title="是" checked="">
                <input type="radio" name="is_new" value="2" title="否">
              </div>
          </div>

            <div class="layui-form-item" pane="">
              <label class="layui-form-label">是否热卖:</label>
              <div class="layui-input-block">
                <input type="radio" name="is_hot" value="1" title="是" checked="">
                <input type="radio" name="is_hot" value="2" title="否">
              </div>
            </div>

            <div class="layui-form-item" pane="">
                <label class="layui-form-label">是否精品:</label>
                <div class="layui-input-block">
                  <input type="radio" name="is_best" value="1" title="是" checked="">
                  <input type="radio" name="is_best" value="2" title="否">
                </div>
            </div>

              <div class="layui-form-item" pane="">
                <label class="layui-form-label">是否上架:</label>
                <div class="layui-input-block">
                  <input type="radio" name="is_up" value="1" title="是" checked="">
                  <input type="radio" name="is_up" value="2" title="否">
                </div>
              </div>

              <div class="layui-form-item" pane="">
                <label class="layui-form-label">是否首页推荐:</label>
                <div class="layui-input-block">
                  <input type="radio" name="is_index_slice" value="1" title="是" checked="">
                  <input type="radio" name="is_index_slice" value="2" title="否">
                </div>
              </div>

              <div class="layui-form-item">
                  <label class="layui-form-label">商品品牌</label>
                  <div class="layui-input-block">
                    <select name="brand_id" lay-filter="aihao">
                      <option value="">--请选择--</option>
                      @foreach($brand as $v)
                      <option value="{{$v->brand_id}}">{{$v->brand_name}}</option>
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
                        <option value="{{$vv->cate_id}}">{{$vv->cate_name}}</option>
                        @endforeach
                      </select>
                    </div>
                </div>

          
              

        </div>  
        
        <!-- 详细描述 -->
        <div class="layui-tab-item">
          
            <textarea id="demo" style="display: none;" name="goods_desc"></textarea>
          
        </div>

        <!-- 商品属性 -->
        <div class="layui-tab-item">

        <table width="90%" id="properties-table" style="display: table;" align="center">
          <tbody>
            <tr>
              <td>商品类型：</td>
              <td>
                <select name="cat_id" lay-filter="demo">
                  <option value="0">请选择商品类型</option>
                  @foreach($goods_type as $v)
                          <option value="{{$v->cat_id}}">{{$v->cat_name}}</option>
                  @endforeach
                </select>
                <br>
              <span class="notice-span" style="display:block" id="noticeGoodsType">请选择商品的所属类型，进而完善此商品的属性</span></td>
            </tr>
          <tr>
            <td id="tbody-goodsAttr" colspan="2" style="padding:0">
              <table class="layui-table" width="100%" id="attrTable"></table>
            </td>
          </tr>
          </tbody>
        </table>

        </div>

        <!-- 商品相册 -->
        <div class="layui-tab-item">
          <div class="layui-form-item">
              <label class="layui-form-label">商品相册:</label>

              <div class="layui-upload">
                <button type="button" class="layui-btn" id="test2">多图片上传</button>
                <blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px;">
                  预览图：
                  <div class="layui-upload-list" id="demo2"></div>
              </blockquote>
              </div>
          </div>
        </div>
        <div class="layui-tab-item">内容5</div>

        <!-- 按钮 -->
        <div class="layui-form-item">
                <label class="layui-form-label"></label>
                <div class="layui-input-block" align="center">
                <button type="submit" class="layui-btn">添加</button>
                <button type="reset" class="layui-btn layui-btn-primary">清除</button>
        </div>
        
      </div>
      
      
    </div> 
    </form>
   <!-- @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li style="padding-left:35px; padding-bottom:10px; color:#0000ff" >{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif -->

  </div>



<script src="/static/layui/layui.js"></script>
<script src="/static/layui/jquery.js"></script>

<script>
//JavaScript代码区域
layui.use('element', function(){
  var element = layui.element;

});
layui.use('form', function(){
  var form = layui.form;
  form.on('select(demo)', function(data){
    // alert(data.value);
    var cat_id = data.value;
    $.get('/goods/getattr',{cat_id:cat_id},function(res){
      $("#attrTable").html(res);
      layui.use(['element','form'], function(){
      var element = layui.element;
      form = layui.form;
      form.render();
    })
    })  
	});
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
        $('#demo2').append('<img src="'+ res["data"] +'" alt="'+ res["data"] +'" class="layui-upload-img" width="100px;">')
        $("#demo2").append('<input type="hidden" name="goods_imgs[]" value="'+res["data"]+'">');
        // console.log(res["data"]);
      }
    });

   
});
 
function addSpec(obj){
    var newobj = $(obj).parent().parent().clone();
    newobj.find('a').html('[-]').attr('onclick','delSpec(this)');
    $(obj).parent().parent().after(newobj);
    layui.use(['element','form'], function(){
      var element = layui.element;
      form = layui.form;
      form.render();
    });
}

function delSpec(obj){
  $(obj).parent().parent().remove();
}
</script>

<script>
layui.use('layedit', function(){
var layedit = layui.layedit;
layedit.set({
  uploadImage: {
    url: '/goods/upload' //接口url
    ,type: 'post' //默认post
  }
});
layedit.build('demo'); //建立编辑器
});
</script>
  
@endsection
