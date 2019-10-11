<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Tools\Wechat;
use DB;
use App\Model\Mater;
use App\Model\Qrcode;
use App\Model\Menu;
use App\Model\Status;
use App\Model\Bang;
use Illuminate\Support\Facades\Cache;

class WechatController extends Controller
{
    public $request;
    public $wechat;
    public function __construct(Request $request,Wechat $wechat)
    {
        $this->request = $request;
        $this->wechat = $wechat;
    }

    // //微信第三方登陆
    // public function login()
    // {
    //     $redirect_url = "http://lx.herolixiang.top/wechat/code";
    //     $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".env('WECHAT_APPID')."&redirect_uri=".urlencode($redirect_url)."&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
    //     header('Location:'.$url);
    // }

    // /**
    //  * 登录执行操作
    //  */
    // public function code(Request $request)
    // {
    //     $req = $request->all();
    //     $code = $req['code'];
    //     //获取access_token
    //     $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".env("WECHAT_APPID")."&secret=".env("WECHAT_APPSECRET")."&code=".$code."&grant_type=authorization_code";
    //     $re = file_get_contents($url);
    //     $result = json_decode($re,1);
    //     $access_token = $result['access_token'];
    //     //dd($access_token);
    //     $openid = $result['openid'];
    //     //dd($openid);
    //     //获取用户基本信息
    //     $wechat_user_info = $this->wechat->wechat_user_info($openid);
    //     //dd($wechat_user_info);
    //     //去user_openid 表查 是否有数据 openid = $openid
    //     $user_openid = DB::table("wechat")->where(['openid'=>$openid])->first();
    //     if(empty($user_openid)){
    //         //没有数据 注册信息  insert user  user_openid   生成新用户
    //         $user_result = DB::table('user')->insertGetId([
    //             'password' => '',
    //             'name' => $wechat_user_info['nickname'],
    //             'reg_time' => time()
    //         ]);

    //         $openid_result = DB::table('wechat')->insert([
    //             'uid'=>$user_result,
    //             'openid' => $openid,
    //         ]);

    //         //登陆操作
    //         $user_info = DB::table("wechat")->where(['id'=>$user_result])->first();
    //         //$user_info=get_object_vars($user_info);
    //         $request->session()->put('name',$user_info['name']);
    //         echo("<script>alert('登入成功');history.go();location.href='/wechat/conflist';</script>");
    //     }else{
    //         //有数据 在网站有用户 user表有数据[ 登陆 ]
    //         $user_info = DB::table("user")->where(['id'=>$user_openid->uid])->first();
    //         // $user_info=get_object_vars($user_info);
    //         $request->session()->put('name',$user_info['name']);
    //         echo("<script>alert('登入成功');history.go();location.href='/wechat/conflist';</script>");
    //     }
    // }

   //模板列表
	public function template_list()
	{
		$url='https://api.weixin.qq.com/cgi-bin/template/get_all_private_template?access_token='.$this->wechat->get_access_token().'';
		$re=file_get_contents($url);
		dd(json_decode($re,1));
	}

    //模板删除
	public function del_template()
	{
		$url='https://api.weixin.qq.com/cgi-bin/template/del_private_template?access_token='.$this->wechat->get_access_token().'';
		$data =[
			'template_id'=>'o1jBVnH2sOAuIyDjMh60qWTkH--lU3Ngw6n7c1ejm6o'
		];
		$this->wechat->post($url,json_encode($data));
	}
	//推送模板消息
	public function push_template()
	{
		$openid = 'on2efw6EPqBtK512Vg77-ekTc1Wo';
        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$this->wechat->get_access_token();
        $data = [
            'touser'=>$openid,
            'template_id'=>'OEw_I4aAsJ1EwfurAnywLUxF3Q9OPJ5E00nu384c3DU',
            'url'=>'http://www.baidu.com',
            'data' => [
                'first' => [
                    'value' => 'Hero李翔',
                    'color' => ''
                ],
                'keyword1' => [
                    'value' => '对',
                    'color' => ''
                ],
                'keyword2' => [
                    'value' => '没毛病',
                    'color' => ''
                ],
                'remark' => [
                    'value' => '哈哈哈',
                    'color' => ''
                ]
            ]
        ];
        // dd($data);
        $re = $this->wechat->post($url,json_encode($data));
        dd($re);
     
	}

