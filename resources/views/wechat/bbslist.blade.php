<h2><b>微信留言</b></h2>
<table border="1" class="table-bordered table table-striped table-condensed">
    <tr>
        <td>用户uid</td>
        <td>用户名称</td>
        <td>编辑</td>
    </tr>
    @foreach($data as $v)
    <tr>
        <td>{{$v->id}}</td>
        <td>{{$v->nickname}}</td>
        <td>
            <a href="{{url('wechat/bbsadd',['id'=>$v->id])}}">发送留言</a>
        </td>
    </tr>
    @endforeach
</table>