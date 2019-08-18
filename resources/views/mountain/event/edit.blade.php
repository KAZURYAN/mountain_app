@extends('layouts.mountain')
@section('title', '企画の編集')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>企画の編集</h2>
                <form action="{{ action('Mountain\EventController@update') }}" method="post" enctype="multipart/form-data">
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
                            <input type="date" class="form-control" name="from_date" value="{{ $event_form->from_date }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2" for="to_date">終了日</label>
                        <div class="col-md-10">
                            <input type="date" class="form-control" name="to_date" value="{{ $event_form->to_date }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2" for="planner">企画者</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="planner" value="{{ $event_form->planner }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2" for="content">企画詳細</label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="content" rows="20">{{ $event_form->content }}</textarea>
                        </div>
                    </div>

                    <label class="col-md-2" for="mountain_tag">山域</label>

                    @if (count($tags) > 0)
                        <ul>
                            @foreach($tags->all() as $t)
                              <input name="mountain_tag[]" type="checkbox" value="{{ $t->id }}" @if (is_array("$check_tags->tag_id") && in_array("$t->id" ,"$check_tags->tag_id", true)) checked="checked" @endif>{{ $t->name }}
                              <!-- <li>{{ $t->name }}</li> -->
                            @endforeach
                        </ul>
                    @endif

                    <div class="form-group row">
                        <div class="col-md-10">
                            <input type="hidden" name="id" value="{{ $event_form->id }}">
                            {{ csrf_field() }}
                            <input type="submit" class="btn btn-primary" value="更新">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
