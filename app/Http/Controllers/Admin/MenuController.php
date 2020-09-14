<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $names = request()->names;
        $model=request()->model;
        $where = [];
        if($names){
            $where[]= ['names','like',"%$names%"];
        }
        $model = request()->model;
        if($model){
            $where[]= ['model','like',"%$model%"];
        }
         $menu = Menu::where($where)->orderBy('id','desc')->paginate(3);
        if(request()->ajax()){
            return view('admin/menu/ajaxpage',['menu'=>$menu,'query'=>request()->all()]);
        }
         return view('admin.menu.index',['menu'=>$menu,'query'=>request()->all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.menu.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //表单验证1
        $validatedData = $request->validate([
            'names' => 'required|unique:menu',
            'model' => 'required',
            'controller' => 'required',
            'function' => 'required',
            'route' => 'required'
        ],[
            'names.required' => '权限名称不能为空',
            'names.unique' => '权限名称已存在',
            'model.required' => '模块不能为空',
            'controller.required' => '控制器不能为空',
            'function.required' => '方法不能为空',
            'route.required' => '路由不能为空'
        ]);



        $menu = $request->except('_token');
        // if($request->hasfile("brand_logo")){
        //     $brand_logo=upload("brand_logo");
        // }
        // $brand['brand_logo'] = $brand_logo;
        //dd($brand);
        $res = Menu::create($menu);
        //dd($res);
        if($res){
            return redirect('/menu');
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
        $menu = Menu::find($id);
        //dd($brand);
        return view('admin/menu/edit',['menu'=>$menu]);
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
        $menu = $request->except('_token');
        //dd($brand);
        $res = Menu::where('id',$id)->update($menu);
        //dd($res);
        if($res!==false){
            return redirect('/menu');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id=0)
    {
        $id = request()->id?:$id;
        //dd($id);
        if(!$id){
            return;
        }
        $res = Menu::destroy($id);
        if(request()->ajax()){
            //dd($this->success('删除成功'));
            return $this->success('删除成功!');
        }
        if($res){
            return redirect('/menu');
        }
    }

    public function check_name()
    {
        $value = request()->value;
        $id = request()->id;
        $field = request()->field;
        if(!$value){
            return $this->error('值不能为空');
        }
        $d = request()->id;
        $field = request()->field;
        //echo $value.$brand_id.$field;
        $menu= Menu::where('id',$id)->update([$field=>$value]);
        if($menu==false){
            echo "no";
        }else{
            //echo json_encode(['code'=>'00000','msg'=>'ok']);
            echo 0;
        }
    }
}
