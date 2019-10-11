
<h2><b><center>素材管理--素材添加</center></b></h2>
<form action="/wechat/do_upload" method="post" enctype="multipart/form-data">
@csrf
<div class="form-group">
<label for="exampleInputEmail1">素材名称：</label>
<input type="text" class="form-control" name="name" id="exampleInputEmail1" placeholder="素材名称">
</div>
<div class="form-group">
<label for="exampleInputPassword1">素材格式：</label>
<select class="form-control" name="format">
<option value="image">图片</option>
<option value="voice">语音</option>
<option value="video">视频</option>
</select>
</div>

<div class="form-group">
<label for="exampleInputPassword1">素材类型：</label>
<select class="form-control" name="genre">
<option value="1">永久素材</option>
<option value="2">临时素材</option>
</select>
</div>

<div class="form-group">
<label for="exampleInputFile">素材文件：</label>
<input type="file" id="exampleInputFile" name="img">
</div>


<button type="submit" class="btn btn-success">添加</button>

</form>
