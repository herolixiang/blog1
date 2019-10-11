<form action="" method="post" enctype="multipart/form-data">
  <table class="table table-bordered table-striped form-horizontal">
    <h3>接口基础-留言修改</h3>
      <div class="form-group">
        <label for="exampleInputEmail1">姓名</label>
        <input type="text" class="form-control" name="nickname" placeholder="用户名">
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">内容</label>
        <input type="text" class="form-control" name="content" placeholder="电话号">
      </div>
      <button type="button" class="btn btn-info sub">修改</button>
  </table> 
</form>

<link rel="stylesheet" href="/css/bootstrap.min.css">
<script src="/js/bootstrap.min.js"></script>
<script src="{{ asset('/js/jquery.min.js') }} "></script>