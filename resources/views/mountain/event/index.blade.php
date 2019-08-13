@extends('layouts.mountain')
@section('title', '登録済みニュースの一覧')

@section('content')
    <div class="container">
        <div class="row">
            <h2>ニュース一覧</h2>
        </div>
        <div class="row">
            <div class="col-md-4">
                  <a href="{{ action('Mountain\EventController@add') }}" role="button" class="btn btn-primary">新規作成</a>
            </div>
            <div class="col-md-8">
                <form action="{{ action('Mountain\EventController@index') }}" method="get">
                    <div class="form-group row">
                        <label class="col-md-2">過去の企画検索</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="cond_content" value="{{ $cond_content }}">
                        </div>
                        <div class="col-md-2">
                            {{ csrf_field() }}
                            <input type="submit" class="btn btn-primary" value="検索">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="list-news col-md-12 mx-auto">
                <div class="row">
                    <table class="table table-dark">
                        <thead>
                            <tr>
                                <th width="10%">ID</th>
                                <th width="15%">企画日（開始日）</th>
                                <th width="15%">企画日（終了日）</th>
                                <th width="15%">企画者</th>
                                <th width="35%">企画詳細</th>
                                <th width="10%">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($events as $event)
                                <tr>
                                    <th>{{ $event->id }}</th>
                                    <td>{{ str_limit($event->from_date, 50) }}</td>
                                    <td>{{ str_limit($event->end_date, 50) }}</td>
                                    <td>{{ str_limit($event->plnanner, 50) }}</td>
                                    <td>{{ str_limit($event->content, 250) }}</td>
                                    <td>
                                      <div>
                                            <a href="{{ action('Mountain\EventController@edit', ['id' => $event->id]) }}">編集</a>
                                      </div>
                                      <div>
                                            <a href="{{ action('Mountain\EventController@delete', ['id' => $event->id]) }}">削除</a>
                                      </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
