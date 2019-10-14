@extends('layouts.mountain')
@section('title', '企画の新規投稿画面')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>企画投稿</h2>
                <form action="{{ action('Mountain\EventController@create') }}" method="post" enctype="multipart/form-data">
                    @if (count($errors) > 0)
                        <ul>
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="form-group row">
                        <label class="col-md-2" for="from_date">開始日</label>
                        <div class="col-md-10">
                            <input type="date" class="form-control" name="from_date" value="{{ old('from_date') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2" for="to_date">終了日</label>
                        <div class="col-md-10">
                            <input type="date" class="form-control" name="to_date" value="{{ old('to_date') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2" for="planner">企画者</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="planner" value="{{ old('planner') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2" for="content">企画詳細</label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="content" rows="20">{{ old('content') }}</textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2" for="content">山名（山小屋名等）</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="mountain_name" value="{{ old('mountain_name') }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2" for="mountain_tag">山域</label>

                        @if (count($tags) > 0)
                            <ul>
                                @foreach($tags->all() as $t)
                                    <!-- <li>{{ $t->name }}</li> -->
                                    <input name="mountain_tag[]" type="checkbox" value="{{ $t->id }}">{{ $t->name }}
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <div class="form-group row">
                      <label class="col-md-2" for="mountain_tag">参加者</label>
                        <div id="input_pluralBox" class="col-md-10">
                            <div id="input_plural">
                                <input class="search_name" name ="participant[]" type="text" class="form-control" placeholder="参加者を入力">
                                <input type="button" value="＋" class="add pluralBtn">
                                <input type="button" value="－" class="del pluralBtn">
                            </div>
                        </div>
                    </div>

                    {{ csrf_field() }}
                    <input type="submit" class="btn btn-primary" value="更新">
                </form>
                <br>
                <button class="btn btn-primary"><a class="text-white" href={{action('Mountain\EventController@index')}}>戻る</a></button>
            </div>
        </div>
    </div>
@endsection

@include('common.autochangeform')
@include('common.autocomplete_member')
