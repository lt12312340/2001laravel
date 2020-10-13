<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
		<title>产品列表页</title>
		<link rel="icon" href="assets/img/favicon.ico">

		<link rel="stylesheet" type="text/css" href="/static/index/css/webbase.css" />
		<link rel="stylesheet" type="text/css" href="/static/index/css/pages-list.css" />
		<link rel="stylesheet" type="text/css" href="/static/index/css/widget-cartPanelView.css" />
	</head>

	<body>
		<!-- 头部栏位 -->
		<!--页面顶部-->
		<div id="nav-bottom">
			<!--顶部-->
			<div class="nav-top">
			@include('index.public.top')
				<!--头部-->
				<div class="header">
					<div class="py-container">
						<div class="yui3-g Logo">
							<div class="yui3-u Left logoArea">
								<a class="logo-bd" title="品优购" href="JD-index.html" target="_blank"></a>
							</div>
							<div class="yui3-u Center searchArea">
								<div class="search">
									<form action="" class="sui-form form-inline">
										<!--searchAutoComplete-->
										<div class="input-append">
											<input type="text" id="autocomplete" type="text" class="input-error input-xxlarge" />
											<button class="sui-btn btn-xlarge btn-danger" type="button">搜索</button>
										</div>
									</form>
								</div>
								<div class="hotwords">
									<ul>
										<li class="f-item">品优购首发</li>
										<li class="f-item">亿元优惠</li>
										<li class="f-item">9.9元团购</li>
										<li class="f-item">每满99减30</li>
										<li class="f-item">亿元优惠</li>
										<li class="f-item">9.9元团购</li>
										<li class="f-item">办公用品</li>

									</ul>
								</div>
							</div>
							<div class="yui3-u Right shopArea">
								<div class="fr shopcar">
									<div class="show-shopcar" id="shopcar">
										<span class="car"></span>
										<a class="sui-btn btn-default btn-xlarge" href="cart.html" target="_blank">
											<span>我的购物车</span>
											<i class="shopnum">0</i>
										</a>
										<div class="clearfix shopcarlist" id="shopcarlist" style="display:none">
											<p>"啊哦，你的购物车还没有商品哦！"</p>
											<p>"啊哦，你的购物车还没有商品哦！"</p>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="yui3-g NavList">
							<div class="yui3-u Left all-sort">
								<h4>全部商品分类</h4>
							</div>
							<div class="yui3-u Center navArea">
								<ul class="nav">
									<li class="f-item">服装城</li>
									<li class="f-item">美妆馆</li>
									<li class="f-item">品优超市</li>
									<li class="f-item">全球购</li>
									<li class="f-item">闪购</li>
									<li class="f-item">团购</li>
									<li class="f-item">有趣</li>
									<li class="f-item">
										<a href="seckill-index.html" target="_blank">秒杀</a>
									</li>
								</ul>
							</div>
							<div class="yui3-u Right"></div>
						</div>
					</div>
				</div>
			</div>
		</div>

	
	<!--list-content-->
	<div class="main">
		<div class="py-container">
			<!--bread-->
			<div class="bread">
				<ul class="fl sui-breadcrumb">
					<li>
						<a href="#">全部结果</a>
					</li>					
					<li class="active">{{$catename}}</li>					
				</ul>
				<ul class="tags-choose">
					<li class="tag tag-brand_id"><i class="sui-icon icon-tb-close"></i></li>
					<li class="tag tag-price"><i class="sui-icon icon-tb-close"></i></li>
				</ul>
				<form class="fl sui-form form-dark">
					<div class="input-control control-right">
						<input type="text" />
						<i class="sui-icon icon-touch-magnifier"></i>
					</div>
				</form>
				<div class="clearfix"></div>
			</div>
			<!--selector-->
			<div class="clearfix selector">
				<div class="type-wrap">
					<div class="fl key">{{$catename}}</div>
					<div class="fl value"></div>
					<div class="fl ext"></div>
				</div>
				
				<div class="type-wrap logo">
					<div class="fl key brand">品牌</div>
					<div class="value logos">
					
						<ul class="logo-list search">
							
						@foreach($brand_logo as $v)
							<li field="brand_id" value="{{$v->brand_id}}" title="{{$v->brand_name}}">
								<a href="javascript:;" @if(isset($query['brand_id']) && $query['brand_id'] == $v->brand_id) class="redhover" @endif>
									<img src="{{$v->brand_logo??''}}" width="102" height="52"/>
								</a>
							</li>
						@endforeach
						</ul>
					</div>
					
				
					<div class="ext">
						<a href="javascript:void(0);" class="sui-btn">多选</a>
						<a href="javascript:void(0);">更多</a>
					</div>
				</div>

				
				<div class="type-wrap">
					<div class="fl key">价格</div>
					<div class="fl value">
						<ul class="type-list search">
							@if($price)
							@foreach($price as $v)
							<li field="price" value="{{$v}}">
								<a @if(isset($query['price']) && $query['price'] == $v) class="redhover" @endif>{{$v}}</a>
							</li>
							@endforeach
							@endif
						</ul>
					</div>
					<div class="fl ext">
					</div>
				</div>
				
			</div>
			<!--details-->
			<div class="details">
				<div class="sui-navbar">
					<div class="navbar-inner filter">
						<ul class="sui-nav">
							<li class="active">
								<a href="#">综合</a>
							</li>
							<li>
								<a href="#">销量</a>
							</li>
							<li>
								<a href="#">新品</a>
							</li>
							<li>
								<a href="#">评价</a>
							</li>
							<li>
								<a href="#">价格</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="goods-list">
					<ul class="yui3-g">
					@if($goods)
					@foreach($goods as $v)
						<li class="yui3-u-1-5">
							<div class="list-wrap">
								<div class="p-img">
									<a href="{{url('goodsinfo/'.$v->goods_id)}}" target="_blank"><img src="{{$v->goods_img}}" /></a>
								</div>
								<div class="price">
									<strong>
											<em>¥</em>
											<i>{{$v->goods_price}}</i>
										</strong>
								</div>
								<div class="attr">
									<em>{{$v->goods_name}}</em>
								</div>
								<div class="cu">
									<em><span>促</span>满一件可参加超值换购</em>
								</div>
								<div class="commit">
									<i class="command">已有2000人评价</i>
								</div>
								<div class="operate">
									<a href="success-cart.html" target="_blank" class="sui-btn btn-bordered btn-danger">加入购物车</a>
									<a href="javascript:void(0);" class="sui-btn btn-bordered">对比</a>
									<a href="javascript:void(0);" class="sui-btn btn-bordered">关注</a>
								</div>
							</div>
						</li>
					@endforeach
					@endif
					</ul>
				</div>
				<div class="fr page">
				{{$goods->appends(['query'=>$query])->links('vendor.pagination.indexshop')}}
				</div>
			<!--hotsale-->
			<div class="clearfix hot-sale">
				<h4 class="title">热卖商品</h4>
				<div class="hot-list">
					<ul class="yui3-g">
						<li class="yui3-u-1-4">
							<div class="list-wrap">
								<div class="p-img">
									<img src="/static/index/img/like_01.png" />
								</div>
								<div class="attr">
									<em>Apple苹果iPhone 6s (A1699)</em>
								</div>
								<div class="price">
									<strong>
											<em>¥</em>
											<i>4088.00</i>
										</strong>
								</div>
								<div class="commit">
									<i class="command">已有700人评价</i>
								</div>
							</div>
						</li>
						<li class="yui3-u-1-4">
							<div class="list-wrap">
								<div class="p-img">
									<img src="/static/index/img/like_03.png" />
								</div>
								<div class="attr">
									<em>金属A面，360°翻转，APP下单省300！</em>
								</div>
								<div class="price">
									<strong>
											<em>¥</em>
											<i>4088.00</i>
										</strong>
								</div>
								<div class="commit">
									<i class="command">已有700人评价</i>
								</div>
							</div>
						</li>
						<li class="yui3-u-1-4">
							<div class="list-wrap">
								<div class="p-img">
									<img src="/static/index/img/like_04.png" />
								</div>
								<div class="attr">
									<em>256SSD商务大咖，完爆职场，APP下单立减200</em>
								</div>
								<div class="price">
									<strong>
											<em>¥</em>
											<i>4068.00</i>
										</strong>
								</div>
								<div class="commit">
									<i class="command">已有20人评价</i>
								</div>
							</div>
						</li>
						<li class="yui3-u-1-4">
							<div class="list-wrap">
								<div class="p-img">
									<img src="/static/index/img/like_02.png" />
								</div>
								<div class="attr">
									<em>Apple苹果iPhone 6s (A1699)</em>
								</div>
								<div class="price">
									<strong>
											<em>¥</em>
											<i>4088.00</i>
										</strong>
								</div>
								<div class="commit">
									<i class="command">已有700人评价</i>
								</div>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<!-- 底部栏位 -->
	<!--页面底部-->
	@include('index.public.footer')
	<!--页面底部END-->
	<!--侧栏面板开始-->
	<div class="J-global-toolbar">
		<div class="toolbar-wrap J-wrap">
			<div class="toolbar">
				<div class="toolbar-panels J-panel">

					<!-- 购物车 -->
					<div style="visibility: hidden;" class="J-content toolbar-panel tbar-panel-cart toolbar-animate-out">
						<h3 class="tbar-panel-header J-panel-header">
						<a href="" class="title"><i></i><em class="title">购物车</em></a>
						<span class="close-panel J-close" onclick="cartPanelView.tbar_panel_close('cart');" ></span>
					</h3>
						<div class="tbar-panel-main">
							<div class="tbar-panel-content J-panel-content">
								<div id="J-cart-tips" class="tbar-tipbox hide">
									<div class="tip-inner">
										<span class="tip-text">还没有登录，登录后商品将被保存</span>
										<a href="#none" class="tip-btn J-login">登录</a>
									</div>
								</div>
								<div id="J-cart-render">
									<!-- 列表 -->
									<div id="cart-list" class="tbar-cart-list">
									</div>
								</div>
							</div>
						</div>
						<!-- 小计 -->
						<div id="cart-footer" class="tbar-panel-footer J-panel-footer">
							<div class="tbar-checkout">
								<div class="jtc-number"> <strong class="J-count" id="cart-number">0</strong>件商品 </div>
								<div class="jtc-sum"> 共计：<strong class="J-total" id="cart-sum">¥0</strong> </div>
								<a class="jtc-btn J-btn" href="#none" target="_blank">去购物车结算</a>
							</div>
						</div>
					</div>

					<!-- 我的关注 -->
					<div style="visibility: hidden;" data-name="follow" class="J-content toolbar-panel tbar-panel-follow">
						<h3 class="tbar-panel-header J-panel-header">
						<a href="#" target="_blank" class="title"> <i></i> <em class="title">我的关注</em> </a>
						<span class="close-panel J-close" onclick="cartPanelView.tbar_panel_close('follow');"></span>
					</h3>
						<div class="tbar-panel-main">
							<div class="tbar-panel-content J-panel-content">
								<div class="tbar-tipbox2">
									<div class="tip-inner"> <i class="i-loading"></i> </div>
								</div>
							</div>
						</div>
						<div class="tbar-panel-footer J-panel-footer"></div>
					</div>

					<!-- 我的足迹 -->
					<div style="visibility: hidden;" class="J-content toolbar-panel tbar-panel-history toolbar-animate-in">
						<h3 class="tbar-panel-header J-panel-header">
						<a href="#" target="_blank" class="title"> <i></i> <em class="title">我的足迹</em> </a>
						<span class="close-panel J-close" onclick="cartPanelView.tbar_panel_close('history');"></span>
					</h3>
						<div class="tbar-panel-main">
							<div class="tbar-panel-content J-panel-content">
								<div class="jt-history-wrap">
									<ul>
										<!--<li class="jth-item">
										<a href="#" class="img-wrap"> <img src=".portal//static/index/img/like_03.png" height="100" width="100" /> </a>
										<a class="add-cart-button" href="#" target="_blank">加入购物车</a>
										<a href="#" target="_blank" class="price">￥498.00</a>
									</li>
									<li class="jth-item">
										<a href="#" class="img-wrap"> <img src="portal//static/index/img/like_02.png" height="100" width="100" /></a>
										<a class="add-cart-button" href="#" target="_blank">加入购物车</a>
										<a href="#" target="_blank" class="price">￥498.00</a>
									</li>-->
									</ul>
									<a href="#" class="history-bottom-more" target="_blank">查看更多足迹商品 &gt;&gt;</a>
								</div>
							</div>
						</div>
						<div class="tbar-panel-footer J-panel-footer"></div>
					</div>

				</div>

				<div class="toolbar-header"></div>

				<!-- 侧栏按钮 -->
				<div class="toolbar-tabs J-tab">
					<div onclick="cartPanelView.tabItemClick('cart')" class="toolbar-tab tbar-tab-cart" data="购物车" tag="cart">
						<i class="tab-ico"></i>
						<em class="tab-text"></em>
						<span class="tab-sub J-count " id="tab-sub-cart-count">0</span>
					</div>
					<div onclick="cartPanelView.tabItemClick('follow')" class="toolbar-tab tbar-tab-follow" data="我的关注" tag="follow">
						<i class="tab-ico"></i>
						<em class="tab-text"></em>
						<span class="tab-sub J-count hide">0</span>
					</div>
					<div onclick="cartPanelView.tabItemClick('history')" class="toolbar-tab tbar-tab-history" data="我的足迹" tag="history">
						<i class="tab-ico"></i>
						<em class="tab-text"></em>
						<span class="tab-sub J-count hide">0</span>
					</div>
				</div>

				<div class="toolbar-footer">
					<div class="toolbar-tab tbar-tab-top">
						<a href="#"> <i class="tab-ico  "></i> <em class="footer-tab-text">顶部</em> </a>
					</div>
					<div class="toolbar-tab tbar-tab-feedback">
						<a href="#" target="_blank"> <i class="tab-ico"></i> <em class="footer-tab-text ">反馈</em> </a>
					</div>
				</div>

				<div class="toolbar-mini"></div>

			</div>

			<div id="J-toolbar-load-hook"></div>

		</div>
	</div>

