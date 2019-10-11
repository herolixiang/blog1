<h2><center><b>微信二维码列表展示</b><center></h2>
<table border="1">
        <tr>
                <td>ID</td>
                <td>名称</td>
                <td>标识</td>
                <td>二维码</td>
                <td>关注</td>
                <td>操作</td>
        </tr>
        @foreach($data as $v)
        <tr>
                <td>{{$v->id}}</td>
                <td>{{$v->name}}</td>
                <td>{{$v->status}}</td>
                <td><img src="\{{$v->img}}" width="100"></td>
                <td>{{$v->number}}</td>
        </tr>
        @endforeach
</table>


