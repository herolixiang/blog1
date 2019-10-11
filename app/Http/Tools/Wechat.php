<?php
namespace App\Http\Tools;
use Illuminate\Http\Request;

class Wechat{

    /**
     * 非静默授权获取用户信息
     */
    public static function getUserInfo()
    {
        $openid=session('openid');
        if($openid){
            return $openid;
        }
        $code=request()->get('code');
        if($code){
            $appid="wx15b3d3595792faca";
            $secret="04c8424ddd463808467ec4f04b14cd44";
            $url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$secret&code=$code&grant_type=authorization_code";
            $re = file_get_contents($url);
            $re=json_decode($re,true);
            // dd($re);
            $access_token=$re['access_token'];
            // dd($access_token);
            $openid=$re['openid'];
            // dd($openid);
            $url="https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";
            // dd($url);
            $info=file_get_contents($url);
            $info=json_decode($info,true);
            // dd($info);
            session(['openid'=>$info]);
        }else{
            $host=$_SERVER['HTTP_HOST'];
            $uri=$_SERVER['REQUEST_URI'];
            $appid="wx15b3d3595792faca";
            $redirect_uri=urlencode("http://".$host.$uri);
            $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$redirect_uri&response_type=code&scope=snsapi_userinfo&state=111#wechat_redirect";
            header("location:".$url);die;
        }
        return $info;
    }

    //用户信息接口
    public function wechat_user_info($openid)
    {
        $access_token = $this->get_access_token();
        $wechat_user = file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$openid."&lang=zh_CN");
        $user_info = json_decode($wechat_user,1);
        return $user_info;
    }

    //post方法
	public function post($url, $data){
        //初使化init方法
        $ch = curl_init();
        //指定URL
        curl_setopt($ch, CURLOPT_URL, $url);
        //设定请求后返回结果
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //声明使用POST方式来进行发送
        curl_setopt($ch, CURLOPT_POST, 1);
        //发送什么数据
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        //忽略证书
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        //忽略header头信息
        curl_setopt($ch, CURLOPT_HEADER, 0);
        //设置超时时间
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        //发送请求
        $output = curl_exec($ch);
        //关闭curl
        curl_close($ch);
        //返回数据
        return $output;
    }

    //access_token方法
    public function get_access_token(){
        //获取access_token
        $redis = new \Redis();
        $redis->connect('127.0.0.1','6379');
        $access_token_key = 'wechat_access_token';
        if($redis->exists($access_token_key)){
            //去缓存拿
            $access_token = $redis->get($access_token_key);
        }else{
            //去微信接口拿
            $access_re = file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".env('WECHAT_APPID')."&secret=".env('WECHAT_APPSECRET'));
            $access_result = json_decode($access_re,1);
            $access_token = $access_result['access_token'];
            $expire_time = $access_result['expires_in'];
            //加入缓存
            $redis->set($access_token_key,$access_token,$expire_time);
        }
        return $access_token;
    }

    
    //xml数据自动回复天气
    public function responseText($xml,$msg){
        echo "<xml>
            <ToUserName><![CDATA[".$xml->FromUserName."]]></ToUserName>
            <FromUserName><![CDATA[".$xml->ToUserName."]]></FromUserName>
            <CreateTime>".time()."</CreateTime>
            <MsgType><![CDATA[text]]></MsgType>
            <Content><![CDATA[".$msg."]]></Content>
        </xml>";die;
    }

    public function tuweText($xml,$media_id){
        echo "<xml>
            <ToUserName><![CDATA[".$xml->FromUserName."]]></ToUserName>
            <FromUserName><![CDATA[".$xml->ToUserName."]]></FromUserName>
            <CreateTime>".time()."</CreateTime>
            <MsgType><![CDATA[image]]></MsgType>
            <Image>
            <MediaId><![CDATA[".$media_id."]]></MediaId>
            </Image>
        </xml>>";
    }

    public function curlGet($url)
    {
        //1初始化
        $ch = curl_init();
        //2设置
        curl_setopt($ch,CURLOPT_URL,$url); //访问地址
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); //返回格式  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false); // 对认证证书来源的检查
        //3执行
        $content = curl_exec($ch);
        //4关闭 
        curl_close($ch);
        return $content;
    }
    
    public function curl($url,$method="GET",$postData=[],$header=[])
	{
		//1初始化
		$ch = curl_init();
		//2设置
		curl_setopt($ch,CURLOPT_URL,$url); //访问地址
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); //返回格式 
		if($method == "POST"){
			curl_setopt($ch,CURLOPT_POST, 1); // 发送一个常规的Post请求
			curl_setopt($ch,CURLOPT_POSTFIELDS,$postData); // Post提交的数据包 
		}
		if(!empty($header)){
			curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
		}
		//请求网址是https
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false); // 对认证证书来源的检查
		//3执行
		$content = curl_exec($ch);
		curl_close($ch);
		return $content;
	}
}
?>