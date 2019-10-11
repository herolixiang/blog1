<h3>注册页面</h3>
<form action="{{url('/news/regadd_do')}}" method="post">
	<table border="1" width="500">
<!-- 		<caption>管理员登录页面</caption> -->
        @csrf
		<p>
			用户名
			<input type="text" name="name">
		</p>
		<p>
			密码
			<input type="password" name="pwd">
		</p>
		<button>注册</button>
	</table>
</form>