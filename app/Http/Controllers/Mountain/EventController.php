<?php

namespace App\Http\Controllers\Mountain;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use App\Event;
use App\Member;
use App\Tag;
use App\EventTag;
use App\EventMember;
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

        //フォーム情報を取得
        $form = $request->all();
        $tags = $request->input('mountain_tag');
        $participant = $request->input('participant');

        //参加者の配列を準備
        $members = [];

        //新規投稿時に入力した参加者を1人ずつ取得する
        foreach ($participant as $pat) {
          $mem = Member::where('name' , $pat)->get();

          //1人を取得して、その取得した参加者のmember_idを指定し、配列に格納する
          foreach ($mem as $value) {
            $members[] = $value->id;
          }
        }

        //フォームから送信されてきたmountain_tagを削除する（Eventテーブルに山域は保存しないため）
        unset($form['mountain_tag']);

        // フォームから送信されてきたparticipantを削除する（Eventテーブルに参加者は保存しないため）
        unset($form['participant']);

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

          //event_membersテーブルを更新する
          //Event_idに対してどれだけの参加者がいたかのデータを保存する
          $Event->members()->sync($members);

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
        $cond_planner = $request->cond_planner;

        if ($cond_content != "" && $cond_planner != ""){
          $events = Event::where('content' , 'LIKE' , "%{$cond_content}%")->where('planner' , 'LIKE' , "%{$cond_planner}%")->get();

        }elseif ($cond_content != "" && $cond_planner == ""){
          $events = Event::where('content' , 'LIKE' , "%{$cond_content}%")->get();

        }elseif ($cond_content == "" && $cond_planner != ""){
          $events = Event::where('planner' , 'LIKE' , "%{$cond_planner}%")->get();

        }else {
          $events = Event::all();
        }

        return view('mountain.event.index' , ['events' => $events , 'cond_content' => $cond_content ,'cond_planner' => $cond_planner]);
    }

    public function search(Request $request)
    {
          $search = $request->get('term');

          $result = Event::where('planner', 'LIKE', '%'. $search. '%')->distinct()->select('planner')->get();

          return response()->json($result);

    }

    //企画に参加したメンバーを登録するための、オートコンプリート用アクション
    // public function search_member(Request $request)
    // {
    //       $search_member = $request->get('term');
    //
    //       $result = Member::where('name', 'LIKE', '%'. $search_member. '%')->distinct()->select('name')->get();
    //
    //       return response()->json($result);
    //
    // }

    public function show(Request $request){

        $tags = Tag::all();
        $event = Event::find($request->id);

        //$tag_members:空配列を宣言。企画に登録されているタグを保持。なお空宣言しておくことで、blade側でタグの領域がブランク表示となるようにしておく（エラー回避）。
        //members:     空配列を宣言。企画に参加した参加者を保持。なお空宣言しておくことで、blade側で参加者の領域がブランク表示となるようにしておく（エラー回避）。
        $tag_names = [];
        $members = [];

        //チェックされているタグ名のみを取得
        //なお、$event->tagsにて中間テーブルを経由してタグテーブルのデータを取得している
        foreach ($event->tags as $tag) {
          $tag_names[] = $tag->name;
        }

        //中間テーブル経由で参加者を取得する
        //$event->membersにて中間テーブルを経由
        foreach ($event->members as $member) {
          $members[] = $member->name;
        }

        return view('mountain.event.show' , ['event' => $event, 'tags' => $tags , 'tag_names'  => $tag_names , 'members'  => $members] );
    }

    public function edit(Request $request){

        //全てのタグを取得
        $tags = Tag::all();

        //チェックされているタグを、イベントidを条件に取得する
        $check_tags = EventTag::where('event_id' , $request->id)->get();

        //企画を取得する
        $event = Event::find($request->id);

        $chk_tags = [];

        //タグidを配列に書くのする。
        //チェックされているタグを、blade側でデフォルトでチェック付与するために、タグidを配列に格納
        foreach ($check_tags->all() as $value) {
          $chk_tags[] = $value->tag_id;
        }

        //参加者を中間テーブル経由で取得する。

        $members = [];

        foreach ($event->members as $member) {
          $members[] = $member->name;
        }

        if(empty($event)){
          abort(404);
        }

        return view('mountain.event.edit' ,['event' => $event , 'tags' => $tags , 'chk_tags' => $chk_tags , 'members' => $members ]);
    }

    public function update(Request $request){

         //バリデーションチェックの実施
         $this->validate($request , Event::$rules);

         //更新するイベントを特定する
         $event = Event::find($request->id);

         //edit画面で登録したフォームデータを全て格納
         $event_form = $request->all();

         //フォームデータの内、mountain_tagのみ取得して格納する
         $tags = $request->input('mountain_tag');

         //フォームデータの内、participant（参加者）のみ取得して格納する
         $participant = $request->input('participant');

         //参加者の配列を準備
         $members = [];

         //編集時に入力した参加者を1人ずつ取得する
         foreach ($participant as $pat) {
           $mem = Member::where('name' , $pat)->get();

           //1人を取得して、その取得した参加者のmember_idを指定し、配列に格納する
           foreach ($mem as $value) {
             $members[] = $value->id;
           }
         }

         //$event_formにはmountain_tag属性が不要のため削除（テーブルに該当項目がないため）
         unset($event_form['mountain_tag']);

         unset($event_form['participant']);

         unset($event_form['_token']);
         // unset($news_form['remove']);

         DB::beginTransaction();
         try{
           $event->fill($event_form)->save();
           // $Event->fill($tags)->save();
           $event->tags()->sync($tags);
           // $Event->tags()->attach($tags);

           //event_membersテーブルを更新する
           //Event_idに対してどれだけの参加者がいたかのデータを保存する
           $event->members()->sync($members);

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

        //削除する企画を取得
        $event = Event::find($request->id);

        //削除する企画に紐づいて登録されているタグの削除を行うために、企画に登録されているタグを特定
        $event_tag = EventTag::where('event_id','=',$event->id);

        //削除する企画に紐づいて登録されている参加者の削除を行うために、企画に登録されているタグを特定
        $event_member = EventMember::where('event_id','=',$event->id);

        //削除実行
        $event->delete();
        $event_tag->delete();
        $event_member->delete();

        return redirect('mountain/event/');

    }
}
