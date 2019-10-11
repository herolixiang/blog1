<form action="{{url('wechat/menuadd_do')}}" method="post" enctype="multipart/form-data">
@csrf
<h3>菜单上传  微信菜单 </h3>
  <div class="form-group">
    <label for="exampleInputEmail1">菜单名称</label>
    <input type="text" class="form-control" id="menu_name" name="menu_name" placeholder="菜单名称">
  </div>
  <div class="form-group">
  
  <label for="exampleInputEmail1">菜单类型</label>
    <select name="menu_type" id="" class="form-control">
        <option value="click">点击类型</option>
        <option value="view">跳转类型</option>
       
    </select>
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">上级菜单</label>
    <select name="parent_id" id="" class="form-control">
        <option value="0">一级菜单</option>
        @foreach($data as $v)
          <option value="{{$v['menu_id']}}">{{$v['menu_name']}}</option>
        @endforeach
        
    </select>
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">菜单标识</label>
    <input type="text" class="form-control" id="menu_key" name="menu_key" placeholder="菜单标识">
  </div>
  
   
  <button type="submit" class="btn btn-default">添加</button>
</form>