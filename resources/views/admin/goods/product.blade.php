@extends('admin.layouts.adminshop')
@section('content')
<fieldset class="layui-elem-field layui-field-title" style="margin-top: 50px;">
        <legend>
            <span class="layui-breadcrumb">
                <a href="/">后台首页</a>
                <a href="/demo/">商品添加</a>
                <a><cite>货品入库</cite></a>
            </span>
        </legend>
</fieldset>

<form method="post" action="{{url('/goods/product')}}" name="addForm" id="addForm">
@csrf
<input type="hidden" name="goods_id" value="{{$goods->goods_id}}">

<table width="100%" cellpadding="3" cellspacing="1" id="table_list">
    <tbody><tr>
      <th colspan="20" scope="col">商品名称：{{$goods->goods_name}}&nbsp;&nbsp;&nbsp;&nbsp;货号：ECS000074</th>
    </tr>
    <tr>
      <!-- start for specifications -->
        @if($goods_specs['attr_name'])
        @foreach($goods_specs['attr_name'] as $v)
            <td scope="col" style="background-color: rgb(255, 255, 255);"><div align="center"><strong>{{$v}}</strong></div></td>
        @endforeach
        @endif
            <!-- end for specifications -->
      <td class="label_2" style="background-color: rgb(255, 255, 255);">货号</td>
      <td class="label_2" style="background-color: rgb(255, 255, 255);">库存</td>
      <td class="label_2" style="background-color: rgb(255, 255, 255);">&nbsp;</td>
    </tr>

    
    <tr id="attr_row">
    <!-- start for specifications_value -->
    @if($goods_specs['attr_values'])
    @foreach($goods_specs['attr_values'] as $k => $v)
        <td align="center" style="background-color: rgb(244, 250, 251);">
            <select name="attr[{{$k}}][]">
                    <option value="" selected="">请选择...</option>
                    @foreach($v as $key => $val)
                    <option value="{{$key}}">{{$val}}</option>
                    @endforeach
            </select>
        </td>
    @endforeach
    @endif
        <!-- end for specifications_value -->

      <td class="label_2" style="background-color: rgb(244, 250, 251);"><input type="text" name="product_sn[]" value="" size="20"></td>
      <td class="label_2" style="background-color: rgb(244, 250, 251);"><input type="text" name="product_number[]" value="1" size="10"></td>
      <td style="background-color: rgb(244, 250, 251);"><input type="button" class="button" value=" + " onclick="javascript:add_attr_product(this);"></td>
    </tr>

    <tr>
      <td align="center" colspan="5" style="background-color: rgb(255, 255, 255);">
        <input type="submit" class="button" value=" 保存 " onclick="checkgood_sn()">
      </td>
    </tr>
  </tbody></table>
  </form>

<script src="/static/layui/layui.js"></script>
<script src="/static/layui/jquery.js"></script>
<script>
//JavaScript代码区域
layui.use(['element','form'], function(){
  var element = layui.element;
  var form = layui.form;
});
</script>

<script>
function add_attr_product(obj){
    var newobj = $(obj).parent().parent().clone();
    newobj.find('.button').val(" -  ").attr('onclick','delSpec(this)');
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

@endsection