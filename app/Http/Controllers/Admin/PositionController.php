<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Position;
class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $position = Position::orderBy('position_id','desc')->paginate(5);
        if(request()->ajax()){
            // dd('ajax');
            return view('admin/position/ajaxpage',['position'=>$position]);
        }
        return view('admin/position/index',['position'=>$position]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/position/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $position = $request->except('_token');
        // dd($position);
        $res = Position::create($position);
        if($res){
            return redirect('/position');
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
        $position = Position::where('position_id',$id)->first();
        // dd($position);
        return view('admin/position/edit',['position'=>$position]);
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
        $position = $request->except('_token');
        // dd($position);
        $res = Position::where('position_id',$id)->update($position);
        if($res !== false){
            return redirect('/position');
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
        $res = Position::destroy($id);
        if(request()->ajax()){
            //dd($this->success('删除成功'));
            return $this->success('删除成功!');
        }
        if($res){
            return redirect('/position');
        }
    }

    public function check_name(){
        $value = request()->value;
        if(!$value){
            return $this->error('值不能为空');
        }
        $position_id = request()->brand_id;
        $field = request()->field;
        //echo $value.$brand_id.$field;
        $brand = Position::where('position_id',$position_id)->update([$field=>$value]);
        if($brand==false){
            echo "no";
        }else{
            //echo json_encode(['code'=>'00000','msg'=>'ok']);
            echo 0;
        }
    }
}
