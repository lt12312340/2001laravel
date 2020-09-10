<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Http\Requests\StoreBrandPost;
class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brand_name = request()->brand_name;
        $where = [];
        if($brand_name){
            $where[]= ['brand_name','like',"%$brand_name%"];
        }
        $brand_url = request()->brand_url;
        if($brand_url){
            $where[]= ['brand_url','like',"%$brand_url%"];
        }

        
        $brand = Brand::where($where)->orderBy('brand_id','desc')->paginate(5);
        if(request()->ajax()){
            return view('admin/brand/ajaxpage',['brand'=>$brand,'query'=>request()->all()]);
        }
        //dd($brand);
        return view('admin/brand/index',['brand'=>$brand,'query'=>request()->all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/brand/create');
    }

    public function upload(Request $request){
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $photo = $request->file;
            
            $store_result = $photo->store('upload');
            //return $this->success(['msg'=>'上传成功','data'=>env('UPLOADS_URL').$store_result]);
            //return json_encode(['code'=>0,'msg'=>'上传成功','data'=>env('UPLOADS_URL').$store_result]);
            return $this->success('上传成功',env('UPLOADS_URL').$store_result);
        }
            return $this->error('上传失败');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //public function store(Request $request)

    //表单验证2
    public function store(StoreBrandPost $request)
    {
        //表单验证1
        // $validatedData = $request->validate([
        //     'brand_name' => 'required|unique:brand',
        //     'brand_url' => 'required',
        // ],[
        //     'brand_name.required' => '品牌名称不能为空',
        //     'brand_name.unique' => '品牌名称已存在',
        //     'brand_url.required' => '品牌网址不能为空'
        // ]);



        $brand = $request->except('_token','file');

        // if($request->hasfile("brand_logo")){
        //     $brand_logo=upload("brand_logo");
        // }
        // $brand['brand_logo'] = $brand_logo;
        //dd($brand);
        $res = Brand::create($brand);
        //dd($res);
        if($res){
            return redirect('/brand');
        }
    }

    // public function upload($filename){
    //     $file=request()->file($filename);
    //     if($file->isValid()){
    //         $path=$file->store('uploads');
    //         return $path;
    //     }
    // }

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
        $brand = Brand::find($id);
        //dd($brand);
        return view('admin/brand/edit',['brand'=>$brand]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreBrandPost $request, $id)
    {
        $brand = $request->except('_token');
        //dd($brand);
        $res = Brand::where('brand_id',$id)->update($brand);
        //dd($res);
        if($res!==false){
            return redirect('/brand');
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
        $res = Brand::destroy($id);
        if(request()->ajax()){
            //dd($this->success('删除成功'));
            return $this->success('删除成功!');
        }
        if($res){
            return redirect('/brand');
        }
    }

    public function check_name(){
        $value = request()->value;
        if(!$value){
            return $this->error('值不能为空');
        }
        $brand_id = request()->brand_id;
        $field = request()->field;
        //echo $value.$brand_id.$field;
        $brand = Brand::where('brand_id',$brand_id)->update([$field=>$value]);
        if($brand==false){
            echo "no";
        }else{
            //echo json_encode(['code'=>'00000','msg'=>'ok']);
            echo 0;
        }
    }
}
