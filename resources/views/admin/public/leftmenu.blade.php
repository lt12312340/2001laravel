<div class="layui-side layui-bg-black">
    <div class="layui-side-scroll">
      <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
      <ul class="layui-nav layui-nav-tree"  lay-filter="test">
      @php $name = Route::currentRouteName(); @endphp
      
      @foreach($priv as $v)
        <li @if(strpos($name,$v->function)!==false) class="layui-nav-item layui-nav-itemed" @else class="layui-nav-item" @endif>
          <a class="" href="javascript:;">{{$v->names}}</a>
          @if($v->son) 
          <dl class="layui-nav-child">
            @foreach($v->son as $value)
            <dd @if($name==$value->function) class="layui-this" @endif><a href="{{$value->route}}">{{$value->names}}</a></dd>
            @endforeach
          </dl>
          @endif
        </li>
      @endforeach
      </ul>
    </div>
  </div>
