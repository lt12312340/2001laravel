<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE">
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
	<title>我的购物车</title>

    <link rel="stylesheet" type="text/css" href="/static/index/css/webbase.css" />
    <link rel="stylesheet" type="text/css" href="/static/index/css/pages-cart.css" />
</head>

<body>
	<!--head-->
	@include('index.public.top')
	<div class="cart py-container">
		<!--logoArea-->
		<div class="logoArea">
			<div class="fl logo"><span class="title">购物车</span></div>
			<div class="fr search">
				<form class="sui-form form-inline">
					<div class="input-append">
						<input type="text" type="text" class="input-error input-xxlarge" placeholder="品优购自营" />
						<button class="sui-btn btn-xlarge btn-danger" type="button">搜索</button>
					</div>
				</form>
			</div>
		</div>
		<!--All goods-->
		<div class="allgoods">
			<h4>全部商品<span>11</span></h4>
			<div class="cart-main">
				<div class="yui3-g cart-th">
					<div class="yui3-u-1-4"><input type="checkbox" name="" id="checkall" value="" /> 全部</div>
					<div class="yui3-u-1-4">商品</div>
					<div class="yui3-u-1-8">单价（元）</div>
					<div class="yui3-u-1-8">数量</div>
					<div class="yui3-u-1-8">小计（元）</div>
					<div class="yui3-u-1-8">操作</div>
				</div>
				
				<div class="cart-item-list">
					
					<div class="cart-body">
						@foreach($cart as $v)
						<div class="cart-list">
							<ul class="goods-list yui3-g">
								<li class="yui3-u-1-24">
									<input type="checkbox" name="" id="" class="cartid" value="{{$v->rec_id}}" />
								</li>
								<li class="yui3-u-11-24">
									<div class="good-item">
										<div class="item-img"><img src="{{$v->goods_img}}" /></div>
										<div class="item-msg">{{$v->goods_name}}
											@if(isset($v['goods_attr']))
												@foreach($v['goods_attr'] as $attr)
													{{$attr['attr_name']}}:{{$attr['attr_value']}}
												@endforeach
											@endif
										</div>
									</div>
								</li>
								
								<li class="yui3-u-1-8"><span class="price">{{$v->goods_price}}</span></li>
								<li class="yui3-u-1-8">
									<a href="javascript:void(0)" class="increment mins">-</a>
									<input autocomplete="off" type="text" buy_number="{{$v->buy_number}}" value="{{$v->buy_number}}" minnum="1" class="itxt" />
									<a href="javascript:void(0)" class="increment plus">+</a>
								</li>
								<li class="yui3-u-1-8"><span class="sum">{{number_format($v->buy_number * $v->goods_price,2,".","")}}</span></li>
								<li class="yui3-u-1-8">
									<a href="#none">删除</a><br />
									<a href="#none">移到我的关注</a>
								</li>
							</ul>
						</div>
						@endforeach
					</div>
				</div>
			</div>
			<div class="cart-tool">
				<div class="select-all">
					<input type="checkbox" name="" id="" value="" />
					<span>全选</span>
				</div>
				<div class="option">
					<a href="#none">删除选中的商品</a>
					<a href="#none">移到我的关注</a>
					<a href="#none">清除下柜商品</a>
				</div>
				<div class="toolbar">
					<div class="chosed">已选择<span>0</span>件商品</div>
					<div class="sumprice">
						<span><em>总价（不含运费） ：</em><i class="summoney">¥0.00</i></span>
						<span><em>已节省：</em><i>-¥20.00</i></span>
					</div>
					<div class="sumbtn">
						<a class="sum-btn" href="javascript:void(0)">结算</a>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="deled">
				<span>已删除商品，您可以重新购买或加关注：</span>
				<div class="cart-list del">
					<ul class="goods-list yui3-g">
						<li class="yui3-u-1-2">
							<div class="good-item">
								<div class="item-msg">Apple Macbook Air 13.3英寸笔记本电脑 银色（Corei5）处理器/8GB内存</div>
							</div>
						</li>
						<li class="yui3-u-1-6"><span class="price">8848.00</span></li>
						<li class="yui3-u-1-6">
							<span class="number">1</span>
						</li>
						<li class="yui3-u-1-8">
							<a href="#none">重新购买</a>
							<a href="#none">移到我的关注</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="liked">
				<ul class="sui-nav nav-tabs">
					<li class="active">
						<a href="#index" data-toggle="tab">猜你喜欢</a>
					</li>
					<li>
						<a href="#profile" data-toggle="tab">特惠换购</a>
					</li>
				</ul>
				<div class="clearfix"></div>
				<div class="tab-content">
					<div id="index" class="tab-pane active">
						<div id="myCarousel" data-ride="carousel" data-interval="4000" class="sui-carousel slide">
							<div class="carousel-inner">
								<div class="active item">
									<ul>
										<li>
											<img src="/static/index/img/like1.png" />
											<div class="intro">
												<i>Apple苹果iPhone 6s (A1699)</i>
											</div>
											<div class="money">
												<span>$29.00</span>
											</div>
											<div class="incar">
												<a href="#" class="sui-btn btn-bordered btn-xlarge btn-default"><i class="car"></i><span class="cartxt">加入购物车</span></a>
											</div>
										</li>
										<li>
											<img src="/static/index/img/like2.png" />
											<div class="intro">
												<i>Apple苹果iPhone 6s (A1699)</i>
											</div>
											<div class="money">
												<span>$29.00</span>
											</div>
											<div class="incar">
												<a href="#" class="sui-btn btn-bordered btn-xlarge btn-default"><i class="car"></i><span class="cartxt">加入购物车</span></a>
											</div>
										</li>
										<li>
											<img src="/static/index/img/like3.png" />
											<div class="intro">
												<i>Apple苹果iPhone 6s (A1699)</i>
											</div>
											<div class="money">
												<span>$29.00</span>
											</div>
											<div class="incar">
												<a href="#" class="sui-btn btn-bordered btn-xlarge btn-default"><i class="car"></i><span class="cartxt">加入购物车</span></a>
											</div>
										</li>
										<li>
											<img src="/static/index/img/like4.png" />
											<div class="intro">
												<i>Apple苹果iPhone 6s (A1699)</i>
											</div>
											<div class="money">
												<span>$29.00</span>
											</div>
											<div class="incar">
												<a href="#" class="sui-btn btn-bordered btn-xlarge btn-default"><i class="car"></i><span class="cartxt">加入购物车</span></a>
											</div>
										</li>
									</ul>
								</div>
								<div class="item">
									<ul>
										<li>
											<img src="/static/index/img/like1.png" />
											<div class="intro">
												<i>Apple苹果iPhone 6s (A1699)</i>
											</div>
											<div class="money">
												<span>$29.00</span>
											</div>
											<div class="incar">
												<a href="#" class="sui-btn btn-bordered btn-xlarge btn-default"><i class="car"></i><span class="cartxt">加入购物车</span></a>
											</div>
										</li>
										<li>
											<img src="/static/index/img/like2.png" />
											<div class="intro">
												<i>Apple苹果iPhone 6s (A1699)</i>
											</div>
											<div class="money">
												<span>$29.00</span>
											</div>
											<div class="incar">
												<a href="#" class="sui-btn btn-bordered btn-xlarge btn-default"><i class="car"></i><span class="cartxt">加入购物车</span></a>
											</div>
										</li>
										<li>
											<img src="/static/index/img/like3.png" />
											<div class="intro">
												<i>Apple苹果iPhone 6s (A1699)</i>
											</div>
											<div class="money">
												<span>$29.00</span>
											</div>
											<div class="incar">
												<a href="#" class="sui-btn btn-bordered btn-xlarge btn-default"><i class="car"></i><span class="cartxt">加入购物车</span></a>
											</div>
										</li>
										<li>
											<img src="/static/index/img/like4.png" />
											<div class="intro">
												<i>Apple苹果iPhone 6s (A1699)</i>
											</div>
											<div class="money">
												<span>$29.00</span>
											</div>
											<div class="incar">
												<a href="#" class="sui-btn btn-bordered btn-xlarge btn-default"><i class="car"></i><span class="cartxt">加入购物车</span></a>
											</div>
										</li>
									</ul>
								</div>
							</div>
							<a href="#myCarousel" data-slide="prev" class="carousel-control left">‹</a>
							<a href="#myCarousel" data-slide="next" class="carousel-control right">›</a>
						</div>
					</div>
					<div id="profile" class="tab-pane">
						<p>特惠选购</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- 底部栏位 -->
	<!--页面底部-->
