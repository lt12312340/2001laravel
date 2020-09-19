@extends('admin.layouts.adminshop')  
@section('content')



<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>JS响应式3D照片墙展示特效 - 站长素材</title>

<style type="text/css">
	html {
		overflow: hidden;
	}
	body {
		position: absolute;
		margin: 0px;
		padding: 0px;
		background: #4f5a70;
		width: 100%;
		height: 100%;
	}
	a{ color: rgba(255, 255, 255, 0.6);outline: none;text-decoration: none;-webkit-transition: 0.2s;transition: 0.2s;}
	a:hover,a:focus{color:#74777b;text-decoration: none;}
	#screen {
		position: absolute;
		left: 10%;
		top: 10%;
		width: 80%;
		height: 80%;
		background: #3e495d;
	}
	#screen img {
		position: absolute;
		cursor: pointer;
		visibility: hidden;
		width: 0px;
		height: 0px;
	}
	#screen .tvover {
		border: solid #876;
		opacity: 1;
		filter: alpha(opacity=100);
	}
	#screen .tvout {
		border: solid #fff;
		opacity: 0.7;
	}
	#bankImages {
		display: none;
	}
</style>

</head>
<body>

<div id="screen">

</div>
<div id="bankImages">
	<img alt="" src="/static/shouye/images/o.jpg">
	<img alt="" src="/static/shouye/images/n.jpg">
	<img alt="" src="/static/shouye/images/m.jpg">
	<img alt="" src="/static/shouye/images/l.jpg">
	<img alt="" src="/static/shouye/images/0E2B84D4D8F3C78CD8484760404AB27E.jpg">
	<img alt="" src="/static/shouye/images/02D427F9B4437DA4CB081DE29275AE6A.jpg">
	<img alt="" src="/static/shouye/images/4294B9C5AC4A632BFD84FDBF9AB11182.jpg">
	<img alt="" src="/static/shouye/images/4443EC249AEAC6449F87413FD771554A.jpg">
	<img alt="" src="/static/shouye/images/A63C77E0C67D82DEB3244888DF29C900.jpg">
	<img alt="" src="/static/shouye/images/c.jpg">
	<img alt="" src="/static/shouye/images/b.jpg">
	<img alt="" src="/static/shouye/images/EC73B9D58ED31866A1F926F32C644499.jpg">
	<img alt="" src="/static/shouye/images/EFEF7E8DD2380E0613CB466C5BED0566.jpg">
	<img alt="" src="/static/shouye/images/DE1AA006D8B0BEE73315A54D45BFFA4F.jpg">
	<img alt="" src="/static/shouye/images/9D1BE48D299BF1EF6470EC19443BFDC9.jpg">
	<img alt="" src="/static/shouye/images/86ED8CECE15619E89003709D42E7615F.jpg">
</div>

<script src="/static/shouye/js/3d-tv.js" type="text/javascript"></script>
<script type="text/javascript">
	/* ==== start script ==== */
	onresize = tv.resize;
	tv.init();
</script>

</body>
</html>


<script src="/static/layui/layui.js"></script>
<script src="/static/layui/jquery.js"></script>

<script>
    layui.use(['element','form'], function(){
    var element = layui.element;
    var form = layui.form;
    });
</script>
@endsection