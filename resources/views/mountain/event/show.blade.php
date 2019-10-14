@extends('layouts.mountain')
@section('title', '企画詳細')

<!-- googlemapを読み込むためのjs -->
@include('common.googlemap')

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
                            <input type="text" id="mountain_name" class="form-control" name="mountain_name" value="{{ $event->mountain_name }}" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                    <label class="col-md-2" for="mountain_tag">山域</label>

                      <div class="col-md-10">
                        @if (count($tag_names) > 0)
                            <ul>
                                @foreach($tag_names as $t)
                                  <a class="btn btn-primary" href="#" role="button" style="pointer-events: none;">{{$t}}</a>
                                  <!-- <input name="mountain_tag[]" type="hidden"  readonly>{{ $t }} -->
                                @endforeach
                            </ul>
                        @endif
                      </div>
                    </div>

                    <div class="form-group row">
                    <label class="col-md-2" for="mountain_tag">参加者</label>

                      <div class="col-md-10">
                        @if (count($members) > 0)
                            <ul>
                                @foreach($members as $m)
                                  <a class="btn btn-primary" href="#" role="button" style="pointer-events: none;">{{$m}}</a>
                                  <!-- <input name="mountain_tag[]" type="hidden"  readonly>{{ $t }} -->
                                @endforeach
                            </ul>
                        @endif
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-md-2" for="mountain_tag">地図</label>

                      <div class="col-md-10">
                        <div id="map" style="width: 600px; height: 500px;"></div>
                      </div>
                    </div>

                    <div class="form-group row">
                      <div class="col-md-12">
                        <button class="btn btn-primary"><a class="text-white" href={{action('Mountain\EventController@index')}}>戻る</a></button>
                      </div>
                    </div>
            </div>
        </div>
    </div>
@endsection
