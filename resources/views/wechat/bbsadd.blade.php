<form action="{{url('wechat/bbsadd_do')}}" method="post" enctype="multipart/form-data">
@csrf
<h3>留言添加</h3>
  <div class="form-group">
    <label for="exampleInputEmail1">用户uid</label>
    <input type="text" class="form-control" name="id" value="{{$data->id}}" placeholder="用户uid">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">留言名称</label>
    <input type="text" class="form-control" id="" name="nickname" value="{{$data->nickname}}" placeholder="菜单名称">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">留言内容</label>
    <input type="text" class="form-control" id="" name="content"  placeholder="留言内容">
  </div>
  <button type="submit" class="btn btn-default">提交留言</button>
</form>