<?php

namespace App\Http\Controllers\Mountain;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use App\Event;
use App\Tag;
use App\EventTag;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function add(){

      $tags = Tag::all();

      //resources/view/mountain/event配下のcreate.blade.phpへと遷移させるの意味。
      return view('mountain.event.create' , ['tags' => $tags]);
    }

    public function create(Request $request){
      $this->validate($request, Event::$rules);

      //ユーザーIDを取得
      $id = Auth::id();

      $Event = new Event;
      $form = $request->all();
      $tags = $request->input('mountain_tag');

      // フォームから送信されてきたmountain_tagを削除する（Eventテーブルに山域は保存しないため）
      unset($form['mountain_tag']);
      // フォームから送信されてきた_tokenを削除する
      unset($form['_token']);

      //データベースへの保存を実行する.なおEvent.user_idにはログインIDをセットする。
      $Event->user_id = $id;
      $Event->fill($form);

      DB::beginTransaction();
      try{
        $Event->save();

        //event_tagsテーブルを更新する
        //Event_idに対してどれだけの山域を付与したかのデータが残る。
        $Event->tags()->sync($tags);

        // $Event->tags()->attach($tags);
        DB::commit();

        //手動でDB更新を１件ずつ実行
        // foreach ($tags as $tagId) {
        //   $EventTag = new EventTag;
        //   $EventTag->tag_id = $tagId;
        //   $EventTag->event_id = $Event->id;
        //   $EventTag->save();
        // }
      }catch (\Exception $e){
        dd($e);
        DB::rollback();
      }

      //resources/view/mountain/event配下のcreate.blade.phpへと遷移させるの意味。
      return redirect('/mountain/event');
      // return view('mountain.event.create');
    }

    public function index(Request $request){

      $cond_content = $request->cond_content;

      if ($cond_content != ""){
        //検索されたら検索結果を取得する
        $events = Event::where('content' , 'LIKE' , "%{$cond_content}%")->get();
      }else{
        $events = Event::all();
      }

      return view('mountain.event.index' , ['events' => $events , 'cond_content' => $cond_content]);
    }

    public function show(Request $request){
      $tags = Tag::all();
      $event = Event::find($request->id);

      return view('mountain.event.show' , ['event' => $event, 'tags' => $tags] );
    }

    public function edit(Request $request){

      $tags = Tag::all();
      // $check_tags = EventTag::select('tag_id')->where('event_id' , $request->id)->get();
      $check_tags = EventTag::where('event_id' , $request->id)->get();
      $event = Event::find($request->id);

      $chk_tags = [];

      foreach ($check_tags->all() as $value) {
        $chk_tags[] = $value->tag_id;
      }

      if(empty($event)){
        abort(404);
      }

      return view('mountain.event.edit' ,['event' => $event , 'tags' => $tags , 'chk_tags' => $chk_tags ]);
    }

    public function update(Request $request){

       $this->validate($request , Event::$rules);
       $event = Event::find($request->id);
       $event_form = $request->all();

       $tags = $request->input('mountain_tag');
       // dd($event_form);

       unset($event_form['mountain_tag']);

       unset($event_form['_token']);
       // unset($news_form['remove']);

       DB::beginTransaction();
       try{
         $event->fill($event_form)->save();
         // $Event->fill($tags)->save();
         $event->tags()->sync($tags);
         // $Event->tags()->attach($tags);
         DB::commit();

         //手動でDB更新を１件ずつ実行
         // foreach ($tags as $tagId) {
         //   $EventTag = new EventTag;
         //   $EventTag->tag_id = $tagId;
         //   $EventTag->event_id = $Event->id;
         //   $EventTag->save();
         // }
       }catch (\Exception $e){
         dd($e);
         DB::rollback();
       }

       return redirect('mountain/event');

    }

    public function delete(Request $request){

      $event = Event::find($request->id);

      $event->delete();

      return redirect('mountain/event/');

    }
}
