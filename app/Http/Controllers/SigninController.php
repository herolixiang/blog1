<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Tools\Wechat;
use DB;
use App\Model\Signin;

class SigninController extends Controller
{
    public $request;
    public $wechat;
    public function __construct(Request $request,Wechat $wechat)
    {
        $this->request = $request;
        $this->wechat = $wechat;
    }
    public function add()
    {
        $data= Signin::get()->toArray();
        $res= json_encode($data);
        if($res){
            return json_encode((['code'=>1,'msg'=>'OK']));
        }else{
            return json_encode((['code'=>0,'msg'=>'ON']));
        }
    }

    //自定义接口
    public function add_do(Request $request)
    {
        $name="招财小李";
        $age="20";
        $tel="18434551398";
        $arr = array($name,$age,$tel);
        sort($arr,SORT_STRING); 
        $tmpStr = implode($arr);//拼接字符串
        $tmpStr = sha1($tmpStr);//得到最终加密签名
        // dd($tmpStr);
        $res=json_encode($tmpStr);
        // dd($res);
        if($res){
            return json_encode(['code'=>1,'msg'=>'ok']);
        }else{
            return json_encode(['code'=>0,'msg'=>'no']);
        }
    }
    
    //调用接口
    public function hai()
    {
        $name="招财小李";
        $age="20";
        $tel="18434551398";
        $str=$name.$age.$tel;
        $sign=sha1($str);
        $url="http://lx.herolixiang.top/signin/add_do?name={$name}&age={$age}&tel={$tel}&tmpStr={$sign}";
        $res=$this->wechat->curlGet($url);
        dd($url);
    }

    //接口添加
    public function signinaddd(Request $request)
    {
        $name= $request->input('name');
        $tel=$request->input('tel');
        $res=Signin::insert([
            'name'=>$name,
            'tel'=>$tel
        ]);
        if($res){
            return json_encode(['code'=>200,'msg'=>'添加成功']);
        }else{
            return json_encode(['code'=>201,'msg'=>'添加失败,程序异常,请联系管理员']);
        }
    }

    //接口展示
    public function list()
    {
        $data =Signin::get()->toArray();
        return json_encode(['code'=>'200','data'=>$data]);
    }

    //接口删除
    public function del()
    {
        $id=request()->id;
        $res= Signin::where(['id'=>$id])->delete();
        if($res){
            return json_encode(['code'=>200,'msg'=>'删除成功']);
        }else{
            return json_encode(['code'=>201,'msg'=>'删除失败,程序异常,请联系管理员']);
        }
    }

    //接口修改
    public function find(Request $request)
    {
        $search=request()->get('search');
        $page=request()->get('page');
        if($page=="搜索"){
            if(empty($search)){
                $data=Signin::get();
                $pages=ceil(count($data)/2);
                $data=Signin::offset(0)->limit(2)->get();
            }else{
                $data=Signin::where('name',$search)->get();
                $pages=ceil(count($data)/2);
                $data=Signin::where('name',$search)->offset(0)->limit(2)->get();
            }
        }else{
            if(empty($search)){
                $data=Signin::get();
                $pages=ceil(count($data)/2);
                $data=Signin::offset(($page-1)*2)->limit(2)->get();
            }else{
                $data=Signin::where('name',$search)->get();
                $pages=ceil(count($data)/2);
                $data=Signin::where('name',$search)->offset(($page-1)*2)->limit(2)->get();
            }
        }
        $data=$data->toArray();
        return json_encode(['code'=>200,'data'=>$data,'pages'=>$pages]);
    }

    public function save(Request $request)
    {
        $id = $request->input('id');


         $name = $request->input('name');
        //dd($name);
        $tel = $request->input('tel');


        $res = Signin::find(10);

        $res->name = $name;
        $res->tel = $tel;
        $res->save();
        if($res){
         return json_encode(['code'=>200,'msg'=>'修改成功']);
        }else{
          return json_encode(['code'=>201,'msg'=>'修改失败']);
        }
    }
}
