<form action="{{url('wechat/dingadd_do')}}" method="post" enctype="multipart/form-data">
  <table class="table table-bordered table-striped form-horizontal">
    <h3>绑定管理员账号</h3>
    <div class="form-group">
      <label for="exampleInputEmail1">用户名</label>
      <input type="text" class="form-control" name="name" placeholder="请输入用户名">
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1">密码</label>
      <input type="text" class="form-control" name="pwd" placeholder="请输入密码">
    </div>
      <button type="submit" class="btn btn-info sub">绑定管理员账号</button>
  </table> 
</form>

<link rel="stylesheet" href="/css/bootstrap.min.css">
<script src="/js/bootstrap.min.js"></script>
<script src="{{ asset('/js/jquery.min.js') }} "></script>