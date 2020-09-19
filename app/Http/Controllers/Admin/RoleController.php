<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Menu;
use App\Models\Role_menu;
use App\Http\Requests\StoreRolePost;
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $role_name = $request -> role_name;
        $where = [];
        if($role_name){
            $where[] = ['role_name','like',"%$role_name%"];
        }
        
        $role = Role::where($where)->paginate(3);
        if(request()->ajax()){
            return view('admin/role/ajaxpage',['role'=>$role,'query'=>request()->all()]);
        }
        return view('admin/role/index',['role'=>$role,'query'=>request()->all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/role/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRolePost $request)
    {
        $role = $request->except('_token');
        //dd($role);
        $res = Role::create($role);
        if($res){
            return redirect('/role');
        }
    }

    //角色添加权限视图
    public function addpriv($role_id){
        //dump($role_id);
        $Menu = Menu::get();
        //dd($Menu);
        $role_menu = Role_menu::where('role_id',$role_id)->pluck('menu_id');
        
        $role_menu = count($role_menu)?$role_menu->toArray():[];
        // dd($role_menu);
        $Menu = menuTree($Menu);
        return view('admin/role/addpriv',['menu'=>$Menu,'role_id'=>$role_id,'role_menu'=>$role_menu]);
    }

    //角色权限添加
    public function addprivdo(Request $request){
        $post = $request->except('_token');
        // dd($post);
        if(isset($post['menucheck'])){
            Role_menu::where('role_id',$post['role_id'])->delete();
            $data = [];
            foreach($post['menucheck'] as $v){
                $data[]=[
                    'role_id' => $post['role_id'],
                    'menu_id' => $v
                ];
            }
            // dump($data);
            Role_menu::insert($data);
        }
        return redirect('/role');
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
        $role = Role::where('role_id',$id)->first();
        //dd($role);
        return view('admin/role/edit',['role'=>$role]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRolePost $request, $id)
    {
        $role = $request -> except('_token');
        //dd($role);
        $res = Role::where('role_id',$id)->update($role);
        //dd($res);
        if($res!==false){
            return redirect('/role');
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
        $res = Role::destroy($id);
        if(request()->ajax()){
            //dd($this->success('删除成功'));
            return $this->success('删除成功!');
        }
        if($res){
            return redirect('/role');
        }
    }

    public function check_name(){
        $value = request()->value;
        if(!$value){
            return $this->error('值不能为空');
        }
        $role_id = request()->role_id;
        $field = request()->field;
        //echo $value.$brand_id.$field;
        $role = Role::where('role_id',$role_id)->update([$field=>$value]);
        if($role!==false){
            echo 0;
        }else{
            //echo json_encode(['code'=>'00000','msg'=>'ok']);
            echo 'no';
        }
    }
}
