<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Content;
use App\Model\Aes;
class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // echo 'index';
        $data=Content::get()->toArray();
        return json_encode(['code'=>'200','data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // echo 'store';
        //接值
        $nickname =$request->input('nickname');
        // dd($nickname);
        $content=$request->input('content');
        // dd($nickname);
        $res=Content::insert([
            'nickname'=>$nickname,
            'content'=>$content
        ]);
        if($res){
            return json_encode(['code'=>200,'msg'=>'添加成功']);
        }else{
            return json_encode(['code'=>201,'msg'=>'添加失败']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        echo 'show';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        echo 'update';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res=Content::where(['id'=>$id])->delete();
        if($res){
            return json_encode(['code'=>200,'msg'=>'删除成功']);
        }else{
            return json_encode(['code'=>201,'msg'=>'删除失败']);
        }
    }

    
    public function aes(Request $request)
    {
        $authstr = $request->input('authstr');
        $obj = new Aes('1234567890123456');
        $authstr = $obj->decrypt($authstr); //字符串
        if(!$authstr){
            if(empty($name) || empty($age) || empty($mobile)){
                return json_encode(['code'=>201,'msg'=>'小老弟你还嫩的很'],JSON_UNESCAPED_UNICODE);
            }
        }
        $authArr = explode("&",$authstr);
        $args = [];
        foreach ($authArr as $key => $value) {
            $argsArr = explode("=",$value);
            $args[$argsArr[0]] = $argsArr[1];
        }
        //echo 1;die;
        $name = empty($args['name']) ? "" : $args['name'];
        $age = empty($args['age']) ? "" : $args['age'];
        $mobile = empty($args['mobile']) ? "" : $args['mobile'];
        if(empty($name) || empty($age) || empty($mobile)){
            return json_encode(['code'=>201,'msg'=>'笑死我了'],JSON_UNESCAPED_UNICODE);
        }
        $ip = $_SERVER['REMOTE_ADDR'];
        $data = \DB::table('test')->where(['ip'=>$ip])->first();
        //var_dump($data);die;
        if($data){
            return json_encode(['code'=>201,'msg'=>'数据已经入库了'],JSON_UNESCAPED_UNICODE);
        }
        $res = \DB::table('test')->insert(
            [
                'name' => $name,
                'age' => $age,
                'mobile'=>$mobile,
            ]);
        if($res){
            return json_encode(['code'=>200,'msg'=>'恭喜你,入库成功'],JSON_UNESCAPED_UNICODE);
        }
    }
}
