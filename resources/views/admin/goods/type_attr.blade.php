
    <tbody>
        @foreach($attr as $v)
        @php $attr_values = explode("\r\n",$v->attr_values); @endphp
        @if($v->attr_type == 1 && $v->attr_input_type == 2)

        <tr>
            <td class="label">{{$v->attr_name}}</td>
            <td>
                <input type="hidden" name="attr_id[]" value="{{$v->attr_id}}">
                <select name="attr_value[]">
                    <option value="">请选择...</option>
                    @foreach($attr_values as $vv)
                    <option value="{{$vv}}">{{$vv}}</option>
                    @endforeach
                </select>  
                <input type="hidden" name="attr_price[]" value="0">
            </td>
        </tr>
        @endif
        @if($v->attr_type == 1 && $v->attr_input_type == 1)
        <tr>
            <td class="label">{{$v->attr_name}}</td>
            <td>
                <input type="hidden" name="attr_id[]" value="{{$v->attr_id}}">
                <input name="attr_value[]" type="text" value="" size="40">
                <input type="hidden" name="attr_price[]" value="0">
            </td>
        </tr>
        @endif
        @if($v->attr_type == 2 && $v->attr_input_type == 2)
        <tr>
            <td class="label"><a href="javascript:;" onclick="addSpec(this)">[+]</a>{{$v->attr_name}}</td>
            <td>
                <input type="hidden" name="attr_id[]" value="{{$v->attr_id}}">
                <select name="attr_value[]">
                    <option value="">请选择...</option>
                    @foreach($attr_values as $vv)
                    <option value="{{$vv}}">{{$vv}}</option>
                    @endforeach
                </select> 
                属性价格 <input type="text" name="attr_price[]" value="" size="5" maxlength="10">
            </td>
        </tr>
        @endif
        @if($v->attr_type == 2 && $v->attr_input_type == 1)
        <tr>
            <td class="label"><a href="javascript:;" onclick="addSpec(this)">[+]</a>{{$v->attr_name}}</td>
            <td>
                <input type="hidden" name="attr_id[]" value="{{$v->attr_id}}">
                <input name="attr_value[]" type="text" value="" size="40"> 
                属性价格 <input type="text" name="attr_price[]" value="" size="5" maxlength="10">
            </td>
        </tr>
        @endif
        @endforeach
    </tbody>
