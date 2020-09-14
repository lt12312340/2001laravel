@foreach($menu as $v)
            <tr brand_id = {{$v->id}}>
                <td><input type="checkbox" name="brandcheck[]" value="{{$v->id}}" lay-skin="primary"  ></td>
                <td>{{$v->id}}</td>
                <td field="names">
                  <span class="names">{{$v->names}}</span>
                  <input type="text" class="changevalue" value="{{$v->names}}" style="display:none">
                </td>
                <td>{{$v->mdoel}}</td>
                <td>{{$v->controller}}</td>
                <td>{{$v->function}}</td>
                <td>{{$v->route}}</td>
                <td>
                    <a href="javascript:void(0)" onclick="DeleteGetId({{$v->id}},this)">
                    <button type="button" class="layui-btn layui-btn-danger">删除</button>
                    </a>
                    <a href="{{url('menu/edit/'.$v->id)}}">
                    <button type="button" class="layui-btn layui-btn-normal">编辑</button>
                    </a>
                </td>
            </tr>
            @endforeach
            
            
            <tr>
                <td colspan="8" align="center">
                <button type="button" class="layui-btn layui-btn-warm moredel">批量删除</button>{{$menu->appends($query)->links('vendor.pagination.adminshop')}}
                </td>
            </tr>