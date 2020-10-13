<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE">
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
	<title>结算页</title>

    <link rel="stylesheet" type="text/css" href="/static/index/css/webbase.css" />
    <link rel="stylesheet" type="text/css" href="/static/index/css/pages-getOrderInfo.css" />
</head>

<body>
	<!--head-->
	@include('index.public.top')
	<div class="cart py-container">
		<!--logoArea-->
		<div class="logoArea">
			<div class="fl logo"><span class="title">结算页</span></div>
			<div class="fr search">
				<form class="sui-form form-inline">
					<div class="input-append">
						<input type="text" type="text" class="input-error input-xxlarge" placeholder="品优购自营" />
						<button class="sui-btn btn-xlarge btn-danger" type="button">搜索</button>
					</div>
				</form>
			</div>
		</div>
		<!--主内容-->
	<form action="{{url('/order')}}" method="post" class="sui-form form-horizontal"> 
	@csrf
		<div class="checkout py-container">
		
			<div class="checkout-tit">
				<h4 class="tit-txt">填写并核对订单信息</h4>
			</div>
			<div class="checkout-steps">
				<!--收件人信息-->
				
				<div class="step-tit">
					<h5>收件人信息<span><a data-toggle="modal" data-target=".edit" data-keyboard="false" class="newadd">新增收货地址</a></span></h5>
				</div>
				<div class="step-cont">
					<div class="addressInfo">
						<input type="hidden" name="address_id" value="">
						<input type="hidden" name="pay_type" value="">
						<input type="hidden" name="rec_id" value="{{request()->rec_id}}">
						<ul class="addr-detail">
							<li class="addr-item">
							@if($address)
							  @foreach($address as $v)
							  <div>
								<div address_id="{{$v['address_id']}}" class="con name choiceuser @if($v['is_default']==1) selected @endif"><a href="javascript:;" >{{$v['consignee']}}<span title="点击取消选择">&nbsp;</a></div>
								<div class="con address">{{$v['consignee']}} {{$v['address']}} {{$v['address_name']}} <span>{{substr_replace($v['tel'],'****',3,4)}}</span>
									@if($v['is_default']==1)
									<span class="base">默认地址</span>
									@endif
									<span class="edittext"><a data-toggle="modal" data-target=".edit" data-keyboard="false" >编辑</a>&nbsp;&nbsp;<a href="javascript:;">删除</a></span>
								</div>
								<div class="clearfix"></div>
							  </div>
							 @endforeach
							@endif
							</li>
							
							
						</ul>
						
					</div>
					<div class="hr"></div>
					
				</div>
				<div class="hr"></div>
				<!--支付和送货-->
				<div class="payshipInfo">
					<div class="step-tit">
						<h5>支付方式</h5>
					</div>
					<div class="step-cont">
						<ul class="payType">
							<li pay_type=1 class="selected">微信付款<span title="点击取消选择"></span></li>
							<li pay_type=2 >支付宝<span title="点击取消选择"></span></li>
							<li pay_type=3 >货到付款<span title="点击取消选择"></span></li>
						</ul>
					</div>
					<div class="hr"></div>
					<div class="step-tit">
						<h5>送货清单</h5>
					</div>
					<div class="step-cont">
						<ul class="send-detail">
						@foreach($goods as $v)
							<li>
								<div class="sendGoods">
									<ul class="yui3-g">
										<li class="yui3-u-1-6">
											<span><img src="{{$v->goods_img}}" width="82px" height="82px"/></span>
										</li>
										<li class="yui3-u-7-12">
											<div class="desc">
												{{$v->goods_name}}
												@if(isset($v['goods_attr']))
													@foreach($v['goods_attr'] as $attr)
														{{$attr['attr_name']}}:{{$attr['attr_value']}}
													@endforeach
												@endif
											</div>
											<div class="seven">7天无理由退货</div>
										</li>
										<li class="yui3-u-1-12">
											<div class="price">￥{{$v->goods_price}}</div>
										</li>
										<li class="yui3-u-1-12">
											<div class="num">X{{$v->buy_number}}</div>
										</li>
										<li class="yui3-u-1-12">
											<div class="exit">有货</div>
										</li>
									</ul>
								</div>
								
							
							@endforeach
							
						</ul>
					</div>
					<div class="hr"></div>
				</div>
				<div class="linkInfo">
					<div class="step-tit">
						<h5>发票信息</h5>
					</div>
					<div class="step-cont">
						<span>普通发票（电子）</span>
						<span>个人</span>
						<span>明细</span>
					</div>
				</div>
				<div class="cardInfo">
					<div class="step-tit">
						<h5>使用优惠/抵用</h5>
					</div>
				</div>
			</div>
			
		</div>

		<div class="order-summary">
			<div class="static fr">
				<div class="list">
					<span><i class="number">1</i>件商品，总商品金额</span>
					<em class="allprice">¥5399.00</em>
				</div>
				<div class="list">
					<span>返现：</span>
					<em class="money">0.00</em>
				</div>
				<div class="list">
					<span>运费：</span>
					<em class="transport">0.00</em>
				</div>
			</div>
		</div>
		<div class="clearfix trade">
			<div class="fc-price">应付金额:　<span class="price">¥5399.00</span></div>
			<div class="fc-receiverInfo">寄送至:北京市海淀区三环内 中关村软件园9号楼 收货人：某某某 159****3201</div>
		</div>
		<div class="submit">
			<button type="submit" class="sui-btn btn-danger btn-xlarge" >提交订单</button>
		</div>
	</form>


	<!--添加地址-->
	<div  tabindex="-1" role="dialog" data-hasfoot="false" class="sui-modal hide fade edit">
						  <div class="modal-dialog">
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" data-dismiss="modal" aria-hidden="true" class="sui-close hideclass">×</button>
						        <h4 id="myModalLabel" class="modal-title">添加收货地址</h4>
						      </div>
						      <div class="modal-body">
							  <form action="" method="post" class="sui-form form-horizontal"> 
						      		 <div class="control-group">
									    <label class="control-label">收货人：</label>
									    <div class="controls">
									      <input type="text" name="consignee" class="input-medium">
									    </div>
									  </div>

									  <div class="control-group">
                                            <label class="control-label">所在地区：</label>
                                            <div class="controls">
											<select name="country"  id="selCountries_0"  style="border:1px solid #ccc;">
											<option value="0">请选择国家</option>
													@if($topaddress)
													@foreach($topaddress as $v)
													<option value="{{$v->region_id}}" >{{$v->region_name}}</option>
													@endforeach
													@endif
												</select>
										<select name="province" id="selProvinces_0"  style="border:1px solid #ccc;">
											<option value="0">请选择省</option>
													
												</select>
										<select name="city" id="selCities_0"  style="border:1px solid #ccc;">
											<option value="0">请选择市</option>
												</select>
										<select name="district" id="selDistricts_0" >
											<option value="0">请选择区</option>
												</select>
										(必填) 
                                            
											</div>
																 
										</div>
										
									   <div class="control-group">
									    <label class="control-label">详细地址：</label>
									    <div class="controls">
									      <input type="text" name="address" class="input-large">
									    </div>
									  </div>
									   <div class="control-group">
									    <label class="control-label">联系电话：</label>
									    <div class="controls">
									      <input type="text" name="tel" class="input-medium">
									    </div>
									  </div>
									   <div class="control-group">
									    <label class="control-label">邮箱：</label>
									    <div class="controls">
									      <input type="text" name="email" class="input-medium">
									    </div>
									  </div>
									   <div class="control-group">
									    <label class="control-label">地址别名：</label>
									    <div class="controls">
									      <input type="text" name="address_name" class="input-medium">
									    </div>
									    <div class="othername">
									    	建议填写常用地址：<a href="#" class="sui-btn btn-default">家里</a>　<a href="#" class="sui-btn btn-default">父母家</a>　<a href="#" class="sui-btn btn-default">公司</a>
									    </div>
									  </div>
									  </form>
						      	
						      	
						      	
						      </div>
						      <div class="modal-footer">
						        <button type="button" data-ok="modal" class="sui-btn btn-primary btn-large useradressadd">确定</button>
						        <button type="button" data-dismiss="modal" class="sui-btn btn-default btn-large hideclass">取消</button>
						      </div>
						    </div>
						  </div>
						 
						</div>
						
						 <!--确认地址-->
	</div>
	
	<!-- 底部栏位 -->
	<!--页面底部-->
