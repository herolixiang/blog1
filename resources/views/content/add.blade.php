<form action="" method="post" enctype="multipart/form-data">
  <table class="table table-bordered table-striped form-horizontal">
    <h3>接口基础-留言添加</h3>
      <div class="form-group">
        <label for="exampleInputEmail1">姓名</label>
        <input type="text" class="form-control" name="nickname" placeholder="用户名">
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">内容</label>
        <input type="text" class="form-control" name="content" placeholder="电话号">
      </div>
      <button type="button" class="btn btn-info sub">添加</button>
  </table> 
</form>

<link rel="stylesheet" href="/css/bootstrap.min.css">
<script src="/js/bootstrap.min.js"></script>
<script src="{{ asset('/js/jquery.min.js') }} "></script>

<script>
    //自定义接口
    var url="http://lx.herolixiang.top/contentt";
    //生成点击事件
    $(".sub").on('click',function(){
        // alert(1);
        //获取值数据
        var nickname=$("[name='nickname']").val();
        var content=$("[name='content']").val();
        // console.log(nickname);
        // console.log(content);
        //用ajax传数据
        $.ajax({
            url:url,  //发送地址
            type:'POST',  //请求方式
            data:{nickname:nickname,content:content},  //发送数据
            dataType:"json",
            success:function(res){
                alert(res.msg);location.href='http://lx.herolixiang.top/content/list';
            }
        });
    });
</script>