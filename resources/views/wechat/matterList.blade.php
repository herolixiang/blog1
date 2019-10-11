
<h2><center><b>微信素材管理--素材列表</b><center></h2>


<table border="1">
        <tr>
                <td>ID</td>
                <td>素材名称</td>
                <td>素材图片</td>
                <td>素材类型</td>
                <td>素材格式</td>
                <td>添加时间</td>
                <td>操作</td>
        </tr>
       
        @foreach($data as $d)
        <tr>
                <td>{{$d->id}}</td>
                <td>{{$d->name}}</td>
                <td>
                        @if($d->format=='image')
                        <img src="{{asset($d->img)}}" alt="" width="80px">
                        @elseif($d->format=='video')
                        <video src="{{asset($d->img)}}" width="200px" controls="controls">
                        @elseif($d->format=='voice')
                        <audio src="{{asset($d->img)}}" width="100px" controls="controls">
                        @elseif($d->format=='thumb')
                        缩略图
                        @endif
                </td>

                <td>
                        @if($d->format=='image')
                        图片
                        @elseif($d->format=='video')
                        视频
                        @elseif($d->format=='voice')
                        语音
                        @elseif($d->format=='thumb')
                        缩略图
                        @endif
                </td>

                <td>
                        @if($d->genre=='1')
                        永久素材
                        @else
                        临时素材
                        @endif
                </td>

                <td>{{date('Y-m-d H:i:s',$d->add_time)}}</td>

                <td>
                        <a href="{{url('/admin/matterDel',['id'=>$d->id])}}" class="btn btn-danger">删除</ a>
                </td>
        </tr>
        @endforeach
	
</table>


