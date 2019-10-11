<form action="" method="post" enctype="multipart/form-data">
  <table class="table table-bordered table-striped form-horizontal">
    <h3>接口基础-会员添加</h3>
      <div class="form-group">
        <label for="exampleInputEmail1">用户名</label>
        <input type="text" class="form-control" name="name" placeholder="用户名">
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">电话号</label>
        <input type="text" class="form-control" name="tel" placeholder="电话号">
      </div>
      <button type="button" class="btn btn-info sub">添加</button>
  </table> 
</form>

<link rel="stylesheet" href="/css/bootstrap.min.css">
<script src="/js/bootstrap.min.js"></script>
<script src="{{ asset('/js/jquery.min.js') }} "></script>


<script>
    var url="http://lx.herolixiang.top/posts";
    $(".sub").on('click',function(){
        // alert(1);
        var name=$("[name='name']").val();
        var tel=$("[name='tel']").val();
        //调用后台接口
        $.ajax({
            url:url,
            type:"POST",
            data:{name:name,tel:tel},
            dataType:"json",
            success:function(res){
                // alert(res.msg);
                alert(res.msg);location.href='http://lx.herolixiang.top/signin/index';
            }
        });
    });
</script>