    //上传素材
    public function upload_source()
    {
    	return view('wechat.uploadSource');
    }

    //上传素材处理页面
    public function do_upload(Request $request)
    {
        //接受值
        $name =$request->input('name');
        // dd($name);
        $format =$request->input('format');
        // dd($format);
        $img =$request ->file('img');
        // dd($img);
        $genre =$request ->input('genre');
        // dd($genre);
        $add_time =time();
        if (!$request->hasFile('img') || !$img->isValid()) {
            echo "报错";die;
        }
        // 文件上传 给文件起名字
        $filename =md5(time().rand(1000,9999)).".".$img->getClientOriginalExtension();
        // dd($filename);
        //文件存储位置
        $path =$img -> storeAs('uploads',$filename);
        // dd($path);
        //调用素材接口
        $mediaPash = public_path().'/'.$path;
        // dd($mediaPash);
        // 接口地址 调用token
        $access_token =$this->wechat->get_access_token();
        // dd($res);
        //地址
        if ($genre=='1') {
        $url = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token={$access_token}&type={$format}";
        }else{
        $url ="https://api.weixin.qq.com/cgi-bin/media/upload?access_token={$access_token}&type={$format}";
        }
        $imgPath = new \CURLFile($mediaPash);
        // dd($imgPath);
        $data['media'] = $imgPath;
        // dd($data);
        $res =$this->wechat->post($url,$data);
        // dd($res);
        if (!$res) {
        echo "路径错误";die;
        }
        //转换格式
        $res = \json_decode($res,true);
        // dd($res);
        // if (!isset($res['media_id'])) {
        // echo "请填写图片"; die;
        // }
        //微信素材id
        $media_id = $res['media_id'];
        // dd($media_id);
        $model=new Mater;
        // dd($model);
        $model->name =$name;
        $model->genre =$genre;
        $model->format =$format;
        $model->img =$path;
        $model->add_time=$add_time;
        $model->media_id =$media_id;
        $model->save();
        if($model){
            echo("<script>alert('添加成功');history.go();location.href='/wechat/matterList';</script>");
        }else{
            echo "文件类型错误";die;
        }
    }

    //素材列表展示
    public function matterList()
    {
        $data=DB::table('mater')->get();
        //dd($data);
        return view('wechat/matterList',['data'=>$data]);
    }
   


