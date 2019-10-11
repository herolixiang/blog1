<form action="" method="post" enctype="multipart/form-data">
  <table class="table table-bordered table-striped form-horizontal">
    <h3>登陆页面</h3>
      <div class="form-group">
        <label for="exampleInputEmail1">用户名</label>
        <input type="text" class="form-control" id='name' name="name" placeholder="用户名">
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">密码</label>
        <input type="password" class="form-control" id='pwd'  name="pwd" placeholder="密码">
      </div>
      <button id='login' class="btn btn-info sub">添加</button>
  </table> 
</form>

<link rel="stylesheet" href="/css/bootstrap.min.css">
<script src="/js/bootstrap.min.js"></script>
<script src="{{asset('/js/jquery.min.js')}}"></script>
<script>
  // alert(1);
	$("#login").on('click',function(){
		var name= $('#name').val();
		var pwd= $('#pwd').val();
		$.ajax({
			url:"http://lx.herolixiang.top/news/log",
			data:{name:name,pwd:pwd},
			dataType:"json",
			success:function($res){
        alert(res.msg);
        window.location.href="http://lx.herolixiang.top/news/login_do";
			},
		})
	})
</script>