<!--购物车单元格 模板-->
<script type="text/template" id="tbar-cart-item-template">
		<div class="tbar-cart-item">
			<div class="jtc-item-promo">
				<em class="promo-tag promo-mz">满赠<i class="arrow"></i></em>
				<div class="promo-text">已购满600元，您可领赠品</div>
			</div>
			<div class="jtc-item-goods">
				<span class="p-img"><a href="#" target="_blank"><img src="{2}" alt="{1}" height="50" width="50" /></a></span>
				<div class="p-name">
					<a href="#">{1}</a>
				</div>
				<div class="p-price"><strong>¥{3}</strong>×{4} </div>
				<a href="#none" class="p-del J-del">删除</a>
			</div>
		</div>
	</script>
	<!--侧栏面板结束-->
		<script type="text/javascript" src="/static/index/js/plugins/jquery/jquery.min.js"></script>

		<script>
			$(document).on('click','.sui-icon',function(){
			    $(this).parent().hide();
			})

			$(function(){
				$('.redhover').each(function(i,k){
					var s_key = $(this).parent().attr('field');
					var s_val = $(this).parent().attr('value');
					
					if(s_key=='brand_id'){
						var s_val = $(this).parent().attr('title');
					}
					$('.tag-'+s_key).html(s_val+'<i class="sui-icon icon-tb-close"></i>').show();
				});
			});	

			$('.search li').click(function(){
				// alert(123);
				$(this).siblings().find('a').removeClass('redhover');
				$(this).find('a').addClass('redhover');
				var search = '';
				$('.redhover').each(function(i,k){
					var s_key = $(this).parent().attr('field');
					var s_val = $(this).parent().attr('value');
					search += s_key+'='+s_val+'&';
				})
				var url = "{{$url}}";
				if(search){
					url +='?'+search.substring(0,search.length-1);
					location.href=url;
				}
				
			})
			
		</script>

		<script type="text/javascript">
			$(function() {
				$("#service").hover(function() {
					$(".service").show();
				}, function() {
					$(".service").hide();
				});
				$("#shopcar").hover(function() {
					$("#shopcarlist").show();
				}, function() {
					$("#shopcarlist").hide();
				});

			})
		</script>
		<script type="text/javascript" src="/static/index/js/model/cartModel.js"></script>
		<script type="text/javascript" src="/static/index/js/czFunction.js"></script>
		<script type="text/javascript" src="/static/index/js/plugins/jquery.easing/jquery.easing.min.js"></script>
		<script type="text/javascript" src="/static/index/js/plugins/sui/sui.min.js"></script>
		<script type="text/javascript" src="/static/index/js/widget/cartPanelView.js"></script>
	</body>

</html>