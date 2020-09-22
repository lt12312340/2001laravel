@foreach($goods_type as $v)
            <tr cat_id="{{$v->cat_id}}">
                <td><input type="checkbox" name="goodstypecheck[]" lay-skin="primary"  value="{{$v->cat_id}}"></td>
                <td>{{$v->cat_id}}</td>
                <td field="cat_name">
                  <span class="change">{{$v->cat_name}}</span>
                  <input type="text" class="changevalue" value="{{$v->cat_name}}" style="display:none">
                </td>

                <td field="enabled" class="changevalue" value="{{$v->enabled}}">
                  @if($v->enabled == 1) √ @else × @endif
                </td>

                <td>
                    <a href="javascript:void(0)" onclick="DeleteGetId({{$v->cat_id}},this)">
                    <button type="button" class="layui-btn layui-btn-danger">删除</button>
                    </a>
                    <a href="{{url('/goods_type/edit/'.$v->cat_id)}}">
                    <button type="button" class="layui-btn layui-btn-normal">编辑</button>
                    </a>
                    <a href="{{url('/goods_type/attrshow/'.$v->cat_id)}}">
                    <button type="button" class="layui-btn" >属性列表</button>
                    </a>
                </td>
            </tr>
            @endforeach


            <tr>
                <td colspan="7" align="center">
                <button type="button" class="layui-btn layui-btn-warm moredel">批量删除</button>
                {{$goods_type->appends(["cat_name"=>$cat_name])->links('vendor.pagination.adminshop')}}
                </td>
            </tr>