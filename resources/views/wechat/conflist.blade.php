<h2><b>提醒用户签到</b></h2>
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
            <a href="{{url('wechat/confadd',['id'=>$v->id])}}">用户签到</a>
        </td>
    </tr>
    @endforeach
</table>