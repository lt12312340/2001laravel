@extends('admin.layouts.adminshop')
@section('content')
    <!-- 内容主体区域 -->
    <!-- <div style="padding: 15px;"></div> -->

    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 50px;">
        <legend>
            <span class="layui-breadcrumb">
                <a href="/">后台首页</a>
                <a href="/demo/">商品品牌</a>
                <a><cite>品牌展示</cite></a>
            </span>
        </legend>
    </fieldset>

 <div class="layui-collapse" lay-filter="test">
              <div class="layui-colla-item">
                <h2 class="layui-colla-title">多条件搜索</h2>
                <div class="layui-colla-content">
                  <div style="padding: 15px;" id="showinput">
                    <form action="{{url('/goods/index')}}" method="get" enctype="multipart/form-data">
                      @CSRF
                      <input type="text" name="goods_name" style='width: 280px;' placeholder="请输入品牌名称" value="{{$goods_name??''}}" class="layui-input">
                      <select name="brand_id" id="">
                          <option value="">--请选择--</option>
                          @foreach($brand as $itme)
                          <option value="{{$itme->brand_id}}"{{$itme->brand_id==$brand_id ? "selected" : ""}}>{{$itme->brand_name}}</option>
                          @endforeach
                      </select><select name="cate_id" id="">
                          <option value="">--请选择--</option>
                          @foreach($cate as $itmes)
                          <option value="{{$itmes->cate_id}}"{{$itmes->cate_id==$cate_id ? "selected" : ""}}>{{$itmes->cate_name}}</option>
                          @endforeach
                      </select>
                      <button type="submit" class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>

<!-- <form class="layui-form" action="{{url('/brand')}}" >

  <div class="layui-form-item">
    <div class="layui-inline">
      <label class="layui-form-label">商品名称</label>
      <div class="layui-input-inline">
        <input type="text" name="brand_name" lay-verify="required|phone" autocomplete="off" class="layui-input" placeholder="商品名称" value="{{$query['brand_name']??''}}">
      </div>
    </div>
    <div class="layui-inline">
      <label class="layui-form-label">商品网址</label>
      <div class="layui-input-inline">
        <input type="text" name="brand_url" lay-verify="email" autocomplete="off" class="layui-input" placeholder="商品网址" value="{{$query['brand_url']??''}}">
      </div>
    </div>
    <button type="submit" class="layui-btn layui-btn-warm">搜索</button>
  </div>

</form> -->

    <div class="layui-form">
        <table class="layui-table">
            <colgroup>
            <col width="150">
            <col width="150">
            <col width="200">
            <col>
            </colgroup>
            <thead>
            <tr>
                <th>
                  <input type="checkbox" name="allcheckbox" lay-skin="primary" class="vainglory" >
                </th>
                <th>商品id</th>
                <th>商品名称</th>
                <th>商品价格</th>
                <th>商品库存</th>
                <th>商品积分</th>
                <th>是否新品</th>
                <th>是否热卖</th>
                <th>是否精品</th>
                <th>是否上架</th>
                <th>商品图片</th>
                <th>商品相册</th>
                <th>商品简介</th>
                <th>商品品牌</th>
                <th>商品分类</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($goods as $v)
            <tr goods_id="{{$v->goods_id}}">
                <td><input type="checkbox" name="brandcheck[]" lay-skin="primary"  value="{{$v->goods_id}}"></td>
                <td>{{$v->goods_id}}</td>
                <td field="goods_name" old="{{$v->goods_name}}">
                  <span class="span_name"><a href="javascript:void(0)"title="{{$v->goods_name}}">{{substr($v->goods_name,0,12)}}</a></span>...
                </td>
                <td field="goods_price" old="{{$v->goods_price}}">
                  <span class="span_name">{{$v->goods_price}}</span>
                </td>
                <td field="goods_num" old="{{$v->goods_num}}">
                  <span class="span_name">{{$v->goods_num}}</span>
                </td>
                <td field="goods_score" old="{{$v->goods_score}}">
                  <span class="span_name">{{$v->goods_score}}</span>
                </td>
                <td goods_id="{{$v->goods_id}}" class="hubei" status='{{$v->is_new}}' filed="is_new">{{$v->is_new=='1' ? "√" : "×"}}</td>
                <td goods_id="{{$v->goods_id}}" class="hubei" status='{{$v->is_hot}}' filed="is_hot">{{$v->is_hot=='1' ? "√" : "×"}}</td>
                <td goods_id="{{$v->goods_id}}" class="hubei" status='{{$v->is_best}}' filed="is_best">{{$v->is_best=='1' ? "√" : "×"}}</td>
                <td goods_id="{{$v->goods_id}}" class="hubei" status='{{$v->is_up}}' filed="is_up">{{$v->is_up=='1' ? "√" : "×"}}</td>
                <td>@if($v->goods_img)<img src="{{$v->goods_img}}" width="60"> @endif</td>
                <td>
                 @if($v->goods_imgs)
                 	@php $goods_imgs = explode("|",$v["goods_imgs"]); @endphp
                 	@foreach($goods_imgs as $vv)
                 	<img src="{{$vv}}" width="35px" alt="">
                 	@endforeach
                 @endif
                </td>
                <td field="goods_desc" old="{{$v->goods_desc}}">
                  <span class="span_name">{{$v->goods_desc}}</span>
                </td>
                <td>{{$v->brand_name}}</td>
                <td>{{$v->cate_name}}</td>
                <td>
                    <a href="javascript:void(0)" onclick="DeleteGetId({{$v->goods_id}},this)">
                    <button type="button" class="layui-btn layui-btn-danger">删除</button>
                    </a>
                    <a href="/goods/edit?goods_id={{$v->goods_id}}">
                    <button type="button" class="layui-btn layui-btn-normal">编辑</button>
                    </a>
                </td>
            </tr>
            @endforeach


            <tr>
                <td colspan="7" align="center">
                <button type="button" class="layui-btn layui-btn-warm moredel">批量删除</button>{{$goods->appends(['goods_name'=>$goods_name,'brand_id'=>$brand_id,'cate_id'=>$cate_id])->links('vendor.pagination.adminshop')}}
                </td>
            </tr>
            </tbody>
        </table>

    </div>

