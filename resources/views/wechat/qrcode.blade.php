<form action="{{url('wechat/qrcode_do')}}" method="post" enctype="multipart/form-data">
<!-- <meta name="csrf-token" content="{{ csrf_token() }}"> -->
@csrf
<h3>渠道上传</h3>
  <div class="form-group">
  
    <label for="exampleInputEmail1">名称</label>
    <input type="text" class="form-control" id="name" name="name" placeholder="名称">
  </div>
  <div class="form-group">
  
  <label for="exampleInputEmail1">标识</label>
  <input type="text" class="form-control" id="status" name="status" placeholder="标识">
</div>
<button>添加</button>
</form>