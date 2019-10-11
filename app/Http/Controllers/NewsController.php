<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\News;
use DB;
class NewsController extends Controller
{
    public function regadd()
    {
        return view('news.regadd');
    }

    public function regadd_do(Request $request)
    {
            $data=$request->except(['_token']);
            $a = range(0,9);
			for($i=0;$i<18;$i++){
				$b[] = array_rand($a);
			} 
			// dd($b);
			$rand = md5(time() . mt_rand(0,1000));
			// dd($rand);
			// var_dump(join("",$b));die;
			$dataData =News::insert([
				'name'=>$data['name'],
				'pwd' =>$data['pwd'],
				'appid' =>join("",$b),
				'appsecret'=>$rand,
            ]);
            // return json_encode(['code'=>200,'msg'=>$dataData]);
            if($dataData){
                echo("<script>alert('注册成功');history.go();location.href='/news/login';</script>");
            }else{
                echo("<script>alert('注册失败');history.go();location.href='/news/regadd';</script>");
            }
    }
    public function log(Request $request)
    {
        //接收用户名 密码
		$name=$request->input('name');
		$pwd=$request->input('pwd');
		//验证用户名和密码是否正确
		$newsData = News::where(['name'=>$name,'pwd'=>$pwd])->first();
		if (!$newsData) {
			//报错
			echo '用户名密码错误';die;
		}else{
			//登陆成功
			//生成一个令牌
			$token=md5($newsData['id'].time());  //MD5(用户id+时间戳)
			//存储到数据库中
			$newsData->token= $token;
			$newsData->expire_time =time()+7200;
			$newsData->save();
			return json_encode(['code'=>200,'msg'=>'登陆成功','data'=>$token]);
		}
    }
    public function login_do(Request $request)
    {
        $token = $request->input("token"); //接受token令牌
		if (empty($token)) {
			return json_encode(['code'=>201,'msg'=>"请先登录"]);
		}
		//检测token是否正确
		$userData = News::where(['token'=>$token])->first();
		if (!$userData) {
			return json_encode(['code'=>201,'msg'=>"请先登录"]);
		}
		//判断有效期
		if(time()>$userData['expire_time']){
			return json_encode(['code'=>202,'msg'=>"请从新登陆"]);
		}
		//更新token有效期(业物)
		$userData->expire_time=time()+5;
		$userData->save();

		//查询用户信息
		echo "admin";die;
    }
}
