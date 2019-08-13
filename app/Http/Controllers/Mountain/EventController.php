<?php

namespace App\Http\Controllers\Mountain;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use App\Event;
use Carbon\Carbon;

class EventController extends Controller
{
    public function add(){
      //resources/view/mountain/event配下のcreate.blade.phpへと遷移させるの意味。
      return view('mountain.event.create');
    }

    public function create(Request $request){
      $this->validate($request, Event::$rules);

      //ユーザーIDを取得
      $id = Auth::id();

      $Event = new Event;
      $form = $request->all();

      // フォームから送信されてきた_tokenを削除する
      unset($form['_token']);

      //データベースへの保存を実行する.なおEvent.user_idにはログインIDをセットする。
      $Event->user_id = $id;
      $Event->fill($form);
      $Event->save();

      //resources/view/mountain/event配下のcreate.blade.phpへと遷移させるの意味。
      return view('mountain.event.create');
    }

    public function index(Request $request){

      $cond_content = $request->cond_content;

      if ($cond_content != ""){
        //検索されたら検索結果を取得する
        $events = Event::where('content' , $cond_content)->get();
      }else{
        $events = Event::all();
      }

      return view('mountain.event.index' , ['events' => $events , 'cond_content' => $cond_content]);

    }

    public function edit(Request $request){

      $event = Event::find($request->id);

      if(empty($event)){
        abort(404);
      }

      return view('mountain.event.edit' ,['event_form' => $event]);
    }

    public function update(Request $request){

       $this->validate($request , Event::$rules);
       $event = Event::find($request->id);
       $event_form = $request->all();

       unset($event_form['_token']);
       // unset($news_form['remove']);
       $event->fill($event_form)->save();

       return redirect('mountain/event');

    }

    public function delete(Request $request){

      $event = Event::find($request->id);

      $event->delete();

      return redirect('mountain/event/');

    }
}
