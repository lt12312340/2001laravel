@foreach($role as $v)
            <tr role_id = {{$v->role_id}}>
                <td><input type="checkbox" name="rolecheck[]" lay-skin="primary"  value="{{$v->role_id}}"></td>
                <td>{{$v->role_id}}</td>
                <td field="role_name">
                  <span class="change">{{$v->role_name}}</span>
                  <input type="text" class="changevalue" value="{{$v->role_name}}" style="display:none">
                </td>
                <td field="role_desc">
                  <span class="change">{{$v->role_desc}}</span>
                  <input type="text" class="changevalue" value="{{$v->role_desc}}" style="display:none">
                </td>
                <td>
                    <a href="javascript:void(0)" onclick="DeleteGetId({{$v->role_id}},this)">
                    <button type="button" class="layui-btn layui-btn-danger">删除</button>
                    </a>
                    <a href="{{url('role/edit/'.$v->role_id)}}">
                    <button type="button" class="layui-btn layui-btn-normal">编辑</button>
                    </a>
                </td>
            </tr>
            @endforeach
            
            
            <tr>
                <td colspan="5" align="center">
                <button type="button" class="layui-btn layui-btn-warm moredel">批量删除</button>{{$role->appends($query)->links('vendor.pagination.adminshop')}}
                </td>
            </tr>