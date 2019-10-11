<h2><b>菜单管理--菜单展示列表</b></h2>
<table class="table-bordered table table-striped table-condensed">
    <tr>
        <td>ID</td>
        <td>菜单名称</td>
        <td>菜单类型</td>
        <td>菜单标识</td>
        <td>编辑</td>
    </tr>
    @foreach($data as $v)
    <tr>
        <td>{{$v->menu_id}}</td>
        <td>{{$v->menu_name}}</td>
        <td>{{$v->menu_type}}</td>
        <td>{{$v->menu_key}}</td>
        <td>
        <a href="">删除</a>
        </td>
    </tr>
    @endforeach
    </table>


<tr>
<a href="/wechat/menuadd"><button type="submit" class="btn btn-primary">添加素材</button></a>
<a href="/wechat/matter"><button type="submit" class="btn btn-primary">一键</button></a>
</tr>