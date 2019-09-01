@extends('layouts.mountain')
@section('title', '企画詳細')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>企画詳細</h2>
                    <div class="form-group row">
                        <label class="col-md-2" for="from_date">開始日</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="from_date" value="{{ $event->from_date }}" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2" for="to_date">終了日</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="to_date" value="{{ $event->to_date }}" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2" for="planner">企画者</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="planner" value="{{ $event->planner }}" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2" for="content">企画詳細</label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="content" rows="20" readonly>{{ $event->content }}</textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2" for="mountain_name">山名（山小屋名等）</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="mountain_name" value="{{ $event->mountain_name }}" readonly>
                        </div>
                    </div>

                    <label class="col-md-2" for="mountain_tag">山域</label>

                    @if (count($tags) > 0)
                        <ul>
                            @foreach($tags->all() as $t)
                              <input name="mountain_tag[]" type="hidden" value="{{ $t->id }}">{{ $t->name }}
                              <!-- <li>{{ $t->name }}</li> -->
                            @endforeach
                        </ul>
                    @endif
              <button class="btn btn-primary"><a class="text-white" href={{action('Mountain\EventController@index')}}>戻る</a></button>

            </div>
        </div>
    </div>
@endsection
