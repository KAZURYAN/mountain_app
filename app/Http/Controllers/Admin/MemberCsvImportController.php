<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MembersImport;
use App\Member;

class MemberCsvImportController extends Controller
{
    public function index(){

      $members = Member::all();
      return view('admin.members.index',compact('members'));

    }

    public function upload(Request $request){

      $file = $request->file('csv_file');
      Member::truncate();
      Excel::import(new MembersImport, $file);

    }


    // public function index()
    // {
    //     $members = Member::all();
    //     return view('admin.members.index',compact('members'));
    // }
    //
    // public function upload(Request $request)
    // {
    //     $this->validate($request, [
    //         'csv_file' => 'required|mimes:txt|max:1000'
    //     ]);
    //     $file = $request->file('csv_file');
    //
    //     // ファイルの読み込み
    //
    //     $reader = \Excel::load($file->getRealPath())->get();
    //     $rows = $reader->toArray();
    //
    //     // 一度削除してから保存
    //     Member::truncate();
    //     if(count($rows)){
    //         foreach ($rows as $row) {
    //             Member::firstOrCreate($row);
    //         }
    //     }
    //
    //     \Session::flash('flash_message', 'メンバー表を更新しました。');
    //     return redirect()->route('admin::members');
    // }
    //
    // public function download(){
    //     $Member = Member::get()->toArray();
    //     return \Excel::create('Member', function($excel) use ($Member) {
    //         $excel->sheet('sheet', function($sheet) use ($Member)
    //         {
    //             $sheet->fromArray($Member);
    //         });
    //     })->download('csv');
    // }
}
