@extends('layouts.admin')
@section('content')
<!DOCTYPE html>
<html>
<body class="gray-bg">
    <div class="middle-box text-center loginscreen  animated fadeInDown">
        <div>
            <div>
                <h1 class="logo-name">h</h1>
            </div>
            <h3>欢迎使用 hAdmin</h3>
            <form class="m-t" role="form" action="{{url('/wechat/bangadd_do')}}" method="post">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="用户名" name="name" id="name" required="">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="密码" name="pwd" id="pwd" required="">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" style="width:60%;float:left" placeholder="验证码" name="yan" id="yan" required="">
                    <button type="button" id="login" class="btn btn-primary">发送验证码</button>
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b" id="">登 录</button>
                <h3>点击前往微信扫码登陆</h3><img src="{{asset('Screenshot_1.png')}}" alt="" height="100" width="100">
                <p class="text-muted text-center"> <a href="login.html#"><small>忘记密码了？</small></a> | <a href="register.html">注册一个新账号</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>
<script type="text/javascript">
    // alert(1);
    $("#login").on('click',function(){
		var name= $('#name').val();
		var pwd= $('#pwd').val();
        var yan= $('#yan').val();
        // alert(name);
		$.ajax({
			url:"http://lx.herolixiang.top/wechat/yan",
			data:{name:name,pwd:pwd,yan:yan},
			dataType:"json",
			success:function($res){
                alert($res.msg);
			}
		})
	})
</script>
@endsection
