<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\StoreCategoryPost;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 父级分类
        $cate=Category::all();
        // dd($cate);
        // 无限极分类
        $cate=createTree($cate);
        //dd($cate);
        return view('admin.category.index',['cate'=>$cate]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //父级分类
        $cate=Category::all();
        //无限极分类
        $cate=createTree($cate);
        return view('admin.category.create',['cate'=>$cate]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryPost $request)
    {
        $cate = $request->except('_token');
        // dd($cate);
        $res = Category::create($cate);
        if($res){
            return redirect('/category');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = Category::destroy($id);
        if(request()->ajax()){
            return $this->success('删除成功!');
        }
        if($res){
            return redirect('/category');
        }
    }

    // 对错号即点即改
    public function check_cateshows(){
        // 接值
        $cate_id=request()->cate_id;
        
        $_field=request()->_field;
        $data[$_field]=request()->is_show==1?2:1;
        //return $data[$_field];
        // dd($_value);
        $res=Category::where(['cate_id'=>$cate_id])->update($data);
        // dump($res);
        if($res){
            return json_encode(['code'=>0,'msg'=>'ok','data'=>$data[$_field]]);
        }else{
            return json_encode(['code'=>-1,'msg'=>'no']);
        }
    }
}
