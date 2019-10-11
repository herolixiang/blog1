<form action="{{url('wechat/qiandao_do')}}" method="post" enctype="multipart/form-data">
@csrf
<h3>签到</h3>
<div class="form-group">
  <label for="exampleInputEmail1">是否签到</label>
    <select name="qiandao" class="form-control">
        <option value="1">已签到</option>
        <option value="2">未签到</option>
    </select>
  </div>
  <button type="submit" class="btn btn-default">签到</button>
</form>