@foreach($attribute as $v)
            <tr attr_id = {{$v->attr_id}}>
                <td><input type="checkbox" name="attrcheck[]" lay-skin="primary"  value="{{$v->attr_id}}"></td>
                <td>{{$v->attr_id}}</td>
                <td field="attr_name">
                  <span class="brand_name">{{$v->attr_name}}</span>
                  <input type="text" class="changevalue" value="{{$v->attr_name}}" style="display:none">
                </td>
                <td>
                  {{$v->cat_name}}
                </td>
                <td field="attr_values">
                  <span class="brand_name">{{$v->attr_values}}</span>
                  <input type="text" class="changevalue" value="{{$v->attr_values}}" style="display:none">
                </td>
                <td>
                    <a href="javascript:void(0)" onclick="DeleteGetId({{$v->attr_id}},this)">
                    <button type="button" class="layui-btn layui-btn-danger">删除</button>
                    </a>
                    <a href="{{url('brand/edit/'.$v->brand_id)}}">
                    <button type="button" class="layui-btn layui-btn-normal">编辑</button>
                    </a>
                </td>
            </tr>
            @endforeach
            
            
            <tr>
                <td colspan="6" align="center">
                <button type="button" class="layui-btn layui-btn-warm moredel">批量删除</button>{{$attribute->links('vendor.pagination.adminshop')}}
                </td>
            </tr>