    //微信接口消息回复
    public function event()
    {
        //接口自动回复
        //$this->checkSignature();
        $data = file_get_contents("php://input");
        //解析XML
        $xml = simplexml_load_string($data,'SimpleXMLElement', LIBXML_NOCDATA);//将 xml字符串 转换成对象
        $xml = (array)$xml; //转化成数组
        //dd($xml);
        $log_str = date('Y-m-d H:i:s') . "\n" . $data . "\n<<<<<<<";
        file_put_contents(storage_path('logs/wx_event.log'),$log_str,FILE_APPEND);
        if($xml['MsgType'] == 'event') {
            if ($xml['Event'] == 'subscribe') { //关注
                // if (isset($xml['EventKey'])) {
                //     //拉新操作
                //     dd('222');
                //     $agent_code = explode('_', $xml['EventKey'])[1];
                //     $agent_info = DB::table('wechat')->where(['openid' => $xml['FromUserName']])->first();
                //     if (empty($agent_info)) {
                //         DB::table('wechat')->insert([
                //             'uid' => $agent_code,
                //             'openid' => $xml['FromUserName'],
                //             'add_time' => time()
                //         ]);
                //     }
                // }
                $nickname=$this->wechat->wechat_user_info($xml['FromUserName'])['nickname'];
                $biaobai_info = DB::table('status')->where(['nickname'=>$nickname])->get()->toArray();
                $num=count($biaobai_info);
                    $message = '';
                    foreach($biaobai_info as $k=>$v){
                        $message .= "欢迎".$v->nickname.'同学'."\n";
                }
                // $message = '欢迎xx同学!';
                $xml_str = '<xml><ToUserName><![CDATA['.$xml['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
                echo $xml_str;
            }
            if($xml['Event'] == 'CLICK') {
                if ($xml['EventKey'] == 'view') {
                    $message = '阿达';
                    //dd($message);
                    $xml_str = '<xml><ToUserName><![CDATA['.$xml['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
                    echo $xml_str;
                }

                if($xml['EventKey'] == 'biaobai'){
                    //dd($xml['FromUserName']);
                    //此处的打印结果是openid 拿到openid 去查信息 取出名字 放入条件
                    $nickname=$this->wechat->wechat_user_info($xml['FromUserName'])['nickname'];
                    $biaobai_info = DB::table('status')->where(['nickname'=>$nickname])->get()->toArray();
                    //dd();
                    $num=count($biaobai_info);
                    $message = '';
                    foreach($biaobai_info as $k=>$v){
                        $message .= '您的积分为:'.intval($k+5).'分'."\n";
                    }
                    $xml_str = '<xml><ToUserName><![CDATA['.$xml['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
                    //$xml_str = '<xml><ToUserName><![CDATA['.$xml['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
                    //dump($xml_str);
                    echo $xml_str;
                }



                // if($xml['EventKey'] == 'biaobai'){
                //     //dd($xml['FromUserName']);
                //     //此处的打印结果是openid 拿到openid 去查信息 取出名字 放入条件
                //     $nickname=$this->wechat->wechat_user_info($xml['FromUserName'])['nickname'];
                //     $biaobai_info = DB::table('content')->where(['nickname'=>$nickname])->get()->toArray();
                //     //dd();
                //     $num=count($biaobai_info);
                //     $message = '';
                //     foreach($biaobai_info as $k=>$v){
                //         $message .= intval($k+1).'、'."《《收到》》".$v->nickname.'表白内容：'.$v->content."\n";
                //     }
                //     $xml_str = '<xml><ToUserName><![CDATA['.$xml['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['."共收到".$num.'条'."\n".$message.']]></Content></xml>';
                //     //$xml_str = '<xml><ToUserName><![CDATA['.$xml['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
                //     //dump($xml_str);
                //     echo $xml_str;
                // }
            }   
        }elseif($xml['MsgType'] == 'text'){
            $message = '你好!';
            //dd($message);
            $xml_str = '<xml><ToUserName><![CDATA['.$xml['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[' . $message . ']]></Content></xml>';
            echo $xml_str;
        }
        //echo $_GET['echostr'];  //第一次访问


        
        //  //$this->checkSignature();
        //  $data = file_get_contents("php://input");
        //  //dd($data);
        //  //解析XML
        //  $xml = simplexml_load_string($data,'SimpleXMLElement', LIBXML_NOCDATA);        //将 xml字符串 转换成对象
        //  $xml = (array)$xml; //转化成数组
        //  $log_str = date('Y-m-d H:i:s') . "\n" . $data . "\n<<<<<<<";
        //  file_put_contents(storage_path('logs/wx_event.log'),$log_str,FILE_APPEND);
        //  $message = '你好!';
        //  $xml_str = '<xml><ToUserName><![CDATA['.$xml['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
        //  echo $xml_str;
        //  //echo $_GET['echostr'];  //第一次访问


        // $xml = file_get_contents("php://input");
        // ////把xml数据写到本到文件里
        // file_put_contents("xml.txt",$xml);
        // //把xml数据转成对象
        // $xml = simplexml_load_string($xml);

        // if ($xml->MsgType == 'text'){
        //     $content = trim($xml->Content);
        //     // dd($content);
        //    if(mb_strpos($content,'天气') !== false){
        //         $n = mb_strpos($content,"天气");
        //         $city = '长治';
        //         if ($n > 0){
        //             $city = mb_substr($content,0,$n);
        //         }
        //         $url = "http://api.k780.com/?app=weather.future&weaid={$city}&&appkey=43585&sign=8633142b004f9501902e318973af01f4";
        //         $data = file_get_contents($url);
        //         $data = json_decode($data,true);
        //         $str = '';
        //         for ($i=0; $i < count($data['result']); $i++) {
        //             $str .= $data['result'][$i]['citynm'].':'.$data['result'][$i]['days'].$data['result'][$i]['week'].':'.$data['result'][$i]['weather'].',气温：'.$data['result'][$i]['temperature']."\r\n";
        //         }
        //         $str = rtrim($str,',');
        //         $this->wechat->responseText($xml,$str);
        //     }else if(mb_strpos($content,'油价')!==false){
        //         $name=mb_substr($content,0,-2);
        //         //dd($name);
        //         $key='e880595d55ec35309b225e4ba035f46a';
        //         $url="http://apis.juhe.cn/cnoil/oil_city?key=$key";
        //         $info=$this->wechat->curlGet($url);
        //         $re=json_decode($info,true);
        //         // dd($re);
        //         foreach($re['result'] as $k=>$v){
        //             if($re['result'][$k]['city']==$name){
        //                $code=$re['result'][$k]['98h'];
        //             }
        //         }
        //         // dd($token);
        //         $uri='https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$this->wechat->get_access_token().'';
        //         $user = sprintf($xml->FromUserName);
        //         $postData=[
        //             'touser'=>$user,
        //             'template_id'=>'97UrM22M4FUNRX4vgIAWoAr0EzPdw3ef-AMubUteDIM',
        //             'data'=>[
        //                 'name'=>[
        //                     'value'=>$name
        //                 ],
        //                 'code'=>[
        //                     'value'=>$code
        //                 ]
        //             ]
        //         ];
        //       $re=json_encode($postData,JSON_UNESCAPED_UNICODE);
        //       $result=$this->wechat->post($uri,$re);
        //       //   dd($result);
        //     }   
        // }
    }


    //二维码添加
    public function qrcode()
    {
        return view('wechat.qrcode');
    }
    //二维码添加执行
    public function qrcode_do(Request $request)
    {
        $name=$request->input('name');
        // dd($name);
        $status=$request->input('status');
        $url='https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$this->wechat->get_access_token().'';
        // dd($url);
        $caca='{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": 123}}}';
        // dd($caca);
        $data=$this->wechat->post($url,$caca);
        // dd($data);
        $data=json_decode($data,1);
        // dd($data);
        $ticket=$data['ticket'];
        // dd($ticket);
        $url="https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=$ticket";
        // dd($url);
        $img=file_get_contents($url);
        // dd($img);
        $qrcode="storage/".md5(time().rand(1000,9999)).".jpg";
        // dd($qrcode);
        file_put_contents($qrcode,$img);
        $model=new Qrcode;
        $model->name =$name;
        $model->status =$status;
        $model->img =$qrcode;
        $model->number=6;
        $model->save();
        // dd($res);
        if($model){
            echo("<script>alert('添加成功');history.go();location.href='/wechat/qrcodelist';</script>");
        }else{
            echo "文件类型错误";die;
        }
    }
    //二维码列表展示
    public function qrcodelist()
    {
        $data=DB::table('qrcode')->get();
        return view('wechat/qrcodelist',['data'=>$data]);
    }


    //菜单添加
    public function menuadd()
    {
        $data=DB::table('menu')->get();
        $data = json_decode($data, true);
        foreach ($data as $key => $value);
        return view('wechat.menuadd',['data'=>$data]);
    }

    //菜单添加执行
    public function menuadd_do(Request $request)
    {
        $data=$request->except(['_token']);
        // dd($data);
        $res=DB::table('menu')->insert($data);
        // dd($data);
        if($res){
            echo("<script>alert('添加成功');history.go();location.href='/wechat/menulist';</script>");
        }else{
            echo("<script>alert('添加失败');history.go();location.href='/wechat/menuadd';</script>");
        }
    }

    //菜单展示
    public function menulist()
    {
        $data=DB::table('menu')->get();
        return view('wechat.menulist',['data'=>$data]);
    }

    //无限极循环
    public function createTreeBySon($data,$parent_id=0)
    {
        $new_arr=[];
        foreach ($data as $key => $value){
            if ($value['parent_id']==$parent_id){
                $new_arr[$key]= $value;
                $new_arr[$key]['son']=$this->createTreeBySon($data,$value['menu_id']);
            }
        }
        return $new_arr;
    }
    
    //菜单一键生成
    public function matter()
    {
        $data=Menu::all()->toArray();
        // dd($data);
        $data=$this->createTreeBySon($data);
        // dd($data);
        $url='https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$this->wechat->get_access_token().'';
        // dd($url);
        $typeArr =[
            'click'=>'key',
            'view'=>'url'
        ];
        // dd($typeArr);
        $postdata=[];
        foreach($data as $k => $v){
            if(!empty($v['son'])){
                //有子菜单
                $postdata['button'][$k]['name']=$v['menu_name'];
                //二级菜单
                foreach($v['son'] as $key=> $value){
                    $postdata['button'][$k]['sub_button'][]=[
                        'type'=>$value['menu_type'],
                        'name'=>$value['menu_name'],
                        $typeArr[$value['menu_type']]=>$value['menu_key']
                    ];
                }
            }else{
                //没有子菜单
                $postdata['button'][]=[
                    'type'=>$v['menu_type'],
                    'name'=>$v['menu_name'],
                    $typeArr[$v['menu_type']]=>$v['menu_key'],
                ];
            }
        }
        
        $postdata=json_encode($postdata,JSON_UNESCAPED_UNICODE);
        // dd($postdata);
        $res=$this->wechat->post($url,$postdata);
        dd($res);
    }

    //表白展示
    public function conflist()
    {
        // $getUserInfo = $this->wechat->getUserInfo();
        // dd($getUserInfo);
        // $openid = $getUserInfo['openid'];
        // $nickname = $getUserInfo['nickname'];

        $data=DB::table('status')->get();
        return view('wechat.conflist',['data'=>$data]);
    }

    //表白添加
    public function confadd($id)
    {
        $data=DB::table('aaa')->where(['id'=>$id])->first();
        return view('wechat.confadd',['data'=>$data]);
    }


    //表白添加执行
     public function confadd_do(Request $request)
     {
         $req=$request->all();
         // dd($req);
         $openid=DB::table('aaa')->where(['id'=>$req['id']])->value('openid'); 
         // dd($openid);
         $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$this->wechat->get_access_token();
         $data = [
             'touser'=>$openid,
             'template_id'=>'32dp7Fd8WboNQSCucVdjqVHhg0EBKMIwnEa4d4k4s7A',
             'url'=>'http://lx.herolixiang.top/wechat/conflist',
             'data' => [
                 'keyword1' => [
                     'value' => $this->wechat->wechat_user_info($openid)['nickname'],
                     'color' => ''
                 ],
                 'keyword2' => [
                     'value' =>$req['qiandao'] == 2?'未签到': '签到',
                     'color' => ''
                 ],
                 'keyword3' => [
                    'value' => $req['jifen'],
                    'color' => ''
                 ],
                'keyword4' => [
                    'value' => $req['shi'],
                    'color' => ''
                ]
             ]
         ];
        //  // dd($data);
         $re = $this->wechat->post($url,json_encode($data));
        //  $result = DB::table('content')->insert([
        //      'nickname'=>$req['nickname'],
        //      'content'=>$req['content']
        //  ]);
         if($re){
             echo("<script>alert('提醒成功');history.go();location.href='/wechat/conflist';</script>");
         }else{
             echo("<script>alert('提醒失败');history.go();location.href='/wechat/conflist';</script>");
         }
     }

    // //表白添加执行
    // public function confadd_do(Request $request)
    // {
    //     $req=$request->all();
    //     // dd($req);
    //     $openid=DB::table('status')->where(['id'=>$req['id']])->value('openid'); 
    //     // dd($openid);
    //     $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$this->wechat->get_access_token();
    //     // dd($url);
    //     $data = [
    //         'touser'=>$openid,
    //         'template_id'=>'KoKQxeU82Hxyo9OTwyMist_RBJam3CRkrFPuz2YLHDE',
    //         'url'=>'http://lx.herolixiang.top/wechat/bbslist',
    //         'data' => [
    //             'keyword1' => [
    //                 'value' => $req['nickname'] == 2?'匿名用户' :$this->wechat->wechat_user_info($openid)['nickname'],
    //                 'color' => ''
    //             ],
    //             'keyword2' => [
    //                 'value' => $req['content'],
    //                 'color' => ''
    //             ]
    //         ]
    //     ];
    //     // dd($data);
    //     $re = $this->wechat->post($url,json_encode($data));
    //     // dd($re);
    //     if($re){
    //         echo("<script>alert('表白成功');history.go();location.href='/wechat/conflist';</script>");
    //     }else{
    //         echo("<script>alert('表白失败');history.go();location.href='/wechat/confadd';</script>");
    //     }
    // }

    //留言展示
    public function bbslist()
    {
        // $getUserInfo = $this->wechat->getUserInfo();
        $data=DB::table('status')->get();
        return view('wechat.bbslist',['data'=>$data]);
    }

    //留言添加
    public function bbsadd($id)
    {
        $data=DB::table('status')->where(['id'=>$id])->first();
        return view('wechat.bbsadd',['data'=>$data]);
    }


    //留言添加执行
    public function bbsadd_do(Request $request)
    {
        $req=$request->all();
        // dd($req);
        $openid=DB::table('status')->where(['id'=>$req['id']])->value('openid'); 
        // dd($openid);
        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$this->wechat->get_access_token();
        $data = [
            'touser'=>$openid,
            'template_id'=>'2nc8GHhFSkSdJ8wdbJ8W2wYYfQFK9IfMm5ReaZ91QsY',
            'url'=>'http://lx.herolixiang.top/wechat/bbslist',
            'data' => [
                'keyword1' => [
                    'value' => $this->wechat->wechat_user_info($openid)['nickname'],
                    'color' => ''
                ],
                'keyword2' => [
                    'value' => $req['content'],
                    'color' => ''
                ]
            ]
        ];
        // dd($data);
        $re = $this->wechat->post($url,json_encode($data));
        $result = DB::table('content')->insert([
            'nickname'=>$req['nickname'],
            'content'=>$req['content']
        ]);
        if($re){
            echo("<script>alert('留言成功');history.go();location.href='/wechat/bbslist';</script>");
        }else{
            echo("<script>alert('留言失败');history.go();location.href='/wechat/bbsadd';</script>");
        }
    }

    //获取用户信息
    public function index()
	{
		//获取access_token
		// $access_token='';
		$redis=new\Redis();
		$redis->connect('127.0.0.1','6379');
		$access_token_key='wechat_access_token';
		if ($redis->exists($access_token_key)) {
			//去拿缓存
			$access_token=$redis->get($access_token_key);
		}else{
			$access_re=file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".env('WECHAT_APPID')."&secret=".env('WECHAT_APPSECRET')."");
			$access_result=json_decode($access_re,1);
			$access_token=$access_result['access_token'];
			$expire_time=$access_result['expires_in'];
			//加入缓存
			$redis->set($access_token_key,$access_token,$expire_time);
		}
		return $access_token;
	}

    //用户入口
    public function info()
	{
		$access_token=$this->index();
		$openid='on2efw6EPqBtK512Vg77-ekTc1Wo';
		$wechat_user=file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$openid."&lang=zh_CN");
		// dd($wechat_user);die;
		$user_info=json_decode($wechat_user,1);
		// dd($user_info);die;
		//用户添加入库
		$data=[
			'openid'=>$user_info['openid'],
			'nickname'=>$user_info['nickname'],
			'sex'=>$user_info['sex'],
			'country'=>$user_info['country'],
			'province'=>$user_info['province'],
			'city'=>$user_info['city'],
			'headimgurl'=>$user_info['headimgurl'],
			'time'=>time()
		];
		// dd($data);
		$res=DB::table('status')->insert($data);
		if ($res) {
			echo "<script>alert('入库成功');location.href='/';</script>";
		}else{
			echo "<script>alert('入库失败');location.href='';</script>";
		}
	}

    //签到添加
    public function qiandao()
    {
        $data=DB::table('status')->get();
        return view('wechat.qiandao',['data'=>$data]);
    }

    //签到添加执行
    public function qiandao_do(Request $request)
    {
        $data=$request->except(['_token']);
        $res=DB::table('content')->insert($data);
        // dd($res);
        if ($res) {
			echo "<script>alert('签到成功');location.href='/';</script>";
		}else{
			echo "<script>alert('签到失败');location.href='';</script>";
		}
    }

    //调用新闻接口
    public function addnews()
    {
        $url="http://api.avatardata.cn/ActNews/Query?key=8461e799ee154e90a79244a591a79714&keyword=NBA";
        $data=$this->wechat->curlGet($url);
        $data=json_decode($data,true);
        // dd($data);
        if(empty($data['result'])){
            //提示错误
            echo '接口调用无效';die;
        }
        //直接使用缓存类 驱动改成redis
        foreach($data['result'] as $key=>$value){
            //判断当前新闻是否在库里
            $newsData=DB::table('news')->where(['title'=>$value['title']])->first();
            if(!$newsData){
                DB::table('news')->insert(
                    [
                        'title'=>$value['title'],
                        'content'=>$value['content']
                    ]
                );
            }
        }
        //将数据库存入redis缓存里
        //读取数据库 存入redis
        $data =DB::table('news')->get();
        Cache::put("news_data",$data,10);
        echo json_encode(['code'=>200,'msg'=>"接口入库成功"]);
    }
    //新闻入库展示
    public function listnews()
    {
        $data =DB::table('news')->paginate(2)->toArray();
        return json_encode(['code'=>200,'data'=>$data]);
    }

    //登陆添加
    public function bangadd()
    {
        return view('wechat.bangadd');
    }
    //登陆添加执行
    public function bangadd_do(Request $request)
    {
        $name=$request->input('name');
        $pwd=$request->input('pwd');
        $yan=$request->input('yan');
        
        // dd($yan);
        // 从缓存里取
        $data = Cache::get('code'.$name);
        // dd($data);
        if($data != $yan){
            echo "<script>alert('验证码不正确');location.href='/wechat/bangadd';</script>";die;
        }
		//验证用户名和密码是否正确
        $bandData = Bang::where(['name'=>$name,'pwd'=>$pwd])->first();
        if (!$bandData) {
			//报错
            echo "<script>alert('用户名密码错误');location.href='/wechat/bangadd';</script>";
		}else{                          
			//登陆成功
            echo "<script>alert('登陆成功');location.href='/';</script>";
		}
    }
    //发送验证码
    public function yan(Request $request)
    {
        $data=$request->all();
        $name=$request->input('name');
        $pwd=$request->input('pwd');
        $bandData = Bang::where(['name'=>$name,'pwd'=>$pwd])->first();
        $openid=$bandData['openid'];
        $codes=rand(1000,9999);
        //验证码缓存
        $code="code".$name;
        //存缓存
        Cache::put($code,$codes,60);
        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$this->wechat->get_access_token();
        // dd($url);
        $data = [
            'touser'=>"on2efw6EPqBtK512Vg77-ekTc1Wo",
            'template_id'=>'YdT94z9LQ3WQfHDlcYGoJRD1EAYFIEOYk2bS27gWp8I',
            'url'=>'',
            'data' => [
                'keyword1' => [
                    'value' => $codes,
                    'color' => ''
                ],
                'keyword2' => [
                    'value' => $name,
                    'color' => ''
                ]
            ]
        ];
        // dd($data);
        $res = $this->wechat->post($url,json_encode($data));
        // var_dump($res);
    }

    //绑定账号
    public function dingadd()
    {
        $openid=$this->wechat->getUserInfo();
        // dd($openid);
        return view('wechat.dingadd'); 
    }
    //绑定账号执行
    public function dingadd_do(Request $request)
    {
        $data=$request->all();
        // dd($data);
        $name=$request->input('name');
        $pwd=$request->input('pwd');
        // dd($name);
		//验证用户名和密码是否正确
        $resData = Bang::where(['name'=>$name,'pwd'=>$pwd])->first();
        // var_dump($resData);die;
        if ($resData) {
            $a=session('openid');
            $openid= $a['openid'];
            // dd($openid);
            $data=Bang::where(['name'=>$name,'pwd'=>$pwd])->update(['openid'=>$openid]);
            // dd($data);
			echo "<script>alert('绑定成功');location.href='/wechat/bangadd';</script>";
		}else{
			echo "<script>alert('绑定失败');location.href='';</script>";
		}
    }
}
