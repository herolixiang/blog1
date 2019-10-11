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
  <button type="button" class="btn btn-info sub">修改</button>
 </table> 
</form>

<link rel="stylesheet" href="/css/bootstrap.min.css">
<script src="/js/bootstrap.min.js"></script>
<script src="{{ asset('/js/jquery.min.js') }} "></script>


<script type="text/javascript">
     var url="http://lx.herolixiang.top/posts";

     var id = getUrlParam('id');
     //alert(id);
     $.ajax({
            url:url+"/"+id,
            type:"GET",
            data:{id:id},
            dataType:'json',
            success:function(res){
                var name = $("[name='name']").val(res.res.name);
                var tel = $("[name='tel']").val(res.res.tel);
               },
        });


      $(".sub").on('click',function(){
        var url="http://lx.herolixiang.top/posts";
        //alert(111);
        var name = $("[name='name']").val();
        var tel = $("[name='tel']").val();
        $.ajax({
            url:url+"/"+id,
            data:{_method:"PUT",name:name,tel:tel},
            dataType:"json",
            type:"POST",
            success:function(res){
                alert(res.msg);location.href='http://lx.herolixiang.top/signin/index';
            }
        })
    })


function getUrlParam(name) {
  var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
  var r = window.location.search.substr(1).match(reg);  //匹配目标参数
  if (r != null) return decodeURI(r[2]); return null; //返回参数值
}


</script>