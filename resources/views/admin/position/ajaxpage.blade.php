@foreach($position as $v)
            <tr brand_id = {{$v->position_id}}>
                <td><input type="checkbox" name="brandcheck[]" lay-skin="primary"  value="{{$v->position_id}}"></td>
                <td>{{$v->position_id}}</td>
                <td field="position_name">
                  <span class="brand_name">{{$v->position_name}}</span>
                  <input type="text" class="changevalue" value="{{$v->position_name}}" style="display:none">
                </td>
                <td field="ad_width">
                  <span class="brand_name">{{$v->ad_width}}</span>
                  <input type="text" class="changevalue" value="{{$v->ad_width}}" style="display:none">
                </td>
                <td field="ad_height">
                  <span class="brand_name">{{$v->ad_height}}</span>
                  <input type="text" class="changevalue" value="{{$v->ad_height}}" style="display:none">
                </td>
                <td field="position_desc">
                  <span class="brand_name">{{$v->position_desc}}</span>
                  <input type="text" class="changevalue" value="{{$v->position_desc}}" style="display:none">
                </td>
                <td>
                    <a href="javascript:void(0)" onclick="DeleteGetId({{$v->position_id}},this)">
                    <button type="button" class="layui-btn layui-btn-danger">删除</button>
                    </a>
                    <a href="{{url('brand/edit/'.$v->position_id)}}">
                    <button type="button" class="layui-btn layui-btn-normal">编辑</button>
                    </a>
                    <a href="{{url('ad/position/'.$v->position_id)}}">
                    <button type="button" class="layui-btn">查看广告</button>
                    </a>
                    <a href="{{url('ad/position/createhtml/'.$v->position_id)}}">
                    <button type="button" class="layui-btn">生成广告</button>
                    </a>
                </td>
            </tr>
            @endforeach
            
            
            <tr>
                <td colspan="7" align="center">
                <button type="button" class="layui-btn layui-btn-warm moredel">批量删除</button>{{$position->links('vendor.pagination.adminshop')}}
                </td>
            </tr>