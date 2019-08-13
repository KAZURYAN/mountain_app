<?php

namespace App\Http\Controllers\Mountain;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Tag;
use Carbon\Carbon;

class TagController extends Controller
{
  public function add(){
    //resources/view/mountain/tag配下のcreate.blade.phpへと遷移させるの意味。
    return view('mountain.tag.create');
  }

  public function create(Request $request){
    $this->validate($request, Tag::$rules);

    $tag = new Tag;
    $form = $request->all();

    // フォームから送信されてきた_tokenを削除する
    unset($form['_token']);

    $tag->fill($form);
    $tag->save();

    //resources/view/mountain/tag配下のcreate.blade.phpへと遷移させるの意味。
    return view('mountain.tag.create');
  }

  public function index(Request $request){

    $cond_name = $request->cond_name;

    if ($cond_name != ""){
      //検索されたら検索結果を取得する
      $tags = Tag::where('name' , $cond_name)->get();
    }else{
      $tags = Tag::all();
    }

    return view('mountain.tag.index' , ['tags' => $tags , 'cond_name' => $cond_name]);

  }

  public function edit(Request $request){

    $tag = Tag::find($request->id);

    if(empty($tag)){
      abort(404);
    }

    return view('mountain.tag.edit' ,['tag_form' => $tag]);
  }

  public function update(Request $request){

     $this->validate($request , Tag::$rules);
     $tag = Tag::find($request->id);
     $tag_form = $request->all();

     unset($tag_form['_token']);
     // unset($news_form['remove']);
     $tag->fill($tag_form)->save();

     return redirect('mountain/tag/');

  }

  public function delete(Request $request){

    $tag = Tag::find($request->id);

    $tag->delete();

    return redirect('mountain/tag/');

  }
}
