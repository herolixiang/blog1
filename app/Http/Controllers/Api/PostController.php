<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Signin;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $data=md5('1901'.'李翔'.'19');
        // dd($data);

        $name =$request->input('name');
        $where =[];
        if(!empty($name)){
            $where[]= ['name','like',"%$name%"];
        }
        //查询数据库
        $data =Signin::where($where)->paginate(2)->toArray();
        // var_dump($data);die;
        //返回json数据
        return json_encode(['code'=>'200','data'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // echo 'create';
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $res= Signin::where(['id'=>$id])->first();
        //  dd($res);
         return json_encode(['code'=>200,'res'=>$res]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        // $id = $request->input('id');


         $name = $request->input('name');
        //dd($name);
        $tel = $request->input('tel');
        $res = Signin::find($id);

        $res->name = $name;
        $res->tel = $tel;
        $res->save();
        if($res){
         return json_encode(['code'=>200,'msg'=>'修改成功']);
        }else{
          return json_encode(['code'=>201,'msg'=>'修改失败']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $id=request()->id;
        $res= Signin::where(['id'=>$id])->delete();
        if($res){
            return json_encode(['code'=>200,'msg'=>'删除成功']);
        }else{
            return json_encode(['code'=>201,'msg'=>'删除失败,程序异常,请联系管理员']);
        }
    }
}