@include('index.public.footer')
<!--页面底部END-->

<script type="text/javascript" src="/static/index/js/plugins/jquery/jquery.min.js"></script>
<script type="text/javascript" src="/static/index/js/plugins/jquery.easing/jquery.easing.min.js"></script>
<script type="text/javascript" src="/static/index/js/plugins/sui/sui.min.js"></script>
<script type="text/javascript" src="/static/index/js/widget/nav.js"></script>

<script>
	
	//加号
	$('.plus').click(function(){
		//获取当前购买数量
		var buy_number = $(this).prev().val();
		buy_number=parseInt(buy_number);
		// alert(buy_number);

		//获取商品库存
		var goods_num = "{{$product_number}}";
		goods_num=parseInt(goods_num);
		// alert(goods_num);
		if(buy_number<goods_num){
                buy_number=buy_number+1;
                $(this).prev().val(buy_number)
        }else if(buy_number>goods_num){
			alert('库存不足');
			$(this).prev().val(buy_number)
		}
		
		
		
	})

	//减号
	$('.mins').click(function(){
		//获取当前购买数量
		var buy_number = $(this).next().val();
		buy_number=parseInt(buy_number);
		
		//获取商品库存
		var goods_num = "{{$product_number}}";
		goods_num=parseInt(goods_num);
		// alert(goods_num);
		if(buy_number>1){
			buy_number=buy_number-1;
        	$(this).next('input').val(buy_number)
        }else if(buy_number <= 0 ){
			alert('购买数量不能为0');
		}
		
	})

	//全选
	$('#checkall').click(function(){
		var checkall = $(this).prop('checked');
		// alert(checkall);
		$('.cartid').prop('checked',checkall);
	})

	//获取总价
	$('.cartid').click(function(){
		var cart_id = new Array();
		$('.cartid:checked').each(function(){
			cart_id.push($(this).val())
		})
		// alert(cart_id.length);
		if(cart_id){
			$.get('/getcartprice',{cart_id:cart_id},function(res){
				if(res.code==0){
					$('.summoney').text(res.data.total);
				}
			},'json')	
		}
	})

	//结算
	$('.sum-btn').click(function(){
		var cart_id = new Array();
		$('.cartid:checked').each(function(){
			cart_id.push($(this).val())
		})
		// alert(cart_id)
		if(!cart_id.length){
			alert('请选择要购买的商品QAQ');
			return;
		}
		if(cart_id){
			location.href="/confirmorder?rec_id="+cart_id;
		}
	})
</script>
</body>

</html>