<script src="/static/layui/layui.js"></script>
<script src="/static/layui/jquery.js"></script>
<script>
//JavaScript代码区域
layui.use(['element','form'], function(){
  var element = layui.element;
  var form = layui.form;
  //即点即改
  layui.$(document).on('click','.span_name',function(){
	  var goods_name = $(this).children().attr("title");
      var old = $(this).parent().attr("old");
      // alert(old);
      $(this).parent().html("<input type='text' class='change_name' value="+old+">");
      $(".change_name").focus();
  });
  $(document).on('blur','.change_name',function(){
  //layui.$(".changevalue").blur(function(){
            //获取失焦对象
            var _this=$(this);
            //获取值
            var value=_this.val();
            //获取id
            var goods_id=_this.parents("tr").attr("goods_id");
            //获取字段
            var field=_this.parent().attr("field");
            var old = _this.parent().attr("old");
            if(field=="goods_name"){
                if(!value){
                    _this.parent().html("<span class='span_name'><a href='javascript:void(0)'title='"+old+"'>"+old.substring(0, 4)+"</a></span>...");
                }
                if(value==old){
                    // alert(345);
                    _this.parent().html("<span class='span_name'><a href='javascript:void(0)'title='"+old+"'>"+old.substring(0, 4)+"</a></span>...");
                    return;
                }
            }
            if(!value){
                _this.parent().html("<span class='span_name'>"+old+"</span>");
            }
            if(value==old){
                // alert(345);
                _this.parent().html("<span class='span_name'>"+old+"</span>");
                return;
            }
            $.ajax({
                //提交地址
                url:"{{url('/goods/checkge')}}",
                //提交方式
                type:"post",
                //提交内容
                data:{value:value,goods_id:goods_id,field:field},
                //设置同步异步
                async:true,
                //回调函数
                success:function(res){
                    console.log(res);
                    if(res==" ok"){
                        // alert(123);
                        if(field=="goods_name"){
                            _this.parent().attr("old",value);
                            _this.parent().html("<span class='span_name'><a href='javascript:void(0)'title='"+value+"'>"+value.substring(0, 4)+"</a></span>...");
                        }
                        _this.parent().attr("old",value);
                        _this.parent().html("<span class='span_name'>"+value+"</span>");
                    }else{
                        alert("操作有误");
                    }
                }
            })
  })

});

//是否即点即改
            $(document).on("click",".hubei",function(){
                var data = {};
                data.goods_id = $(this).attr("goods_id");
                data.status = $(this).attr("status");
                data.filed = $(this).attr("filed");
                var obj = $(this);
                $.get("/goods/ajaxji",data,function(res){
                    // console.log(res);
                    if(res.status=="true"){
                        obj.attr("status",res.msg);
                        obj.text(res.result);
                    }
                },"json")
            })

//全选
$(document).on('click','.layui-form-checkbox:eq(0)',function(){
  //alert(123321);
  var checkval = $('input[name="allcheckbox"]').prop('checked');
  //alert(checkval);
  $('input[name="brandcheck[]"]').prop('checked',checkval);
  if(checkval){
    $('.layui-form-checkbox:gt(0)').addClass('layui-form-checked');
  }else{
    $('.layui-form-checkbox:gt(0)').removeClass('layui-form-checked');
  }

})

//批量删除
$(document).on('click','.moredel',function(){
//$('.moredel').click(function(){
  //alert(123);
  var ids = new Array();
  $('input[name="brandcheck[]"]:checked').each(function(i,k){
    ids.push($(this).val())
  });
  //alert(ids);
  if(confirm('确认要删除吗?')){
      $.get('/goods/destroy/',{id:ids},function(res){
            alert(res.msg);
            //$(obj).parents('tr').hide();
            //$(obj).parents('tr').remove();
            location.reload();
          },'json')
  }

})

//删除
function DeleteGetId(goods_id,obj){
    //alert(brand_id);
    if(!goods_id){
      return;
    }

    $.get('/goods/destroy/'+goods_id,function(res){
      alert(res.msg);
      location.reload();
    },'json')
}


$(document).on('click','.layui-laypage a',function(){
  //alert(123);
  var url = $(this).attr('href');
  //alert(url);
  $.get(url,function(res){
      $('tbody').html(res);
      $('.vainglory').prop('checked',false);
      layui.use(['element','form'], function(){
      var element = layui.element;
      form = layui.form;
      form.render();
    })
  })
  return false;
})
</script>

  @endsection
