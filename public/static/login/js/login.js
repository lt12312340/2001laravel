
        	layui.extend({
				admin: '{/}./static/js/admin'
			});
            layui.use(['form','admin'], function(){
              var form = layui.form
              	,admin = layui.admin;
              // layer.msg('玩命卖萌中', function(){
              //   //关闭后的操作
              //   });
              //监听提交
              form.on('submit(login)', function(data){
				var name=$("#username").val();
				var pwd=$("#password").val();
				alert(name)
				alert(pwd)
			$.ajax({
				type: 'get',
				url: 'http://192.168.1.88:8082/user/login',
				data:  {
					account:name,
					password:pwd
				},
				dataType: 'jsonp',
				success:function(data){
					console.log(data)
					location.href='./index.html'
					 return false
					},
					error:function(data){
						conlose.log(data)
					},
			
			} );
               // location.href='./login.html'
               // return false;
              });
            }); 
