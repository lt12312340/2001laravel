<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Position;
use App\Models\Ad;
class AdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ad = Ad::leftjoin("position","ad.position_id","=","position.position_id")->orderBy('ad_id','desc')->paginate(5);
        // dd($ad);
        return view('admin/ad/index',['ad'=>$ad]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $position = Position::all();
        // dd($position);
        return view('admin/ad/create',['position'=>$position]);
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
    public function store(Request $request)
    {
        $ad = $request->except('_token');
        $ad['start_time'] = strtotime($ad['start_time']);
        $ad['end_time'] = strtotime($ad['end_time']);
        // dd($ad);
        $res = Ad::create($ad);
        if($res){
            return redirect('/ad');
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

    //查看广告
    public function showads(Request $request,$position_id){
        $ad = Ad::leftjoin('position','ad.position_id','=','position.position_id')->orderBy('ad_id','desc')
        ->where('ad.position_id',$position_id)
        ->paginate(8);
        
        return view('admin/ad/index',['ad'=>$ad]);
    }


    //生成广告
    public function createhtml($position_id){
        $position = Position::find($position_id);
        // dd($position);
        if($position->template==1){
            $ad = Ad::where('position_id',$position_id)->value('ad_img');
            // dd($ad);
            $template = 'onepic';
        }elseif($position->template==2){
            $ad = Ad::where('position_id',$position_id)->pluck('ad_img');

            $template = 'morepic';
        }

        $content = view('admin.ad.lib.'.$template,['ads'=>$ad,'width'=>$position->ad_width,'height'=>$position->ad_height])->render();
        // dd($content);
        $filename =  resource_path('views/index/ads/'.$position_id.'.blade.php');
        $res = file_put_contents($filename,$content);
        if($res){
            echo "<script>alert('生成成功!!!');history.go(-1);</script>";
        }
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
        //
    }
}