@include('index.public.footer')
<!--页面底部END-->
<div class="sui-modal-backdrop fade in" style="background:#000;;display: none;"></div>
<script type="text/javascript" src="/static/index/js/plugins/jquery/jquery.min.js"></script>

<script>
	//判断当前用户是否有收货地址  没有弹出收货地址框
	@if(!count($address))
	$(function(){
		$('.sui-modal').addClass('in');
		$('.sui-modal-backdrop').show();
		$('.sui-modal').css('margin-top','-186px');
		$('.sui-modal').show();
	})
	@endif

	//四级联动
	$('select').change(function(){
		var region_id = $(this).val();
		if(region_id<1){
			$(this).nextAll().find('option:gt(0)').remove();
			return;
		}
		var obj = $(this);
		// alert(region_id);
		$.get('/getsonaddress',{region_id:region_id},function(res){
			if(res.code=='0'){
				var address =res.data.data;
				var str='<option value="0">请选择==</option>';
				for(var i=0;i<address.length;i++){
					str += '<option value="'+address[i].region_id+'">'+address[i].region_name+'</option>';
				}
				// alert(str);
				obj.next().html(str);
			}
		},'json')
	})


	//点击×或取消弹出框消失
	$('.hideclass').click(function(){
		$('.sui-modal').removeClass('in');
		$('.sui-modal-backdrop').hide();
		$('.sui-modal').removecss('margin-top','-186px');
		$('.sui-modal').hide();
	})

	//用户添加
	$(document).on('click','.useradressadd',function(){
		var consignee = $('input[name="consignee"]').val();
		var address_name = $('input[name="address"]').val();
		// alert(address_name);
		var country = $('select[name="country"]').val();
		// alert(country);
		var province = $('select[name="province"]').val();
		// alert(province);
		var city = $('select[name="city"]').val();
		// alert(city);
		var district = $('select[name="district"]').val();
		// alert(district);
		var address = $('input[name="address"]').val();
		var tel = $('input[name="tel"]').val();
		var email = $('input[name="email"]').val();
		var address_name = $('input[name="address_name"]').val();
		$.post('/useraddressadd',{consignee:consignee,address_name:address_name,country:country,province:province,city:city,district:district,address:address,tel:tel,email:email,address_name:address_name},function(res){
			
				$('li[class="addr-item"]').html(res);
			

		})
	})

	//页面加载事件
	$(function(){
		var address_id = $('.selected').attr('address_id');
		var pay_type = $('.payType .selected').attr('pay_type');
		
		$('input[name="address_id"]').val(address_id);
		$('input[name="pay_type"]').val(pay_type);
		
		//选择收货地址
		$('.choiceuser').click(function(){
			var address_id = $(this).attr('address_id');
			// alert(address_id);
			$('input[name="address_id"]').val(address_id);
			$(this).parents('div').siblings().find('div').removeClass("selected");
			$(this).parent().addClass("selected");
		})

		//选择支付方式
		$('.payType li').click(function(){
			var pay_type = $(this).attr('pay_type');
			// alert(pay_type);
			$('input[name="pay_type"]').val(pay_type);
		})
			
		
	})
	
	
</script>

<script type="text/javascript" src="/static/index/js/plugins/jquery.easing/jquery.easing.min.js"></script>
<script type="text/javascript" src="/static/index/js/plugins/sui/sui.min.js"></script>
<script type="text/javascript" src="components/ui-modules/nav/nav-portal-top.js"></script>
<script type="text/javascript" src="/static/index/js/pages/getOrderInfo.js"></script>
</body>

</html>