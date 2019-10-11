<h3>接口基础-留言展示</h3>
    <table class="table table-bordered table-striped form-horizontal">
        <tr>
            <td>Id</td>
            <td>姓名</td>
            <td>留言内容</td>
            <td>操作</td>
        </tr>
        <tbody class="add">
            
        </tbody>
    </table>

    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <script src="/js/bootstrap.min.js"></script>
    <script src=" {{ asset('/js/jquery.min.js') }} "></script>

<script>
    var url="http://lx.herolixiang.top/contentt";
    $.ajax({
        url:url,
        type:"GET",
        dataType:'json',
        success:function(res){
            //渲染页面
            $.each(res.data,function(i,v){
                var tr= $("<tr></tr>");  //构建一个空对象
                tr.append("<td>"+v.id+"</td>");
                tr.append("<td>"+v.nickname+"</td>");
                tr.append("<td>"+v.content+"</td>");
                tr.append("<td><a href='"+url+"/"+v.id+"' class='del btn btn-danger'>删除</a>  |  <a href='#' class='save btn btn-danger'>编辑</a></td>");
                $(".add").append(tr);
            });
        },
    });

    //删除事件(动态元素需要使用document)
    $(document).on('click',".del",function(){
        //在ajax中如果用当前对象 需要提前定义$(this)
        var _this=$(this);
        //禁止a标签跳转
        event.preventDefault();
        //要请求地址
        var url=_this.attr('href');
        //发送delete请求删除 
        $.ajax({
            url:url,
            type:"delete",
            dataType:"json",
            success:function(res){
                _this.parents('tr').remove();
                alert(res.msg);location.href='http://lx.herolixiang.top/content/list';
            }
        });
    });

    //修改跳转链接
    $(document).on('click','.save',function(){
        var id = $(this).attr('id');
        location.href='http://lx.herolixiang.top/content/save?id='+id+'';
    });
</script>