@if($address)
	@foreach($address as $v)
	<div>
	    <div address_id="$v['address_id']" class="con name selected"><a href="javascript:;" >{{$v['consignee']}}<span title="点击取消选择">&nbsp;</a></div>
	    <div class="con address">{{$v['consignee']}} {{$v['address']}} {{$v['address_name']}} <span>{{substr_replace($v['tel'],'****',3,4)}}</span>
            <span class="base">默认地址</span>
            <span class="edittext"><a data-toggle="modal" data-target=".edit" data-keyboard="false" >编辑</a>&nbsp;&nbsp;<a href="javascript:;">删除</a></span>
		</div>
		<div class="clearfix"></div>
	</div>
	@endforeach
@endif
