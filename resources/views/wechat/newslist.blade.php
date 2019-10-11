<h2><b>新闻列表展示</b></h2>
<table class="table table-bordered table-striped form-horizontal">
    <tr>
        <td>新闻标题</td>
        <td>新闻内容</td>
    </tr>
    <tr class="add">

    </tr>
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
<script src="{{ asset('/js/jquery.min.js') }} "></script>

<script>
    // alert(1);
    var url="http://lx.herolixiang.top/wechat/listnews";
    $.ajax({
        url:url,
        dataType:'json',
        success:function(res){
             //渲染页面
            var tr="";
            $.each(res.data.data,function(i,v){
                tr+='<tr><td>'+v.title+'</td>\
                    <td>'+v.content+'</td>\
                </tr>';
            })
            $(".add").html(tr);
            var page="";
            //构建页码
            for(var i=1;i<=res.data.last_page;i++){
                page+="<li><a page='"+i+"'>第"+i+"页</a></li>";
            }
            $('.pagination').html(page);
        },
    });


     //分页功能
    //点击分页按钮
    $(document).on('click',".pagination a",function(){
        //获取分页页码
        var page =$(this).attr('page');
        //发送ajax请求到后台接口
        $.ajax({
            url:url,
            type:"GET",
            data:{page:page},
            dataType:'json',
            success:function(res){
             //渲染页面
                var tr="";
                $.each(res.data.data,function(i,v){
                    tr+='<tr><td>'+v.title+'</td>\
                        <td>'+v.content+'</td>\
                    </tr>';
                })
                $(".add").html(tr);
                var page="";
                //构建页码
                for(var i=1;i<=res.data.last_page;i++){
                    page+="<li><a page='"+i+"'>第"+i+"页</a></li>";
                }
                $('.pagination').html(page);
            },
        });
    });
</script>