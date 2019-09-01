<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class GmapsController extends Controller
{
    /**
    * Google Map 画面表示機能
    */
    public function view()
    {
        // データーベースなどから表示したい住所を取得。
        // 本記事では「東京都庁」の住所を固定で設定する。
        $address = "雲ノ平山荘";

        // 取得した住所を利用して、画面（ビュー）を作成
        return view('gmaps/view', compact('address'));
    }
}
