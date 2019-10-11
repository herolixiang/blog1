<!-- <form action="{{url('wechat/confadd_do')}}" method="post" enctype="multipart/form-data">
@csrf
<h3>表白添加</h3>
<div class="form-group">
  <div class="form-group">
      <label for="exampleInputEmail1">用户uid</label>
      <input type="text" class="form-control" name="id" value="{{$data->id}}" placeholder="菜单名称">
  </div>
  <label for="exampleInputEmail1">表白类型</label>
    <select name="nickname" class="form-control">
        <option value="1">实名表白</option>
        <option value="2">匿名表白</option>
    </select>
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">表白内容</label>
    <input type="text" class="form-control" name="content" placeholder="菜单名称">
  </div>
  <button type="submit" class="btn btn-default">表白</button>
</form> -->


<form action="{{url('wechat/confadd_do')}}" method="post" enctype="multipart/form-data">
@csrf
<h3>提醒用户签到</h3>
<div class="form-group">
      <label for="exampleInputEmail1">用户uid</label>
      <input type="text" class="form-control" name="id" value="{{$data->id}}" placeholder="菜单名称">
  </div>
<div class="form-group">
  <div class="form-group">
      <label for="exampleInputEmail1">用户名称</label>
      <input type="text" class="form-control" name="nickname" value="{{$data->nickname}}" placeholder="菜单名称">
  </div>
  <div class="form-group">
  <label for="exampleInputEmail1">是否签到</label>
    <select name="qiandao" class="form-control">
        <option value="1">已签到</option>
        <option value="2">未签到</option>
    </select>
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">总积分</label>
    <input type="text" class="form-control" name="jifen"  value="{{$data->jifen}}" placeholder="菜单名称">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">时间</label>
    <input type="text" class="form-control" name="shi" value="{{$data->shi}}" placeholder="菜单名称">
  </div>
  <button type="submit" class="btn btn-default">发送签到提醒</button>
</form>