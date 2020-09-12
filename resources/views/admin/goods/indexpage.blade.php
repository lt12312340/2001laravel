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
                <td field="goods_desc">
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
                <button type="button" class="layui-btn layui-btn-warm moredel">批量删除</button>{{$goods->appends(["goods_name"=>$goods_name,'brand_id'=>$brand_id,'cate_id'=>$cate_id])->links('vendor.pagination.adminshop')}}
                </td>
            </tr>
