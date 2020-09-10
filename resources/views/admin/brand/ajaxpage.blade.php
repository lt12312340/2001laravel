@foreach($brand as $v)
            <tr brand_id = {{$v->brand_id}}>
                <td><input type="checkbox" name="brandcheck[]" lay-skin="primary"  ></td>
                <td>{{$v->brand_id}}</td>
                <td field="brand_name">
                  <span class="brand_name">{{$v->brand_name}}</span>
                  <input type="text" class="changevalue" value="{{$v->brand_name}}" style="display:none">
                </td>
                <td>{{$v->brand_url}}</td>
                <td>@if($v->brand_logo)<img src="{{$v->brand_logo}}" width="60"> @endif</td>
                <td>{{$v->brand_desc}}</td>
                <td>
                    <a href="javascript:void(0)" onclick="DeleteGetId({{$v->brand_id}},this)">
                    <button type="button" class="layui-btn layui-btn-danger">删除</button>
                    </a>
                    <a href="{{url('brand/edit/'.$v->brand_id)}}">
                    <button type="button" class="layui-btn layui-btn-normal">编辑</button>
                    </a>
                </td>
            </tr>
            @endforeach
            
            
            <tr>
                <td colspan="7" align="center">
                <button type="button" class="layui-btn layui-btn-warm moredel">批量删除</button>{{$brand->appends($query)->links('vendor.pagination.adminshop')}}
                </td>
            </tr>