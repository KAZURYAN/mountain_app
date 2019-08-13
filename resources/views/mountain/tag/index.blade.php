@extends('layouts.mountain')
@section('title', '山域（タグ）の一覧')

@section('content')
    <div class="container">
        <div class="row">
            <h2>山域（タグ）一覧</h2>
        </div>
        <div class="row">
            <div class="col-md-4">
                  <a href="{{ action('Mountain\TagController@add') }}" role="button" class="btn btn-primary">新規作成</a>
            </div>
            <div class="col-md-8">
                <form action="{{ action('Mountain\TagController@index') }}" method="get">
                    <div class="form-group row">
                        <label class="col-md-2">山域検索</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="cond_name" value="{{ $cond_name }}">
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
                                <th width="80%">山域名</th>
                                <th width="10%">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tags as $tag)
                                <tr>
                                    <th>{{ $tag->id }}</th>
                                    <td>{{ str_limit($tag->name, 50) }}</td>
                                    <td>
                                      <div>
                                            <a href="{{ action('Mountain\TagController@edit', ['id' => $tag->id]) }}">編集</a>
                                      </div>
                                      <div>
                                            <a href="{{ action('Mountain\TagController@delete', ['id' => $tag->id]) }}">削除</a>
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
