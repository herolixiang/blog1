 <h3>接口基础-用户展示</h3>
        用户姓名：<input type="text" name="name" id="name" >
        <input type="button" class='search btn btn-info' value='搜索'>
    <table class="table table-bordered table-striped form-horizontal">
        <tr>
            <td>Id</td>
            <td>姓名</td>
            <td>电话</td>
            <td>操作</td>
        </tr>
        <tbody class="add">
            
        </tbody>
    </table>

    <nav aria-label="Page navigation">
        <ul class="pagination">
            <!-- <li>
            <a href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a> -->
            <!-- </li> -->
            <li><a href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">5</a></li>
            <!-- <li>
            <a href="#" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
            </li> -->
        </ul>
    </nav>

    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <script src="/js/bootstrap.min.js"></script>
    <script src=" {{ asset('/js/jquery.min.js') }} "></script>

<script>

    var url="http://lx.herolixiang.top/posts";
    //发送ajax请求调用展示接口
    $.ajax({
        url:url,
        type:"GET",
        dataType:'json',
        success:function(res){
            myshop(res);
        },
    });

    //删除功能
    //点击删除按钮
    $(document).on('click','.del',function(){
    var url="http://lx.herolixiang.top/posts";
        var id = $(this).attr('id');
        var _this=$(this);
        $.ajax({
            url:url+"/"+id,
            type:"DELETE",
            dataType:'json',
            success:function(res){
                // console.log(res);
               _this.parents('tr').remove();
               alert(res.msg);location.href='http://lx.herolixiang.top/signin/index';
            },
        });
    });

    //修改跳转链接
    $(document).on('click','.save',function(){
        var id = $(this).attr('id');
        location.href='http://lx.herolixiang.top/signin/signinsave?id='+id+'';
    });

    //搜索功能
    //点击搜索按钮
    $(".search").on('click',function(){
        //获取搜索内容
        var name=$("#name").val();
        //发送ajax请求后台接口
        $.ajax({
            url:url,
            type:"GET",
            data:{name:name},
            dataType:'json',
            success:function(res){
                myshop(res);
            },
        });
    });

    //分页功能
    //点击分页按钮
    $(document).on('click',".pagination a",function(){
        //获取分页页码
        var page =$(this).attr('page');
        var name=$("#name").val();
        //发送ajax请求到后台接口
        $.ajax({
            url:url,
            type:"GET",
            data:{page:page,name:name},
            dataType:'json',
            success:function(res){
                myshop(res);
            },
        });
    });

    function myshop(res)
    {
         //渲染页面
         var tr="";
        //通过js循环res里数据 进行页面渲染
            $.each(res.data.data,function(i,v){
                tr+='<tr><td>'+v.id+'</td><td>'+v.name+'</td>\
                    <td>'+v.tel+'</td>\
                    <td><button class="del btn btn-danger" id='+v.id+'>删除</button>||<button class="save btn btn-success" id='+v.id+'>修改</button></td></tr>';
            })
            $(".add").html(tr);
            var page="";
            //构建页码
            for(var i=1;i<=res.data.last_page;i++){
                page+="<li><a page='"+i+"'>第"+i+"页</a></li>";
            }
            $('.pagination').html(page);
    }
</script>
