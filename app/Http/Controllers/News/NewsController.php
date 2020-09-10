<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Type;
use App\Models\News;
use Illuminate\Support\Facades\Redis;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $news = News::leftjoin('type','news.type_id','=','type.type_id')->orderBy('news_id','desc')->paginate(2);

        if(request()->ajax()){
            return view('news/ajaxpaginate',['news'=>$news]);
        }
        //dd($news);
        return view('news/list',['news'=>$news]);
    }

    public function product(Request $request, $id){
        $man = request()->session()->get('user.user_name');
        //dd($man);
        $count=Redis::setnx('count_'.$id,1)?:Redis::incr('count_'.$id);
        //dd($count);
        $news = News::where('news_id',$id)->first();
        return view('news/product',['news'=>$news,'count'=>$count,'man'=>$man]);
    }   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $type = Type::all();
        return view('news/create',['type'=>$type]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->hasfile("news_img")){
            $news_img=$this->upload("news_img");
        }
        $news = new News;
        $news->title = $request->title;
        $news->type_id = $request->type_id;
        if(isset($news_img)){
            $news->news_img = $news_img;
        }
        $news->desc = $request->desc;
        $news->content = $request->content;
        $news->news_man = $request->news_man;
        $news->news_time = time();

        $res = $news->save();
        //dd($res);
        if($res){
            return redirect('news/list');
        }
    }

    public function upload($filename){
        $file=request()->file($filename);
        if($file->isValid()){
            $path=$file->store('uploads');
            return $path;
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
        //
    }
}
